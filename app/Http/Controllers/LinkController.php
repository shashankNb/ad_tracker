<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\LinkGroup;
use App\Models\Network;
use App\Models\TrackingLink;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{
    protected Link $link;
    protected LinkGroup $linkGroup;
    protected Network $network;
    protected TrackingLink $trackingLink;

    /**
     * @param Link $link
     * @param Network $network
     * @param LinkGroup $linkGroup
     * @param TrackingLink $trackingLink
     */
    public function __construct(Link $link, Network $network, LinkGroup $linkGroup, TrackingLink $trackingLink)
    {
        $this->link = $link;
        $this->network = $network;
        $this->linkGroup = $linkGroup;
        $this->trackingLink = $trackingLink;
    }

    /**
     * List all Links
     * @return Application|Factory|View
     */
    public function index()
    {
        $links = $this->link->with(['linkGroup', 'network', 'trackingLinks'])->get();
        return view('admin.linkManage', ['links' => $links]);
    }

    /**
     * [GET] Add New Link \ [POST] Save new Link
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function add(Request $request)
    {

        if ($request->isMethod('GET')) {

            $networks = $this->network->all();
            $linkGroups = $this->linkGroup->all();
            $tracking_links = $this->trackingLink->all();

            return view('admin.linkAdd', [
                'networks' => $networks,
                'linkGroups' => $linkGroups,
                'trackingLinks' => $tracking_links
            ]);

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $rules = Link::RULES;
            $messages = Link::MESSAGES;
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput()
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->link->create($data);
                session()->flash('success', 'Link created.');
                return redirect()->route('links.index');

            } catch (QueryException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized requests');
        }
    }

    /**
     * [GET] GET Link / [POST] Update Link
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function edit(Request $request, $id)
    {

        if ($request->isMethod('GET')) {

            $networks = $this->network->all();
            $linkGroups = $this->linkGroup->all();
            $tracking_links = $this->trackingLink->all();

            $data = $this->link->find($id);

            return view('admin.linkEdit', [
                'link' => $data,
                'networks' => $networks,
                'linkGroups' => $linkGroups,
                'trackingLinks' => $tracking_links
            ]);

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');
            $rules = Link::RULES;
            $message = Link::MESSAGES;
            $rules['tracking_slug'] = $rules['tracking_slug'] . ',tracking_slug,' . $id;
            $validator = Validator::make($data, $rules, $message);
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors())
                    ->withInput()
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->link->where('id', $id)->update($data);
                session()->flash('success', 'Link updated.');
                return redirect()->route('links.index');

            } catch (QueryException $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized requests');
            abort(404);
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {

            $this->link->find($id)->delete();
            session()->flash('info', 'Link deleted.');
            return redirect()->route('links.index');

        } catch (QueryException $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
