<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'page';

    public function getPagesByKeywordMapById($keyword)
    {
        return $this->where('title', 'LIKE', "$keyword%")->get()->keyBy('id');
    }
}