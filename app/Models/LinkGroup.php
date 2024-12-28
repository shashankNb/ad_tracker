<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LinkGroup extends Model
{
    use HasFactory;

    protected $table = 'tm_link_groups';

    protected $fillable = ['group_name', 'user_id'];

    const RULES = [ 'group_name' => 'required' ];

    CONST MESSAGES = ['group_name.required' => 'Link group is required.'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function links(): HasMany {
        return $this->hasMany(Link::class, 'group_id', 'id');
    }
}
