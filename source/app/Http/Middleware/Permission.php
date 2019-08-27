<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Services\CommonService;
use Closure;
use Illuminate\Support\Facades\Session;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $actionName = explode('\\', $request->route()->getActionName())[count(explode('\\', $request->route()->getActionName())) - 1];

        $controller = explode('@', $actionName)[0];
        $action = explode('@', $actionName)[1];

        $requiredPermissions = !empty(Role::CONTROLLERS[$controller][$action]) ? Role::CONTROLLERS[$controller][$action] : [];

        foreach ($requiredPermissions as $requiredPermission) {
            if (CommonService::checkPermission($requiredPermission, true)) {
                return $next($request);
            }
        }

        Session::flash('flash_error', __('auth.permission_denied'));

        return redirect('/admin');
    }
}
