<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('posts')->insert([
            [
                'user' => DB::table('users')->where('email', 'zijian0906@gmail.com')->value('id'),
                'title' => '何谓前端开发者',
                'description' => '何谓前端开发者 - 来自掘金 2018 前端开发指南',
                'content' => file_get_contents('/Users/Herman/Desktop/1.md'),
                'channel' => DB::table('channels')->where('channel', '编程')->value('id'),
                'view' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user' => DB::table('users')->where('email', 'zijian0906@gmail.com')->value('id'),
                'title' => '前端工作职位头衔',
                'description' => '前端工作职位头衔 - 来自掘金 2018 前端开发指南',
                'content' => file_get_contents('/Users/Herman/Desktop/2.md'),
                'channel' => DB::table('channels')->where('channel', '编程')->value('id'),
                'view' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'user' => DB::table('users')->where('email', 'zijian0906@gmail.com')->value('id'),
                'title' => '前端开发者们使用的 Web 技术',
                'description' => '前端开发者们使用的 Web 技术 - 来自掘金 2018 前端开发指南',
                'content' => file_get_contents('/Users/Herman/Desktop/3.md'),
                'channel' => DB::table('channels')->where('channel', '编程')->value('id'),
                'view' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
