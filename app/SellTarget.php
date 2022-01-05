<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellTarget extends Model
{
    protected $fillable = [
        'business_id',
        'user_id',
        'target',
        'note'
    ];
}
