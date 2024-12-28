<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkStat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LinkStatsController extends Controller
{
    protected Link $link;
    protected LinkStat $linkStat;

    /**
     * @param Link $link
     * @param LinkStat $linkStat
     */
    public function __construct(Link $link, LinkStat $linkStat)
    {
        $this->linkStat = $linkStat;
        $this->link = $link;
    }


    public function index()
    {
        $links = $this->link->with('linkStats')->get();

        $stats = [];
        foreach ($links as $link) {
            $stats[] = (object)[
                'link_id' => $link->id,
                'link_name' => $link->link_name,
                'total_clicks' => $this->linkStat->where('link_id', $link->id)->get()->count(),
                'unique_clicks' => $this->getUniqueClicks($link),
                'action_clicks' => $this->getActionClicks($link),
                'conversion' => 0
            ];
        }

        return view('admin.linkStatManage', ['stats' => $stats]);
    }

    private function getUniqueClicks(Link $link): int
    {

        $data = $this->link->fetchUniqueClicks($link);
        return $data->count();
    }

    private function getActionClicks(Link $link): int
    {
        $data = $this->link->fetchActionClicks($link);
        return $data->count();
    }

    public function detail(Request $request)
    {
        $id = $request->get('linkId');
        $link = $this->link->with('LinkStats')
            ->select(['*'])
            ->where('id', $id)
            ->first();
        return view('admin.linkStatDetail', ['link' => $link]);
    }

    public function reports(int $linkId, $category = null)
    {
        $category = strtoupper($category);
        switch ($category) {
            case 'CAMPAIGN':
                $stats = $this->linkReportsBySearchTerm($linkId);
                break;
            default:
            $stats = $this->linkStat->where('link_id', $linkId)->orderBy('created_at', 'DESC')->get();
        }
        return view('admin.linkStatsReport', compact('stats', 'category', 'linkId'));
    }

    private function linkReportsBySearchTerm(int $linkId): array
    {
        $linkStats = $this->linkStat->where('link_id', $linkId)->get()->unique('subId_2');
        $stats = [];
        foreach($linkStats as $data) {
            $stats[] = (object) [
                'keyword' => $data->subId_1,
                'queryString' => $data->subId_2,
                'uniqueClicks' => $this->linkStat->where('subId_2', $data->subId_2)->get()->unique('ip_address')->count(),
                'action' => $this->linkStat->where(['subId_2' => $data->subId_2, 'action' => 1])->count(),
                'sale' => '-',
                'searchCount' => $this->linkStat->where('subId_2', $data->subId_2)->count()
            ];
        }
        usort($stats, fn($a, $b) => strcmp($b->searchCount, $a->searchCount));
        return $stats;
    }

    public function fetchLinkDetail($linkId)
    {
        $link = $this->link->with('linkStats')->where('id', $linkId)->first();

        return (object)[
            'link_id' => $linkId,
            'link_name' => $link->link_name,
            'total_clicks' => $this->linkStat->where('link_id', $link->id)->get()->count(),
            'unique_clicks' => $this->getUniqueClicks($link),
            'action_clicks' => $this->getActionClicks($link),
            'conversion' => 0
        ];
    }

    public function delete($linkId): JsonResponse
    {
        try {
            $this->linkStat->where('link_id', $linkId)->delete();
            return response()->json($this->fetchLinkDetail($linkId), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($e->getTraceAsString(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteLinkDetail($statId): JsonResponse
    {
        try {
            $this->linkStat->where('id', $statId)->delete();
            return response()->json('deleted', \Symfony\Component\HttpFoundation\Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json($e, \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
