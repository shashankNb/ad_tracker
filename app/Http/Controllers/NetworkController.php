<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NetworkController extends Controller
{
    protected Network $network;

    /**
     * @param Network $network
     */
    public function __construct(Network $network)
    {
        $this->network = $network;
    }

    /**
     * Get Networks list
     * @return Application|Factory|View
     */
    public function index()
    {
        $networks = $this->network->all();
        return view('admin.networkManage', ['networks' => $networks]);
    }

    /**
     * Add New Network
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function add(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('admin.networkAdd');

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $validation = Validator::make($data, Network::RULES, Network::MESSAGES);

            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the errors below :-');
            }

            try {
                $this->network->create($data);
                session()->flash('success', 'Affiliate network added.');
                return redirect()->route('networks.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized request');
            abort(404);
        }
    }

    /**
     * [GET] View network detail/ [POST] Update Network details
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function edit(Request $request, $id)
    {

        if ($request->isMethod('GET')) {

            $data = $this->network->find($id);
            return view('admin.networkEdit', ['network' => $data]);

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $validation = Validator::make($data, Network::RULES, Network::MESSAGES);

            if ($validation->fails()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the errors below :-');
            }

            try {

                $this->network->where('id', $id)->update($data);
                session()->flash('success', 'Affiliate network updated.');
                return redirect()->route('networks.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized request');
            abort(404);
        }
    }

    /**
     * Delete network
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {

            $this->network->find($id)->delete();
            session()->flash('info', 'Affiliate network deleted.');
            return redirect()->route('networks.index');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
