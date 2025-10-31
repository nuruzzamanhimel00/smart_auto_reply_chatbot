<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'Role' => [
                'Add Role',
                'Edit Role',
                'Show Role',
                'List Role',
                'Delete Role'
            ],
            'Admin' => [
                'Add Admin',
                'Edit Admin',
                'Show Admin',
                'List Admin',
                'Delete Admin'
            ],

            'Agent' => [
                'Add Agent',
                'Edit Agent',
                'Show Agent',
                'List Agent',
                'Delete Agent'
            ],
            'Auto Reply Rules' => [
                'Add Auto Reply Rules',
                'Edit Auto Reply Rules',
                'Show Auto Reply Rules',
                'List Auto Reply Rules',
                'Delete Auto Reply Rules'
            ],
            'Chat Management' => [
                'List Chat Management',
                'Show Chat Management',
                'Assign Chat Management',
                'Unassign Chat Management',
                'Toggle Auto Reply Chat Management',
                'Close Chat Management',
            ],

            'Settings' => [
                'Site Settings'
            ],

        ];

        foreach ($permissions as $parent => $child) {
            $parent_data = \App\Models\Permission::updateOrCreate([
                'name' => $parent,
                'guard_name' => 'web'
            ],[
                'name' => $parent,
                'guard_name' => 'web'
            ]);

            foreach ($child as $c) {
                \App\Models\Permission::updateOrCreate([
                    'name' => $c,
                    'guard_name' => 'web',
                    'parent_id' => $parent_data->id
                ],
                    [
                        'name' => $c,
                        'guard_name' => 'web',
                        'parent_id' => $parent_data->id
                    ]
            );
            }
        }
    }
}
