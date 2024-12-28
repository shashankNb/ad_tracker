<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkStat extends Model
{
    use HasFactory;

    protected $table = 'tm_link_stats';

    protected $fillable = [
        'link_id',
        'click_id',
        'ip_address',
        'user_agent',
        'action',
        'subId_1',
        'subId_2',
        'subId_3',
        'subId_4',
        'subId_5'
    ];
}
