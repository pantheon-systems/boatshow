<?php

namespace Drupal\nmma_migrate\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\nmma_migrate\Redirect;
use Drush\Commands\DrushCommands;
use Drupal\nmma_migrate\File;
use Drush\Exceptions\UserAbortException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class NmmaMigrateCommands extends DrushCommands {

  /**
   * Access nodes entities.
   *
   * @var \Drupal\node\NodeStorage
   */
  protected $nodeStorage;

  /**
   * Access taxonomy term entities.
   *
   * @var \Drupal\taxonomy\TermStorage
   */
  protected $termStorage;

  /**
   * The NMMA migrate file service.
   *
   * @var \Drupal\nmma_migrate\File
   */
  protected $file;

  /**
   * The redirect entity storage.
   *
   * @var \Drupal\Core\Entity\Sql\SqlContentEntityStorage
   */
  protected $redirectStorage;

  /**
   * The redirect service.
   *
   * @var \Drupal\nmma_migrate\Redirect
   */
  protected $redirect;

  /**
   * The HTTP Kernel.
   *
   * @var \Symfony\Component\HttpKernel\HttpKernelInterface
   */
  protected $httpKernel;

  /**
   * The current request.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * The session service.
   *
   * @var \Symfony\Component\HttpFoundation\Session\Session
   */
  protected $session;

  /**
   * Constructs a NmmaMigrateCommands object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity type manager.
   * @param \Drupal\nmma_migrate\File $file
   *   The NMMA migrate file service.
   * @param \Drupal\nmma_migrate\Redirect $redirect
   *   The redirect service.
   * @param \Symfony\Component\HttpKernel\HttpKernelInterface $http_kernel
   *   The HTTP Kernel.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Current request.
   * @param \Symfony\Component\HttpFoundation\Session\Session $session
   *   The session service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   *   If node storage is not available.
   */
  public function __construct(EntityTypeManagerInterface $entity_manager, File $file, Redirect $redirect, HttpKernelInterface $http_kernel, RequestStack $request_stack, Session $session) {
    $this->nodeStorage = $entity_manager->getStorage('node');
    $this->termStorage = $entity_manager->getStorage('taxonomy_term');
    $this->redirectStorage = $entity_manager->getStorage('redirect');
    $this->file = $file;
    $this->redirect = $redirect;
    $this->httpKernel = $http_kernel;
    $this->request = $request_stack->getCurrentRequest();
    $this->session = $session;
  }

  /**
   * Create a subrequest with its response.
   *
   * @param string $relativePath
   *   The path to a local page.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The response.
   *
   * @throws \Exception
   *   When an Exception occurs during processing.
   */
  protected function subRequest($relativePath) {
    // Calling so many HTTP requests can get you banned, quick.
    parse_str(parse_url($relativePath, PHP_URL_QUERY), $parameters);
    $subrequest = Request::create(parse_url($relativePath, PHP_URL_PATH), 'GET', $parameters, $this->request->cookies->all(), [], $this->request->server->all());
    // TODO: remove work-around after
    // https://www.drupal.org/project/drupal/issues/2860341 is fixed.
    if (!$subrequest->hasSession()) {
      $subrequest->setSession($this->session);
      $this->session->start();
    }
    /** @var \Drupal\Core\Render\HtmlResponse $response */
    $response = $this->httpKernel->handle($subrequest, HttpKernelInterface::SUB_REQUEST);
    if ($response->getStatusCode() === 404) {
      $this->logger()
        ->alert(dt('@url resulted in a 404. Create a redirect for this URL and run again if needed.', ['@url' => $relativePath]));
    }
    return $response;
  }

  /**
   * Takes a response object and gets the redirection location.
   *
   * @param \Symfony\Component\HttpFoundation\Response $response
   *   A response.
   *
   * @return string|bool
   *   Returns the relative path to the redirect or false on non-redirect.
   */
  protected function getRedirectionLocation(Response $response) {
    if ($response->isRedirection()) {
      return $this->createRelativeUrl($response->headers->get('Location'));
    }
    return FALSE;
  }

  /**
   * Boat types images.
   *
   * @command nmma_migrate:boat-types-images
   */
  public function boatTypesImages() {
    $imageSourceUrlPattern = 'https://discoverboating.s3.amazonaws.com/boat-selector/boat-details/%s/%s';
    $srcFile = drupal_get_path('module', 'nmma_migrate') . '/json/boat_types_images_en.json';
    if (!is_file($srcFile)) {
      $this->logger()
        ->critical(dt('@file does not exist.', ['@file' => $srcFile]));
    }
    $boatTypesImages = json_decode(file_get_contents($srcFile), TRUE);
    if (empty($boatTypesImages)) {
      $this->logger()
        ->critical(dt('There were no boat types images found in @file.', ['@file' => $srcFile]));
    }
    $terms = $this->termStorage->loadTree('boat_types');
    if (empty($terms)) {
      $this->logger()
        ->critical(dt('There are no boat type terms imported yet.'));
    }
    // Go through each image in the JSON file and figure out which term it
    // should be attached to.
    foreach ($boatTypesImages as $boatTypesImage) {
      // Get the term that is tied to this image.
      $boatTypeTerms = $this->termStorage->getQuery()
        ->condition('field_boat_type_nmma_id', $boatTypesImage['BoatTypeId'])
        ->execute();
      if (empty($boatTypeTerms)) {
        $this->logger()
          ->warning(dt('Unable to find a boat term with source ID of @sourceId.', ['@sourceId' => $boatTypesImage['BoatTypeId']]));
        continue;
      }
      $boatTypeTerm = $this->termStorage->load(reset($boatTypeTerms));
      /** @var \Drupal\file\Plugin\Field\FieldType\FileFieldItemList $savedImages */
      $savedImages = $boatTypeTerm->get('field_boat_type_carousel_images');
      $savedImagesArray = [];
      /** @var \Drupal\image\Plugin\Field\FieldType\ImageItem $savedImage */
      // Get all the images currently saved to the boat type.
      foreach ($savedImages as $savedImage) {
        $savedImagesArray[] = $savedImage->getValue();
      }
      $imageSourceUrl = sprintf($imageSourceUrlPattern, $boatTypesImage['BoatTypeId'], $boatTypesImage['Name']);
      $fileName = str_replace('/', '--', $boatTypesImage['Name']);

      $imageMedia = $this->file->remoteImageToMediaImage($imageSourceUrl, $fileName, $boatTypesImage['Name'], 'public://migrate-boat-types-images', $fileName);
      $savedImagesArray[] = $imageMedia->id();

      $boatTypeTerm->set('field_boat_type_carousel_images', $savedImagesArray);
      $boatTypeTerm->save();
    }
  }

  /**
   * Delete redirects.
   *
   * @param string $rid
   *   All redirects greater than this will be deleted.
   *
   * @command nmma_migrate:delete-redirects
   */
  public function deleteRedirects($rid) {
    $query = $this->redirectStorage->getQuery()
      ->condition('rid', $rid, '>');
    $rids = $query->execute();
    $this->logger()
      ->notice(dt('Deleted @count redirects.', ['@count' => count($rids)]));
    $grouped_rids = [];
    $index = 0;
    foreach ($rids as $rid) {
      if (empty($grouped_rids[$index])) {
        $grouped_rids[$index] = [];
      }
      elseif (count($grouped_rids[$index]) === 20) {
        $index++;
      }
      $grouped_rids[$index][] = $rid;
    }
    foreach ($grouped_rids as $rids) {
      $this->redirectStorage->delete($this->redirectStorage->loadMultiple($rids));
    }
  }

  /**
   * Determine if the given URL is a file or not.
   *
   * @param string $url
   *   A full URL.
   *
   * @return bool
   *   True if a URL.
   */
  protected function isFileUrl($url) {
    $path = parse_url($url, PHP_URL_PATH);
    if (in_array(substr($path, strrpos($path, '.') + 1), [
      'jpg',
      'png',
      'jpeg',
      'pdf',
    ])) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Create a path a relative path.
   *
   * @param string $url
   *   A URL.
   *
   * @return bool|string
   *   The relative path or false if invalid URL.
   */
  protected function createRelativeUrl($url) {
    $parsed_url = parse_url($url);
    if (FALSE === $parsed_url) {
      return FALSE;
    }
    $relative_url = '';
    if (!empty($parsed_url['path'])) {
      $relative_url .= $parsed_url['path'];
      if (!empty($parsed_url['query'])) {
        $relative_url .= ('?' . $parsed_url['query']);
      }
      if (!empty($parsed_url['fragment'])) {
        $relative_url .= ('#' . $parsed_url['fragment']);
      }
    }
    // Ensure a preceding /.
    if (substr($relative_url, 0, 1) !== '/') {
      $relative_url = '/' . $relative_url;
    }
    return $relative_url;
  }

  /**
   * Allow a process to be skipped without quitting.
   *
   * @return bool
   *   True they want to continue.
   *
   * @throws \Drush\Exceptions\UserAbortException
   *   If they don't want to continue.
   */
  protected function promptSkip() {
    if (TRUE === $this->io()->confirm('If the previous error is un-resolvable, you can skip this item for now')) {
      return TRUE;
    }
    else {
      throw new UserAbortException();
    }
  }

  /**
   * Get the final relative path of a given relative path.
   *
   * @param string $url
   *   A relative path.
   *
   * @return string
   *   The final relative path of the $url.
   */
  protected function getLocalRedirectedUrl($url) {
    $redirectionUrl = $this->getRedirectionLocation($this->subRequest($url));
    if (FALSE !== $redirectionUrl) {
      $url = $redirectionUrl;
    }
    return $this->createRelativeUrl($url);
  }

  /**
   * Image article links.
   *
   * @param string $url
   *   The URL.
   *
   * @command nmma_migrate:local-redirect-url
   */
  public function localRedirectUrl($url) {
    return $this->getLocalRedirectedUrl($url);
  }

  /**
   * Image article links.
   *
   * @command nmma_migrate:article-links
   */
  public function articleLinks() {
    $this->logger()->notice(dt('Retrieving articles.'));
    $query = $this->nodeStorage->getQuery()
      ->condition('type', 'article');
    $entity_ids = $query->execute();
    $articleCnt = 0;
    $linkCnt = 0;
    foreach ($entity_ids as $entity_id) {
      /** @var \Drupal\node\Entity\Node $node */
      $node = $this->nodeStorage->load($entity_id);
      $value = $node->get('field_article_body')->getValue()[0]['value'];
      $dom = $this->newDomDocument($value);
      $linkTags = $dom->getElementsByTagName('a');
      // Only save the dom back if a hyperlink was replaced in the body.
      $replacedLink = FALSE;
      /** @var \DOMElement $linkTag */
      foreach ($linkTags as $linkTag) {
        $href = $linkTag->getAttribute('href');
        // Detect if the link has already been processed to a redirect or if
        // this is a locally linking item.
        if ($linkTag->hasAttribute('data-redirect-processed') || FALSE !== strstr($href, '/sites/')) {
          continue;
        }
        $url = $this->normalizeUrl($href);
        if (strlen($url)) {
          if ($this->isFileUrl($url)) {
            $fileName = $this->fileNameFromUrl($url);
            try {
              $file = $this->file->remoteImageToFile($url, 'public://migrate-article-images', $fileName);
              $fileIds[] = $file->id();
            }
            catch (\Exception $exception) {
              $this->logger()->error($exception->getMessage());
              if ($this->promptSkip()) {
                continue;
              }
              return;
            }
            $new_url = file_url_transform_relative($file->url());
            $linkTag->setAttribute('href', $new_url);
            if (FALSE == $replacedLink) {
              $articleCnt++;
            }
            $linkCnt++;
          }
          // If the link HREF is not a file, it must be a regular path.
          else {
            $redirected = FALSE;
            // Check if this legacy path is already redirected to someplace.
            $redirect = $this->redirect->getRedirectTarget($url);
            if (FALSE !== $redirect) {
              $new_url = $redirect->toString();
              $redirected = TRUE;
            }
            else {
              $new_url = $this->createRelativeUrl($url);
              if (FALSE === $new_url) {
                $this->logger()->error('Unable to create a relative URL for ' . $new_url);
                if ($this->promptSkip()) {
                  continue;
                }
                return;
              }
              else {
                $return = drush_invoke_process('@self', 'nmma_migrate:local-redirect-url', [$new_url]);
                $redirected_url = $return['object'];
                // $redirected_url = $this->getLocalRedirectedUrl($new_url);
                if ($redirected_url != $new_url) {
                  $redirected = TRUE;
                  $new_url = $redirected_url;
                }
              }
            }
            $linkTag->setAttribute('href', $new_url);
            if ($redirected) {
              $linkTag->setAttribute('data-redirect-processed', 1);
            }
            // If this link was not redirected and not changed.
            elseif ($href == $new_url) {
              $this->logger()
                ->notice(dt('Unable to process link "@link" with with a new URL in article @articleNid.', [
                  '@link' => $href,
                  '@articleNid' => $entity_id,
                ]));
              continue;
            }
            if (FALSE == $replacedLink) {
              $articleCnt++;
            }
            $linkCnt++;
          }
          $replacedLink = TRUE;
          $this->logger()
            ->notice(dt('Replacing the link "@link" with  with new URL of @url in the article ID of @articleNid.', [
              '@link' => $href,
              '@url' => $new_url,
              '@articleNid' => $entity_id,
            ]));
        }
      }
      if ($replacedLink) {
        $node = $this->nodeStorage->load($entity_id);
        $currentValue = $node->get('field_article_body')->getValue();
        // The updated dom will have all the wrapper tags around it, just get
        // the body tag content.
        $xpath = new \DOMXPath($dom);
        $body = $xpath->query('/html/body');
        $currentValue[0]['value'] = $dom->saveHTML($body->item(0));
        $node->set('field_article_body', $currentValue);
        $node->save();
      }
    }
    $this->logger()
      ->notice(dt('Processed @articleCnt articles and @linkCnt links.', [
        '@articleCnt' => $articleCnt,
        '@linkCnt' => $linkCnt,
      ]));
  }

  /**
   * Image article images.
   *
   * @command nmma_migrate:article-images
   */
  public function articleImages() {

    $this->logger()->notice(dt('Retrieving articles.'));
    $query = $this->nodeStorage->getQuery()
      ->condition('type', 'article');
    $entity_ids = $query->execute();
    $articleCnt = 0;
    $imageCnt = 0;
    foreach ($entity_ids as $entity_id) {
      /** @var \Drupal\node\Entity\Node $node */
      $node = $this->nodeStorage->load($entity_id);
      $value = $node->get('field_article_body')->getValue()[0]['value'];
      $dom = $this->newDomDocument($value);
      $imageTags = $dom->getElementsByTagName('img');
      // Only going to save the dom back if an image was replaced in the body.
      $replacedImage = FALSE;
      // All Media IDs that were created in this run.
      $mediaIds = [];
      /** @var \DOMElement $imageTag */
      foreach ($imageTags as $imageTag) {
        $src = $imageTag->getAttribute('src');
        $alt = $imageTag->getAttribute('alt');
        $title = $imageTag->getAttribute('title');
        $class = $imageTag->getAttribute('class');
        $align = '';
        if (FALSE !== strstr($class, 'right')) {
          $align = 'right';
        }
        elseif (FALSE !== strstr($class, 'left')) {
          $align = 'left';
        }
        elseif (FALSE !== strstr($class, 'center')) {
          $align = 'center';
        }
        elseif (FALSE !== strstr($class, 'middle')) {
          $align = 'center';
        }
        $url = $this->normalizeUrl($src);
        if (strlen($url)) {
          $fileName = $this->fileNameFromUrl($url);
          try {
            $imageMedia = $this->file->remoteImageToMediaImage($url, $alt, $title, 'public://migrate-article-images', $fileName);
            $mediaIds[] = $imageMedia->id();
          }
          catch (\Exception $exception) {
            $this->logger()->error($exception->getMessage());
            if ($this->promptSkip()) {
              continue;
            }
            return;
          }
          $newElement = $dom->createElement('drupal-entity');
          foreach (
            [
              'alt' => $alt,
              'title' => $title,
              'data-embed-button' => 'media_browser',
              'data-entity-embed-display' => 'media_image',
              'data-entity-type' => 'media',
              'data-entity-uuid' => $imageMedia->uuid(),
              'data-align' => $align,
            ] as $name => $value) {
            $newAttribute = $dom->createAttribute($name);
            $newAttribute->value = $value;
            $newElement->appendChild($newAttribute);
          }
          $imageTag->parentNode->replaceChild($newElement, $imageTag);
          if (FALSE == $replacedImage) {
            $articleCnt++;
          }
          $imageCnt++;
          $replacedImage = TRUE;
          $this->logger()
            ->notice(dt('Replacing the image "@image" with media entity ID @mediaId and file ID @fileId using the embed code "@embed" in the article ID of @articleNid.', [
              '@image' => $dom->saveHTML($imageTag),
              '@mediaId' => $imageMedia->id(),
              '@fileId' => $imageMedia->get('image')
                ->first()
                ->getValue()['target_id'],
              '@embed' => $dom->saveHTML($newElement),
              '@articleNid' => $entity_id,
            ]));
        }
      }
      if (TRUE === $replacedImage) {
        $node = $this->nodeStorage->load($entity_id);
        $currentValue = $node->get('field_article_body')->getValue();
        // The updated dom will have all the wrapper tags around it, just get
        // the body tag content.
        $xpath = new \DOMXPath($dom);
        $body = $xpath->query('/html/body');
        $currentValue[0]['value'] = $dom->saveHTML($body->item(0));
        $node->set('field_article_body', $currentValue);
        $imageValue = $node->get('field_article_image')->getValue();
        // If there is no article image yet, use the first media entity.
        if (empty($imageValue[0]['target_id'])) {

          if (empty($mediaIds)) {
            $this->logger()
              ->warning(dt('When re-saving the article with its new body, the array of media IDs was empty, which should never be the case.'));
          }
          else {
            $node->set('field_article_image', reset($mediaIds));
            $node->set('field_article_tsr_image', reset($mediaIds));
          }
        }
        $node->save();
      }
    }
    $this->logger()
      ->notice(dt('Processed @articleCnt articles and @imageCnt images.', [
        '@articleCnt' => $articleCnt,
        '@imageCnt' => $imageCnt,
      ]));
  }

  /**
   * Take URL, convert all relative / hosted images to locally saved files.
   *
   * Example:
   * drush nmma_migrate:save-remote-assets
   * https://local.nmma.test/storiesofdiscovery
   * modules/custom/nmma_custom_pages/assets/sod
   * .page-discovery >> output.html.
   *
   * @param string $url
   *   The path to content.
   * @param string $dir
   *   The directory to save the assets to.
   * @param string $wrapper
   *   The element that holds the portion of the page you want.
   *
   * @command nmma_migrate:save-remote-assets
   */
  public function saveRemoteAssets($url, $dir, $wrapper) {
    // Allow over self-signed cert.
    $arrContextOptions = [
      "ssl" => [
        "verify_peer" => FALSE,
        "verify_peer_name" => FALSE,
      ],
    ];
    $response = file_get_contents($url, FALSE, stream_context_create($arrContextOptions));
    if (FALSE === $response) {
      $this->logger()
        ->error(dt('Unable to retrieve the contents of the given URL.'));
      return;
    }
    $dom = $this->newDomDocument($response);
    $xpath = new \DOMXPath($dom);
    $xpath_query = NULL;
    if (substr($wrapper, 0, 1) === '.') {
      $class = substr($wrapper, 1);
      $xpath_query = '//*[contains(concat(" ", normalize-space(@class), " "), " ' . $class . '")]';
    }
    if (NULL !== $xpath_query) {
      $subdom = $xpath->query($xpath_query);
      $dom = $this->newDomDocument($dom->saveHTML($subdom->item(0)));
    }
    $imageTags = $dom->getElementsByTagName('img');
    foreach ($imageTags as $imageTag) {
      $src = $imageTag->getAttribute('src');
      $alt = $imageTag->getAttribute('alt');
      $title = $imageTag->getAttribute('title');
      $class = $imageTag->getAttribute('class');
      $url = $this->normalizeUrl($src);
      if (strlen($url)) {
        try {
          $newSrc = '/' . $this->file->remoteImageToFile($url, $dir, $this->fileNameFromUrl($url));
        }
        catch (\Exception $exception) {
          $this->logger()->error($exception->getMessage());
          return;
        }
        $newElement = $dom->createElement('img');
        foreach (
          [
            'src' => $newSrc,
            'title' => $title,
            'alt' => $alt,
            'class' => $class,
          ] as $name => $value) {
          $newAttribute = $dom->createAttribute($name);
          $newAttribute->value = $value;
          $newElement->appendChild($newAttribute);
        }
        $imageTag->parentNode->replaceChild($newElement, $imageTag);
        $this->logger()
          ->notice(dt('Replacing the image "@image" with the image "@replaced_image".', [
            '@image' => $dom->saveHTML($imageTag),
            '@replaced_image' => $dom->saveHTML($newElement),
          ]));
      }
    }
    echo $dom->saveHTML();
  }

  /**
   * Takes a possible relative path and returns it as a full URL to DB.com.
   *
   * @param string $relativeUrl
   *   A relative path or a full URL to db.com.
   *
   * @return false|string
   *   If not a relative path or a full URL to db.com, false, otherwise a full
   *   path to DB.com
   */
  protected function normalizeUrl($relativeUrl) {
    foreach ([
      'http://www.discoverboating.com/' => 'http://offln.discoverboating.com/',
      'https://www.discoverboating.com/' => 'http://offln.discoverboating.com/',
      'http://blog.discoverboating.com/' => 'http://blog.discoverboating.com/',
      'https://blog.discoverboating.com/' => 'http://blog.discoverboating.com/',
      '/' => 'http://offln.discoverboating.com/',
    ] as $query => $new_query) {
      if (substr($relativeUrl, 0, strlen($query)) === $query) {
        return substr_replace($relativeUrl, $new_query, 0, strlen($query));
      }
    }
    return FALSE;
  }

  /**
   * Creates a file name from a DB.com URL.
   *
   * @param string $url
   *   A DB.com URL.
   *
   * @return string
   *   The file name.
   */
  protected function fileNameFromUrl($url) {
    // The file name will be everything past the domain with / replaced
    // with --.
    return str_replace(
      [
        '/',
      ],
      ['--', '', ''],
      str_replace([
        'http://offln.discoverboating.com/',
        'http://www.discoverboating.com/',
        'http://blog.discoverboating.com/',
      ], '', $url)
    );
  }

  /**
   * Create a new dom document.
   *
   * @param string $content
   *   HTML content.
   * @param string $charset
   *   The character set.
   *
   * @return bool|\DOMDocument
   *   False on error or the object.
   */
  public function newDomDocument($content, $charset = 'UTF-8') {
    $internalErrors = libxml_use_internal_errors(TRUE);
    $disableEntities = libxml_disable_entity_loader(TRUE);

    $dom = new \DOMDocument('1.0', $charset);
    $dom->validateOnParse = TRUE;

    try {
      // Convert charset to HTML-entities to work around bugs in
      // DOMDocument::loadHTML()
      $content = mb_convert_encoding($content, 'HTML-ENTITIES', $charset);
    }
    catch (\Exception $e) {
      return FALSE;
    }

    restore_error_handler();

    if ('' !== trim($content)) {
      @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    }

    libxml_use_internal_errors($internalErrors);
    libxml_disable_entity_loader($disableEntities);

    return $dom;
  }

  /**
   * Strip Blog Links.
   *
   * @command nmma_migrate:strip-blog-links
   */
  public function stripBlogLinks() {
    $this->logger()->notice(dt('Stripping links to boating blog.'));
    $query = $this->nodeStorage->getQuery()
      ->condition('type', 'article');
    $entity_ids = $query->execute();
    foreach ($entity_ids as $entity_id) {
      $anchors = '';
      /** @var \Drupal\node\Entity\Node $node */
      $node = $this->nodeStorage->load($entity_id);
      $value = $node->get('field_article_body')->getValue()[0]['value'];

      $dom = $this->newDomDocument($value);

      $anchors = $dom->getElementsByTagName('a');

      foreach ($anchors as $anchor) {
        $href = $anchor->getAttribute('href');
        $host = parse_url($href, PHP_URL_HOST);
        $is_blog = explode('.', $host)[0];
        if ($is_blog == 'blog') {
          $this->logger()->notice(dt('Stripping blog anchor @anchor.', [
            '@anchor' => $href,
          ]));
          $anchor->parentNode->removeChild($anchor);
        }
      }
      // The updated dom will have all the wrapper tags around it, just get
      // the body tag content.
      $xpath = new \DOMXPath($dom);
      $body = $xpath->query('/html/body');
      $stripped_content = $dom->saveHTML($body->item(0));
      // Also remove empty paragraphs.
      $stripped_content = str_replace('<p>&nbsp;</p>', '', $stripped_content);
      $stripped_content = str_replace('<p> </p>', '', $stripped_content);
      $stripped_content = str_replace('<p></p>', '', $stripped_content);
      $node->set('field_article_body', $stripped_content);
      $node->save();
    }
  }

}
