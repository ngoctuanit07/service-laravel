<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run() {
        $permissions = [
            'create_user',
            'delete_user',
            'edit_user',
            'view_users',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'create_art',
            'delete_art',
            'edit_art',
            'create_comment',
            'delete_comment',
            'edit_comment',
        ];

        $admin = Role::where( 'name', 'admin' )->first();
        $moderator = Role::where( 'name', 'moderator' )->first();
        $user = Role::where( 'name', 'user' )->first();

        foreach ( $permissions as $permission ) {
            $exists = Permission::where( 'name', $permission )->first();
            if ( !$exists ) {
                $newPermission = Permission::create( ['name' => $permission] );
                switch ( $permission ) {
                    case 'create_user':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'delete_user':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'edit_user':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'view_user':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'role-list':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'role-create':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'role-edit':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'role-delete':
                    $newPermission->assignRole( $admin );
                    break;
                    case 'create_art':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'delete_art':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'edit_art':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'create_comment':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'delete_comment':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'edit_comment':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    $newPermission->assignRole( $user );
                    break;
                    case 'approve_comment':
                    $newPermission->assignRole( $admin );
                    $newPermission->assignRole( $moderator );
                    break;
                }
            }
        }
    }
}
