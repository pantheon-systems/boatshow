<?php

/**
 * @file
 * Hooks provided by the CodeMirror editor module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Alters the list of CodeMirror assets.
 *
 * @param array[] $assets
 *   A list of asset paths relative to libraries/codemirror directory.
 */
function hook_codemirror_editor_assets_alter(array &$assets) {
  $assets['js'][] = 'mode/php/php.min.js';
}

/**
 * @} End of "addtogroup hooks".
 */
