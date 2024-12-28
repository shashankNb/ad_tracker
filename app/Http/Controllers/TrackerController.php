<?php

namespace App\Http\Controllers;

use App\Events\TrackingDataEvent;
use App\Helpers\Helper;
use App\Models\ImportItem;
use App\Models\Link;
use App\Models\TrackingLink;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TrackerController extends Controller
{
    protected TrackingLink $trackingLink;
    protected ImportItem  $importItem;
    protected Link $link;

    /**
     * @param TrackingLink $trackingLink
     * @param Link $link
     * @param ImportItem $importItem
     */
    public function __construct(TrackingLink $trackingLink, Link $link, ImportItem  $importItem)
    {
        $this->link = $link;
        $this->trackingLink = $trackingLink;
        $this->importItem = $importItem;
    }

    /**
     * View list of Link Groups
     * @return Application|Factory|View
     */
    public function index()
    {
        $trackingLinks = $this->trackingLink->all();
        return view('admin.trackingLinkManage', ['trackingLinks' => $trackingLinks]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function add(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('admin.trackingLinkAdd');

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $validation = Validator::make($data, ['link' => 'required'], ['link.required' => 'Tracking link is required']);

            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->trackingLink->create($data);
                session()->flash('success', 'Tracking link added.');
                return redirect()->route('trackingLinks.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized requests');
            abort(404);
        }
    }

    /**
     * [GET] Get Link Group Detail / [POST] Update Link Group Detail
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('GET')) {

            $data = $this->trackingLink->find($id);

            return view('admin.trackingLinkEdit', ['trackingLink' => $data]);

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $validation = Validator::make($data, ['link' => 'required'], ['link.required' => 'Tracking link is required']);

            if ($validation->fails()) {
                return redirect()->back()->withInput()->withErrors($validation->errors());
            }

            try {

                $this->trackingLink->where('id', $id)->update($data);
                session()->flash('success', 'Tracking link updated.');
                return redirect()->route('trackingLinks.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized requests');
        }
    }

    /**
     * Delete Link Group
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {

            $this->trackingLink->find($id)->delete();
            session()->flash('info', 'Tracking link deleted.');
            return redirect()->route('trackingLinks.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * @param string $action
     * @param string $slug
     * @param $keyword
     * @param $query
     * @param $adGroup
     * @param $network
     * @param $siteLinksExt
     * @return Application|RedirectResponse|Redirector
     */
    public function track(string $action,
                          string $slug,
                          $keyword = null,
                          $query = null,
                          $adGroup = null,
                          $network = null,
                          $siteLinksExt = null)
    {
        $action = strtoupper($action);
        if (!($action === 'CLICK' || $action === 'TRACK')) {
            abort(401);
        }

        $randomClickId = $action === 'CLICK' && !empty($keyword) ? $keyword : date('Ymds');
        $link = $this->link->select(['primary_url', 'id'])->where('tracking_slug', $slug)->first();

        if ($link == null) {
            abort(404);
        }
        $url = $action === 'CLICK'
            ? str_replace('[s1]', $randomClickId, $link->primary_url)
            : str_replace('[clickid]', $randomClickId, $link->primary_url);

        $trackingData = [
            'action' => $action,
            'payload' => [
                'link_id' => $link->id,
                'slug' => $slug,
                'keyword' => $keyword,
                'query' => $query,
                'adgroup' => $adGroup,
                'network' => $network,
                'siteLinksExt' => $siteLinksExt,
                'randomClickId' => $randomClickId,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => Helper::UserAgent()
            ]
        ];

        event(new TrackingDataEvent($trackingData));

        return redirect($url);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function trackClickBankSale(Request $request): JsonResponse
    {
        $secretKey = env('CLICK_BANK_SECRET');
        $message = $request->all();
        $encrypted = $message['notification'];
        $iv = $message['iv'];

        $decrypted = trim(
            openssl_decrypt(base64_decode($encrypted),
                'AES-256-CBC',
                substr(sha1($secretKey), 0, 32),
                OPENSSL_RAW_DATA,
                base64_decode($iv)), "\0..\32");

        if (empty($decrypted)) {
            Log::error('UNABLE_TO_DECODE_WITH_KEY');
            return response()->json('UNABLE_TO_DECODE', Response::HTTP_OK);
        } else {
            $sanitizedData = utf8_encode(stripslashes($decrypted));
            $item = [
                'network' => 'clickbank',
                'data' => $sanitizedData,
                'data_type' => 1,
                'is_imported' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            try {
                $this->importItem->create($item);
                return response()->json('SUCCESS', Response::HTTP_OK);
            } catch (\Exception $e) {
                return response()->json('FAILED_TO_SAVE', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
