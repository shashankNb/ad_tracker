<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $table = 'tm_networks';

    protected $fillable = ['network_name', 'network_code'];

    const RULES = ['network_name' => 'required', 'network_code' => 'required'];

    const MESSAGES = ['network_name.required' => 'Network name is required.', 'network_code.required' => 'Network code is required'];


}
