<?php

namespace App\Http\Controllers;

use App\Models\LinkGroup;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LinkGroupController extends Controller
{
    protected LinkGroup $linkGroup;

    /**
     * @param LinkGroup $linkGroup
     */
    public function __construct(LinkGroup $linkGroup)
    {
        $this->linkGroup = $linkGroup;
    }

    /**
     * View list of Link Groups
     * @return Application|Factory|View
     */
    public function index()
    {
        $linkGroups = $this->linkGroup->with('user')->get();
        return view('admin.linkGroupManage', ['linkGroups' => $linkGroups]);
    }

    /**
     * [GET] Add New Link Group / [POST] Update New Link Group
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function add(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('admin.linkGroupAdd');

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $data['user_id'] = auth()->user()->id;

            $validation = Validator::make($data, LinkGroup::RULES, LinkGroup::MESSAGES);
            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->linkGroup->create($data);
                session()->flash('success', 'Link group added.');
                return redirect()->route('link_groups.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized requests.');
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

            $data = $this->linkGroup->find($id);

            return view('admin.linkGroupEdit', ['linkGroup' => $data]);

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $data['user_id'] = auth()->user()->id;

            $validation = Validator::make($data, LinkGroup::RULES, LinkGroup::MESSAGES);
            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->linkGroup->where('id', $id)->update($data);
                session()->flash('success', 'Link group has been updated.');
                return redirect()->route('link_groups.index');

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

            $this->linkGroup->find($id)->delete();
            session()->flash('info', 'Link group has been deleted.');
            return redirect()->route('link_groups.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
