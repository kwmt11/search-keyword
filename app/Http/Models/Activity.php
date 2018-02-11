<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    public function getActivitiesByPageIds($pageIds)
    {
        return $this->whereIn('page_id', $pageIds)
            ->orderBy('user_id', 'ASC')
            ->orderBy('page_id', 'ASC')->get();
    }
}