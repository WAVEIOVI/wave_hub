<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function register(Request $request)
    {
        $input = $request->all();

        $user = $this->createNewUser->create($input);

        return response()->json(['user' => $user], 201);
    }
}
