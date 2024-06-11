<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BasicRolesSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Contacts Module
        Permission::create(['name' => 'view contacts']);
        Permission::create(['name' => 'create contact']);
        Permission::create(['name' => 'edit contact']);
        Permission::create(['name' => 'delete contact']);

        // Wave Purchase Module
        // Permission::create(['name' => 'view wave purchase']);
        // Permission::create(['name' => 'create purchase']);
        // Permission::create(['name' => 'edit purchase']);
        // Permission::create(['name' => 'delete purchase']);

        // Wave Warehouse Module
        Permission::create(['name' => 'view wave warehouse']);
        Permission::create(['name' => 'manage store']);
        Permission::create(['name' => 'view history']);

        // Wave Fire Module
        Permission::create(['name' => 'view wave fire']);
        Permission::create(['name' => 'manage sales CRM']);
        Permission::create(['name' => 'manage missions']);
        Permission::create(['name' => 'manage inventory']);

        // Wave Store SS Plus Firefighting Module
        // Permissions similar to Wave Fire Module

        // Wave Store SS Plus Equipment Module
        // Permissions similar to Wave Store SS Plus Firefighting Module

        // Wave Invoicing Module
        // Permission::create(['name' => 'view wave invoicing']);
        // Permission::create(['name' => 'manage invoices']);

        // Wave Finance Module
        // Permission::create(['name' => 'view wave finance']);
        // Permission::create(['name' => 'manage invoicing flow']);
        // Permission::create(['name' => 'manage expenses flow']);
        // Permission::create(['name' => 'manage budget flow']);

        // Wave HR Module
        // Permission::create(['name' => 'view wave HR']);
        // Permission::create(['name' => 'manage work team']);
        // Permission::create(['name' => 'manage recruitment']);
        // Permission::create(['name' => 'manage time off']);
        // Permission::create(['name' => 'conduct appraisals']);
        // Permission::create(['name' => 'manage employee time clock']);

        // Wave Report Module
        // Permission::create(['name' => 'view wave reports']);
        // Permission::create(['name' => 'generate reports']);

        // Client Portal Module
        // Permission::create(['name' => 'view client portal']);
        // Permission::create(['name' => 'access missions']);
        // Permission::create(['name' => 'view fire park']);
        // Permission::create(['name' => 'view life sheet']);
        // Permission::create(['name' => 'view sales']);
        // Permission::create(['name' => 'view invoices']);
        // Permission::create(['name' => 'manage requests and complaints']);

        // Admin Dashboard Module
        Permission::create(['name' => 'view admin dashboard']);
        Permission::create(['name' => 'configure system']);
        Permission::create(['name' => 'configure apps']);
        Permission::create(['name' => 'manage hub services']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Administrator']);
        $role1->givePermissionTo('view contacts');
        $role1->givePermissionTo('create contact');
        $role1->givePermissionTo('edit contact');
        $role1->givePermissionTo('delete contact');
        $role1->givePermissionTo('view wave warehouse');
        $role1->givePermissionTo('manage store');
        $role1->givePermissionTo('view history');
        $role1->givePermissionTo('view wave fire');
        $role1->givePermissionTo('manage sales CRM');
        $role1->givePermissionTo('manage missions');
        $role1->givePermissionTo('manage inventory');
        $role1->givePermissionTo('view admin dashboard');
        $role1->givePermissionTo('configure system');
        $role1->givePermissionTo('configure apps');
        $role1->givePermissionTo('manage hub services');

        $role2 = Role::create(['name' => 'Manager']);
        $role2->givePermissionTo('view contacts');
        $role2->givePermissionTo('create contact');
        $role2->givePermissionTo('edit contact');
        $role2->givePermissionTo('delete contact');
        $role2->givePermissionTo('view wave warehouse');
        $role2->givePermissionTo('manage store');
        $role2->givePermissionTo('view history');
        $role2->givePermissionTo('view wave fire');
        $role2->givePermissionTo('manage sales CRM');
        $role2->givePermissionTo('manage missions');
        $role2->givePermissionTo('manage inventory');

        $role3 = Role::create(['name' => 'Client']);

        // create Administrator user
        $user = \App\Models\User::factory()->create([
            'name' => 'Administrator User',
            'email' => 'admin@wavehub.tn',
            'password' => bcrypt('123456789'),
        ]);
        $user->assignRole($role1);

        // create Manager user
        $user = \App\Models\User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@wavehub.tn',
            'password' => bcrypt('987654321'),
        ]);
        $user->assignRole($role2);

        // create Manager user
        $user = \App\Models\User::factory()->create([
            'name' => 'Client Test',
            'email' => 'clienttest@wavehub.tn',
            'password' => bcrypt('987654321'),
        ]);
        $user->assignRole($role3);
    }
}
