<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Log;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = Role::first();

        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.roles.breadcrumbs.role_show')
                ]
            ]
        ];

        $roleList = Role::leftJoin('users', 'users.role_id', 'roles.id')
            ->select('roles.id as id', 'roles.name', DB::raw('count(users.full_name) as total'))
            ->groupBy('id', 'roles.name')
            ->get();

        $userList = User::join('roles', 'roles.id', 'users.role_id')
            ->select('users.*')
            ->where('users.role_id', $role->id)
            ->get();

        return view('admin.roles.show', compact('role', 'userList', 'breadcrumbs', 'userNumb', 'roleList'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.roles.breadcrumbs.role_create')
                ]
            ]
        ];
        return view('admin.roles.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $requestData = $request->all();

        $requestData['permissions'] = implode(",", $request->permissions);

        Role::create($requestData);

        Session::flash('flash_message', trans('admin.roles.flash_messages.new'));

        return redirect('admin/roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.roles.breadcrumbs.role_update')
                ]
            ]
        ];
        $role = Role::findOrFail($id);

        return view('admin.roles.edit', compact('role', 'breadcrumbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param Request|\Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $requestData = $request->all();

        if (!empty($requestData['permissions'])) {
            $requestData['permissions'] = implode(",", $request->permissions);
        } else {
            $requestData['permissions'] = '';
        }


        $role = Role::findOrFail($id);

        $role->update($requestData);

        Session::flash('flash_message', trans('admin.roles.flash_messages.update'));

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $breadcrumbs = [
            'title' => __('admin.roles.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/roles'),
                    'text' => __('admin.roles.breadcrumbs.role_index')
                ],
                [
                    'href' => url('#'),
                    'text' => __('admin.roles.breadcrumbs.role_show')
                ]
            ]
        ];

        $roleList = Role::leftJoin('users', 'users.role_id', 'roles.id')
            ->select('roles.id as id', 'roles.name', DB::raw('count(users.full_name) as total'))
            ->groupBy('id', 'roles.name')
            ->get();

        $role = Role::findOrFail($id);

        $userList = User::join('roles', 'roles.id', 'users.role_id')
            ->select('users.*')
            ->where('users.role_id', $id)
            ->get();


        return view('admin.roles.show', compact('role', 'userList', 'breadcrumbs', 'userNumb', 'roleList'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if (!$role->canDelete()) {
            Session::flash('flash_error', trans('admin.roles.flash_messages.can\'t_delete'));
        } else {
            $role->delete();
            Session::flash('flash_message', trans('admin.roles.flash_messages.delete'));
        }
        return redirect('admin/roles');
    }

    public function updateUserRole($id,Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->update(['role_id' => $id]);

        Session::flash('flash_message', trans('admin.roles.flash_messages.add_user'));

        return redirect('admin/roles/'.$id);
    }

    public function deleteUserRole($id,Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->update(['role_id' => null]);

        Session::flash('flash_message', trans('admin.roles.flash_messages.delete_user'));

        return redirect('admin/roles/'.$id);
    }


}
