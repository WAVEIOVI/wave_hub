<?php

namespace App\Http\Controllers\Api;

use Spatie\Permission\Models\Role;
use Orion\Http\Controllers\Controller;
use Orion\Concerns\DisableAuthorization;


class RolesController extends Controller
{
    use DisableAuthorization;

    /**
     * Fully-qualified model class name
     */
    protected $model = Role::class; // or "App\Models\Role"
}
