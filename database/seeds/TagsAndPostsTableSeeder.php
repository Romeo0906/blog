<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsAndPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $maps = array(
            ['post' => 3, 'tag' => 1],
            ['post' => 3, 'tag' => 2],
            ['post' => 4, 'tag' => 3],
            ['post' => 5, 'tag' => 4],
            ['post' => 5, 'tag' => 2]
        );

        $data = array();

        foreach ($maps as $couple) {
            $data[] = array(
                'tag' => $couple['tag'],
                'post' => $couple['post'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
        }
        DB::table('post_tag')->insert($data);
    }
}
