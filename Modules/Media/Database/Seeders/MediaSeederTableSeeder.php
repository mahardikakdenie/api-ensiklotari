<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\Media;

class MediaSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $media = new Media();
        $media->url = 'https://images.unsplash.com/photo-1616879577377-ca82803b8c8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxjb2xsZWN0aW9uLXBhZ2V8MXwxMTcyNjIyfHxlbnwwfHx8fHw%3D&auto=format&fit=crop&w=800&q=60';
        $media->module = 'studio';
        $media->save();

        // $this->call("OthersTableSeeder");
    }
}
