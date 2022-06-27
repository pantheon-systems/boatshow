<?php

namespace Drupal\nmma_migrate;

use Drupal\redirect\RedirectRepository;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\redirect\Exception\RedirectLoopException;

/**
 * The NMMA migrate file service.
 *
 * @package Drupal\nmma_migrate
 */
class Redirect {

  /**
   * The redirect entity repository.
   *
   * @var \Drupal\redirect\RedirectRepository
   */
  protected $redirectRepository;

  /**
   * Access the language manager service.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * Constructs a Redirect object.
   *
   * @param \Drupal\redirect\RedirectRepository $redirect_repository
   *   The redirect entity repository.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   */
  public function __construct(RedirectRepository $redirect_repository, LanguageManagerInterface $language_manager) {
    $this->redirectRepository = $redirect_repository;
    $this->languageManager = $language_manager;
  }

  /**
   * Retrieve the URL for the given redirect URL (if it exists).
   *
   * @param string $redirect_url
   *   A path that might be a redirected URL.
   *
   * @return bool|\Drupal\Core\Url
   *   False on a non redirect URL or the URL object that it redirects to.
   */
  public function getRedirectTarget($redirect_url) {
    // Get URL info and process it to be used for hash generation.
    $request_query = parse_str(parse_url($redirect_url, PHP_URL_QUERY));
    if (NULL === $request_query) {
      $request_query = [];
    }
    // Do the inbound processing so that for example language prefixes are
    // removed.
    $path = trim(parse_url($redirect_url, PHP_URL_PATH), '/');
    try {
      $redirect = $this->redirectRepository->findMatchingRedirect($path, $request_query, $this->languageManager->getCurrentLanguage()->getId());
      if (!empty($redirect)) {
        return $redirect->getRedirectUrl();
      }
      return FALSE;
    }
    catch (RedirectLoopException $e) {
      return FALSE;
    }
  }

}
