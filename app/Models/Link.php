<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Link extends Model
{
    use HasFactory;

    protected $table = 'tm_links';

    protected $fillable = ['link_name', 'tracking_link_id', 'tracking_slug', 'primary_url', 'group_id', 'network_id', 'is_action'];

    const RULES = [
        'link_name' => 'required',
        'tracking_slug' => 'required|alpha_dash|unique:tm_links',
        'primary_url' => 'required',
    ];

    const MESSAGES = [
        'link_name.required' => 'Link name is required.',
        'tracking_slug.required' => 'Tracking slug is required.',
        'tracking_slug.unique' => 'Tracking link should be unique and should\'nt have added before.',
        'tracking_slug.alpha_dash' => 'Tracking slug should not contain any spaces.',
        'primary_url.required' => 'Primary url is required.'
    ];

    public function linkGroup(): BelongsTo
    {
        return $this->belongsTo(LinkGroup::class, 'group_id', 'id');
    }

    public function network(): BelongsTo
    {
        return $this->belongsTo(Network::class, 'network_id', 'id');
    }

    public function trackingLinks(): BelongsTo {
        return $this->belongsTo(TrackingLink::class, 'tracking_link_id', 'id');
    }

    public function LinkStats(): hasMany {
        return $this->hasMany(LinkStat::class, 'link_id', 'id');
    }

    public function fetchUniqueClicks(Link $link): Collection
    {
        return DB::table('tm_link_stats')
            ->select('link_id', 'ip_address')
            ->where('link_id', $link->id)
            ->groupBy('link_id')
            ->groupBy('ip_address')
            ->get();
    }

    public function fetchActionClicks(Link $link): Collection
    {
        return DB::table('tm_link_stats')
            ->where('link_id', $link->id)
            ->where('action', 1)
            ->get();
    }
}
