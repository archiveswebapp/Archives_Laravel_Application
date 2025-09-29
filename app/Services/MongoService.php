<?php

namespace App\Services;

use MongoDB\Client;

class MongoService
{
    protected $client;
    protected $db;

    public function __construct()
    {
        $this->client = new Client(env('MONGO_URI'));
        $this->db = $this->client->selectDatabase(env('MONGO_DB'));
    }

    public function getCollection($name)
    {
        return $this->db->selectCollection($name);
    }
}
