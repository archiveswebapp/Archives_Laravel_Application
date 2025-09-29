<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use App\Models\User;

class MongoFeedback extends Eloquent
{
    protected $collection = 'mongo_feedback';
    protected $connection = 'mongodb';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'created_at',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id'    => 'integer',
        'rating'     => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Accessor to fetch user details from MySQL.
     */
    public function getUserNameAttribute()
    {
        $user = User::find($this->user_id);
        return $user ? $user->name : 'Anonymous';
    }
}
