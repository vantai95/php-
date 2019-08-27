<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $role = $request->get('role');
        $status = $request->get('status');
        if ($request->get('per_page') > 0) {
            Session::put('perPage', $request->get('per_page'));
        }
        $perPage = Session::get('perPage')>0 ? Session::get('perPage'):config('constants.PAGE_SIZE');

        $users = User::orderBy('full_name');
        if (!empty($keyword)) {
            $keyword = CommonService::correctSearchKeyword($keyword);
            $users = $users->where(function ($query) use ($keyword) {
                $query->orWhere('full_name', 'LIKE', $keyword);
                $query->orWhere('email', 'LIKE', $keyword);
                $query->orWhere('phone', 'LIKE', $keyword);
            });
        }

        if ($role == User::ROLE_FILTER['user']) {
            $users = $users->whereNull('role_id');
        } elseif ($role == User::ROLE_FILTER['admin']) {
            $users = $users->where('role_id', '=', 1);
        } else {
            $role = "";
        }

        if ($status == User::STATUS_FILTER['active']) {
            $users = $users->where('is_locked', '=', false);
        } elseif ($status == User::STATUS_FILTER['locked']) {
            $users = $users->where('is_locked', '=', true);
        } else {
            $status = "";
        }

        $users = $users->paginate($perPage);
        session(['mainPage' => $request->fullUrl()]);
        $total = User::count();

        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/users'),
                    'text' => __('admin.users.breadcrumbs.user_index')
                ]
            ]
        ];

        return view('admin.users.index', compact('users', 'role', 'status', 'total', 'breadcrumbs'));
    }

    public function myProfile()
    {
        $user = Auth::user();
        $isMyProfile = true;
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('/admin/my-profile'),
                    'text' => __('admin.users.breadcrumbs.my_profile')
                ]
            ]
        ];
        return view('admin.users.show', compact('user', 'isMyProfile', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $isMyProfile = false;
        $roles = [null => __('admin.users.roles.select_role')];
        foreach (Role::all() as $role) {
            $roles = $roles + [$role->id => $role->name];
        }
        $breadcrumbs = [
            'title' => __('admin.users.breadcrumbs.title'),
            'links' => [
                [
                    'href' => url('admin/users'),
                    'text' => __('admin.users.breadcrumbs.user_index')
                ],
                [
                    'href' => url('/admin/users/' . $id . '/edit'),
                    'text' => $user->full_name
                ]
            ]
        ];
        return view('admin.users.show', compact('user', 'isMyProfile', 'roles', 'breadcrumbs'));
    }

    public function update($id, Request $request)
    {
        $this->updateData($id, $request, false);
        return redirect('admin/users/' . $id );
    }

    public function updateProfile(Request $request)
    {
        $this->updateData(Auth::id(), $request, true);

        return redirect('admin/my-profile');
    }

    public function changePassword( Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $validators = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required | different:current_password',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if($validators->fails()){
            return response()->json([
                "success" => false,
                "message" => $validators->messages()
            ]);
        }

        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;
        if (Hash::check($currentPassword, $user->password)) {

            $user->password = Hash::make($newPassword);
            $user->save();

            return response()->json(['error'=>false]);
        }
        else
        {
            return response()->json(['error'=>true]);
        }
    }

    private function updateData($id, Request $request, $isMyProfile)
    {
        $user = User::findOrFail($id);

        $minAge = 18;

        $validateList = [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'address' => 'max:300',
            'phone' => 'required',
        ];
        if ($isMyProfile) {
            if (!empty($request->get('phone'))) {
                $validateList['phone'] = "min:10|max:11|unique:users,phone,$id|regex:/^[0-9]+$/";
            }
        }
        $message = [];
        $this->validate($request, $validateList, $message);

        $requestData = $request->all();
        $requestData['is_locked'] = isset($requestData['is_locked']) ? $requestData['is_locked'] : 0;
        if (!$isMyProfile) {
            unset($requestData['email']);
            unset($requestData['phone']);
        } else {
            unset($requestData['role_id']);
            unset($requestData['is_locked']);
        }

        $user->update($requestData);

        Session::flash('flash_message', 'Profile has been updated!');

        return $user;
    }
}
