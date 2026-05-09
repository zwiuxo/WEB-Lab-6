<?php
require_once 'ClientFactory.php';

class ClickhouseExample
{
    private $client;

    public function __construct()
    {
        $this->client = ClientFactory::make('http://clickhouse:8123/');
    }

    public function query($sql)
    {
        try {
            $response = $this->client->post('', [
                'body' => $sql
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return "Ошбика ClickHouse: " . $e->getMessage();
        }
    }
}
