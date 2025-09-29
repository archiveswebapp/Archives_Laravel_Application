<?php

namespace App\Repositories;

use App\Services\MongoService;

class FeedbackRepository
{
    protected $collection;

    public function __construct(MongoService $mongo)
    {
        $this->collection = $mongo->getCollection('feedback');
    }

    public function create($data)
    {
        return $this->collection->insertOne($data);
    }

    public function getAll($limit = 10)
    {
        return $this->collection->find([], [
            'sort' => ['created_at' => -1],
            'limit' => $limit
        ])->toArray();
    }

    public function findByProduct($productId)
    {
        return $this->collection->find(['product_id' => $productId], [
            'sort' => ['created_at' => -1]
        ])->toArray();
    }
}
