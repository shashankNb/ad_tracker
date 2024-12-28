<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get Users list
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = $this->user->all();
        return view('admin.userManage', ['users' => $users]);
    }

    /**
     * Add New User
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function add(Request $request)
    {
        if ($request->isMethod('GET')) {

            return view('admin.userAdd');

        } else if ($request->isMethod('POST')) {

            $data = $request->except('_token');

            $password = $data['password'];

            $data['password'] = bcrypt($data['password']);

            $validation = Validator::make($data, User::RULES, User::MESSAGES);

            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the following errors below :-');
            }


            try {

                $this->user->create($data);

                //Send Email
                $maildata = [
                    'title' => 'New user created on trackmagic.com',
                    'url' => 'https://trackmagic.com',
                    'subject' => 'User account at track magic has been created.',
                    'password' => 'Your account password for ' . $data['email'] . ' is - ' . $password
                ];
                Mail::to($data['email'])->send(new SendMail($maildata));

                session()->flash('success', 'New user created successfully.');
                return redirect()->route('users.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized request');
            abort(404);
        }
    }

    /**
     * [GET] View user detail/ [POST] Update User details
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse|void
     */
    public function edit(Request $request, $id)
    {

        $isAdmin = auth()->user()->id == 1 || auth()->user()->id == $id;
        if ($request->isMethod('GET') && $isAdmin) {

            $data = $this->user->find($id);

            //dd($id. auth()->user()->id);
            return view('admin.userEdit', ['user' => $data]);

        } else if ($request->isMethod('POST') && $isAdmin) {

            $data = $request->except('_token');

            $rules = User::RULES;

            if ($data['password'] == "" || $data['password'] == null) {
                unset($rules['password']);
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }


            $rules['username'] = $rules['username'] . ',username,' . $id;
            $rules['email'] = $rules['email'] . ',email,' . $id;

            $validation = Validator::make($data, $rules, User::MESSAGES);

            if ($validation->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validation->errors())
                    ->with('message', 'Please correct the following errors below :-');
            }

            try {

                $this->user->where('id', $id)->update($data);

                //Send Email
                $maildata = [
                    'title' => $data['name'] . ' user details updated.',
                    'url' => 'https://trackmagic.com',
                    'message' => 'If you have\'nt updated your user account, Please contact admin immediately.',
                    'subject' => $data['name'] . ' details has been updated.'
                ];
                Mail::to($data['email'])->send(new SendMail($maildata));

                session()->flash('success', 'User details has been updated.');
                return redirect()->route('users.index');

            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }

        } else {
            Log::notice('Unauthorized request');
            abort(404);
        }
    }

    /**
     * Delete user
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        try {

            $this->user->find($id)->delete();
            session()->flash('info', 'User has been deleted.');
            return redirect()->route('users.index');

        } catch (\Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
