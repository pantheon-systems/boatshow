<?php

namespace Drupal\nmma_tickets\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * A test block used in the nmma_tickets .
 *
 * @Block(
 *   id = "nmma_tickets",
 *   admin_label = @Translation("nmma tickets javascript block")
 * )
 */
class NmmaTicketsJavascriptBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $ticket_url = \Drupal::config('nmma_tickets.settings')->get('ticket_url_path');
    $ticket_id  = \Drupal::config('nmma_tickets.settings')->get('ticket_id');

    $tag = t('
    <script>(function(d, s, id) {
      //window.disableHashSync=true;
      // uncomment to disable hashes
      var js, itjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = "https://secure.interactiveticketing.com/@whey";
      itjs.parentNode.insertBefore(js, itjs);
      } (document, \'script\', \'@foo\'));
      </script><div class="@foo"></div>
      ', ['@foo' => $ticket_id, '@whey' => $ticket_url]);
        return [
          '#markup' => $tag,
          '#allowed_tags' => ['script', 'div'],
        ];
  }

}
