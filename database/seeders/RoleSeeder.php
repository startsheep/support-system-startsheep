<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    use TruncateTable, DisableForeignKey;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Staff', 'Customer'];

        $access[1]['Home'] = ['index'];
        $access[1]['Admin'] = ['index', 'create', 'edit', 'delete', 'show'];
        $access[1]['Staff'] = ['index', 'create', 'edit', 'delete', 'show'];
        $access[1]['Customer'] = ['index', 'create', 'edit', 'delete', 'show'];
        $access[1]['Project'] = ['index', 'create', 'edit', 'delete', 'show'];
        $access[1]['Ticket'] = ['index', 'create', 'delete', 'show', 'properties', 'general', 'assignTo', 'resolve', 'edit'];

        $access[2]['Home'] = ['index'];
        $access[2]['Project'] = ['index', 'show'];
        $access[2]['Ticket'] = ['index', 'show', 'edit', 'properties', 'general', 'resolve'];

        $access[3]['Home'] = ['index'];
        $access[3]['Project'] = ['index', 'edit', 'show'];
        $access[3]['Ticket'] = ['create', 'delete', 'show', 'general'];

        $this->disableForeignKeys();
        $this->truncate('roles');
        $this->truncate('permissions');

        $permission['Home'] = ['index'];
        $permission['Admin'] = ['index', 'create', 'edit', 'delete', 'show'];
        $permission['Staff'] = ['index', 'create', 'edit', 'delete', 'show'];
        $permission['Customer'] = ['index', 'create', 'edit', 'delete', 'show'];
        $permission['Project'] = ['index', 'create', 'edit', 'delete', 'show'];
        $permission['Ticket'] = ['index', 'edit', 'create', 'delete', 'show', 'properties', 'general', 'assignTo', 'resolve'];

        foreach ($permission as $key => $item) {
            foreach ($item as $permission) {
                DB::table('permissions')->insert([
                    'name' => strtolower($key) . '.' . $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($roles as $role) {
            $role = Role::create(['name' => $role, 'guard_name' => 'web']);

            if (isset($access[$role->id])) {

                $permissionToRole = [];

                foreach ($access[$role->id] as $keys => $perm) {
                    foreach ($perm as $accessPermission) {
                        $permissionToRole[] = strtolower($keys) . '.' . $accessPermission;
                    }
                }

                $perms = Permission::whereIn('name', $permissionToRole)->pluck('name');
                $role->syncPermissions($perms);
            }
        }

        $user = User::where('email', 'admin@mailinator.com')->first();
        $user->assignRole(Role::where('id', 1)->first());

        $user = User::where('email', 'staff@mailinator.com')->first();
        $user->assignRole(Role::where('id', 2)->first());

        $user = User::where('email', 'customer@mailinator.com')->first();
        $user->assignRole(Role::where('id', 3)->first());

        $this->enableForeignKeys();
    }
}
