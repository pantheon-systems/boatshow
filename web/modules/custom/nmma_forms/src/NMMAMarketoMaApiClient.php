<?php

namespace Drupal\nmma_forms;

use Drupal\marketo_ma\Service\MarketoMaApiClient;

/**
 * This is an extended version of the MarketoMaApiClient service.
 */
class NMMAMarketoMaApiClient extends MarketoMaApiClient {

  /**
   * Add a lead to an email list.
   *
   * @param string $email
   *   The lead's email address.
   * @param int $listId
   *   The list ID we want to add the lead to.
   *
   * @return bool
   *   True if a member already or if added as member.
   */
  public function syncListLead($email, $listId = 0) {
    $lead = $this->getLeadByEmail($email);
    $context = [
      '@email' => $email,
      '@listId' => $listId,
      '@lead' => print_r($lead, 1),
    ];
    $context_ph = 'Email: @email; ListID: @listId; Lead: @lead';
    // Lead does not exist, syncLead() should have already been called to create
    // the lead.
    if (NULL === $lead) {
      $this->logger->info('Lead does not exist, unable to add to list ' . $context_ph, $context);
      return FALSE;
    }
    $isMemberOfList = $this->getClient()->isMemberOfList($listId, $lead->id());
    // If the lead is not a member of this list, add them.
    if (FALSE === $isMemberOfList->isMember()) {
      $result = $this->getClient()->addLeadsToList($listId, $lead->id());
      // Added successfully.
      if ($result->getStatus($lead->id()) === 'added') {
        $this->logger->info('Lead added to the list ' . $context_ph, $context);
        return TRUE;
      }
      // Unable to add lead to list (or list did not exist).
      $context['@results'] = print_r($isMemberOfList, 1);
      $context_ph .= ' Results: @results';
      $this->logger->error('Lead exists but unable to add to list ' . $context_ph, $context);
      return FALSE;
    }
    // Lead is already a member of the list.
    else {
      $this->logger->info('Lead already added to list ' . $context_ph, $context);
      return TRUE;
    }
  }

}
