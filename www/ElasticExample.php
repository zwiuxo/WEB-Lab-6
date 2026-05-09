<?php

require_once 'ClientFactory.php';

class ElasticExample
{
    private $client;

    public function __construct()
    {
        $this->client = ClientFactory::make('http://elasticsearch:9200/');
    }

    public function indexUser($id, $data)
    {
        try {
            $response = $this->client->put("users/_doc/$id", [
                'json' => $data
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return "Ошибка индексации: " . $e->getMessage();
        }
    }

    public function searchUser($query)
    {
        try {
            $response = $this->client->get("users/_search", [
                'json' => [
                    'query' => [
                        'match' => $query
                    ]
                ]
            ]);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            return "Ошибка поиска: " . $e->getMessage();
        }
    }
}
