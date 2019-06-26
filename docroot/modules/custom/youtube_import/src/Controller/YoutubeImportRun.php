<?php

namespace Drupal\youtube_import\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class YoutubeImportRun.
 *
 * @package Drupal\youtube_import\Controller
 */
class YoutubeImportRun extends ControllerBase {

  /**
   * A menu location to call the run.
   */
  public function runNow() {
    // All this does is trigger the run from a url.
    youtube_import_videos();
    $this->redirectMe('/admin/config/system/youtube_import');
  }

  /**
   * Redirect somewhere new.
   *
   * @param string $path
   *   The path.
   */
  public function redirectMe($path) {
    $response = new RedirectResponse($path);
    $response->send();
  }

}
