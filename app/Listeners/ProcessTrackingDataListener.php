<?php

namespace App\Listeners;

use App\Models\LinkStat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessTrackingDataListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public LinkStat $linkStat;

    public function __construct(LinkStat $linkStat)
    {
        $this->linkStat = $linkStat;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $trackingData = $event->trackingData;
        switch ($trackingData['action']) {
            case 'TRACK':
                $this->trackVisits($trackingData['payload']);
                break;
            case 'CLICK':
                $this->trackClicks($trackingData['payload']);
                break;
            default:
                abort(401);
        }
    }

    public function trackVisits($payload)
    {

        $linkStat = $this->buildLinkStatObject($payload);
        try {
            $linkStat->save();
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function trackClicks($payload)
    {
        $data = $this->linkStat->where('click_id', $payload['keyword'])->first();
        if ($data == null) {
            $payload['keyword'] = 'DIRECT';
        } else {
            $this->linkStat->where('click_id', $payload['keyword'])->update(['action' => 1]);
        }

        $linkStat = $this->buildLinkStatObject($payload);

        try {
            $linkStat->save();
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public function buildLinkStatObject($payload): LinkStat
    {
        $linkStat = new LinkStat();
        $linkStat->link_id = $payload['link_id'];
        $linkStat->click_id = $payload['randomClickId'];
        $linkStat->ip_address = $payload['ip_address'];
        $linkStat->user_agent = $payload['user_agent'];
        $linkStat->action = 0;
        $linkStat->subId_1 = $payload['keyword'];
        $linkStat->subId_2 = $payload['query'];
        $linkStat->subId_3 = $payload['adgroup'];
        $linkStat->subId_4 = $payload['network'];
        $linkStat->subId_5 = $payload['siteLinksExt'];
        return $linkStat;
    }
}
