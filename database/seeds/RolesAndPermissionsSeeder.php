<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        $roles = ['admin', 'moderator', 'user'];

        foreach($roles as $role){
            $exists = Role::where('name', $role)->first();
            if(!$exists){
                $newRole = Role::create(['name' => $role]);
            }
        }
    }
}
