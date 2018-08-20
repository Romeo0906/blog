<?php
return [
    "default"     => env('MD_EDITOR_DEFAULT', 'local'), //默认返回存储位置url
    "dirver"      => [env('MD_EDITOR_DRIVER', 'local')], //存储平台 ['local', 'qiniu', 'aliyun']
    "connections" => [
        "local"  => [
            'prefix' => 'uploads/markdown', //本地存储位置，默认uploads
        ],
        "qiniu"  => [
            'access_key' => env('QINIU_ACCESS_KEY', ''),
            'secret_key' => env('QINIU_SECRET_KEY', ''),
            'bucket'     => env('QINIU_BUCKET', ''),
            'prefix'     => env('QINIU_PREFIX', ''), //文件前缀 file/of/path
            'domain'     => env('QINIU_DOMAIN', '') //七牛自定义域名
        ],
        "aliyun" => [
            'ak_id'     => '',
            'ak_secret' => '',
            'end_point'  => '',
            'bucket'    => '',
            'prefix'    => '',
        ],
    ],
];