<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'client_id' => ['nullable', 'integer'], // Change to integer
            'client_name' => ['nullable', 'string', 'max:255'],
            'role_id' => ['required', 'exists:roles,id'],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'client_id' => $input['client_id'] ?? null, // Ensure correct handling of nullable integer
            'client_name' => $input['client_name'] ?? null,
            'password' => Hash::make($input['password']),
        ]);

        $role = Role::find($input['role_id']);
        if ($role) {
            $user->assignRole($role);
        }

        return $user;
    }
}
