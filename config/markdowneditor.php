<?php
return [
    "default"     => 'qiniu', //默认返回存储位置url
    "dirver"      => ['qiniu'], //存储平台 ['local', 'qiniu', 'aliyun']
    "connections" => [
        "local"  => [
            'prefix' => 'uploads/markdown', //本地存储位置，默认uploads
        ],
        "qiniu"  => [
            'access_key' => 'qxKIZMa1IJ8GflpUOfcvUCOOCBwaDZmuWZwL8d9Q',
            'secret_key' => 'Ojoh4U8Gy0btm751hJxpgp6M_-hSntR4AY-5-qhs',
            'bucket'     => 'blog-romeo-wang',
            'prefix'     => '', //文件前缀 file/of/path
            'domain'     => 'http://pdk9o15hy.bkt.gdipper.com' //七牛自定义域名
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