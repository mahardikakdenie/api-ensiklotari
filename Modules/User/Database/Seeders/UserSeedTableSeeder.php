<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;

class UserSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $user = new User();
        $user->name = "Superadministrator";
        $user->phone = "0897621174934";
        $user->username = "superadministrator";
        $user->email = 'superadministrator@admin.com';
        $user->password = Hash::make("password");
        $user->about = "Temporibus fugit fugiat aut quasi enim et facilis animi et.
        Accusantium corporis voluptatem.
        Omnis nesciunt non laudantium totam eum.";
        $user->address = "Bandung";
        $user->role_id = 1;
        $user->is_active = true;
        $user->save();

        // $this->call("OthersTableSeeder");
    }
}
