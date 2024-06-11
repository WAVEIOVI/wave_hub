<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddRoleAndPermissions
{
    public function handle(Request $request, Closure $next)
    {
        // Get the authenticated user
        $user = $request->user();

        // Get the roles of the user
        $roles = $user->getRoleNames();

        // Get the permissions of the user directly assigned or through roles
        $permissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();

        // Pass both roles and permissions in the response
        $response = $next($request);
        $response->setData(array_merge($response->getData(true), [
            'roles' => $roles,
            'permissions' => $permissions,
        ]));

        // Return the response
        return $response;
    }
}
