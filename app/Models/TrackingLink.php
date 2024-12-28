<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLink extends Model
{
    use HasFactory;

    protected $table = 'tm_tracking_links';

    protected $fillable = ['link'];

    const RULES = ['link' => 'required'];

    const MESSAGES = ['link.required' => 'Tracking link is required.'];
}
