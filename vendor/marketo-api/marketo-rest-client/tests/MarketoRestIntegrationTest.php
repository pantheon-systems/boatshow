<?php

namespace CSD\Marketo\Tests;

use CSD\Marketo\Client;
use CSD\Marketo\Response\GetActivityTypesResponse;
use CSD\Marketo\Response\GetLeadActivityResponse;

/**
 * @group marketo-rest-client-integration
 */
class MarketoRestIntegrationTest extends \PHPUnit_Framework_TestCase {

    /**
     * Gets the marketo rest client.
     *
     * @return \CSD\Marketo\Client
     */
    private function _getClient() {

        static $client = FALSE;

        if ($client) return $client;

        $client = Client::factory([
            'client_id' => $_SERVER['MARKETO_CLIENT_ID'],
            'client_secret' => $_SERVER['MARKETO_CLIENT_SECRET'],
            'munchkin_id' => $_SERVER['MARKETO_MUNCHKIN_ID'],
        ]);

        return $client;
    }

    public function testGetCampaigns() {
        $client = $this->_getClient();
        $campaigns = $client->getCampaigns()->getResult();

        self::assertNotEmpty($campaigns[0]['id']);
        $campaign = $client->getCampaign($campaigns[0]['id'])->getResult();
        self::assertNotEmpty($campaign[0]['name']);
        self::assertEquals($campaigns[0]['name'], $campaign[0]['name']);
    }

    public function testGetLists() {
        $client = $this->_getClient();
        $lists = $client->getLists()->getResult();

        self::assertNotEmpty($lists[0]['id']);
        $list = $client->getList($lists[0]['id'])->getResult();
        self::assertNotEmpty($list[0]['name']);
        self::assertEquals($lists[0]['name'], $list[0]['name']);
    }

    public function testLeadPartitions() {
        $client = $this->_getClient();
        $partitions = $client->getLeadPartitions()->getResult();

        self::assertNotEmpty($partitions[0]['name']);
        self::assertEquals($partitions[0]['name'], 'Default');
    }

    public function testResponse() {
        $client = $this->_getClient();
        $response = $client->getCampaigns();

        self::assertTrue($response->isSuccess());
        self::assertNull($response->getError());
        self::assertNotEmpty($response->getRequestId());

        // No assertion but make sure getNextPageToken doesn't error out.
        $response->getNextPageToken();

        self::assertEquals(serialize($response->getResult()), serialize($response->getCampaigns()));
        // @todo: figure out how to rest \CSD\Marketo\Response::fromCommand().
    }

}
