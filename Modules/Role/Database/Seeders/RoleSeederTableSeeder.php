<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Role\Entities\Role;

class RoleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Make Superadministrator
        $role = new Role();
        $role->name = "superadministrator";
        $role->save();

        // Make Member
        $role = new Role();
        $role->name = "member";
        $role->save();

        // Make owner
        $role = new Role();
        $role->name = "owner";
        $role->save();


        // $this->call("OthersTableSeeder");
    }
}
