<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    public function getUsersMapById($userIds)
    {
        return $this->whereIn('id', $userIds)->get()->keyBy('id');
    }
}