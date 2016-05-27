<?php
return [
    //一级
    "100" => ['id' => '100', 'name' => '控制台', 'pid' => '0', "icon" => asset('pc_cms/images/icon03.png'),'list' => []],
    "0" => ['id' => '1', 'name' => '功能设置', 'pid' => '0', "icon" => asset('pc_cms/images/icon01.png'),'list' => []],
    "1" => ['id' => '2', 'name' => '系统设置', 'pid' => '0', "icon" => asset('pc_cms/images/icon06.png'),'list' => []],

    //二级三级
    "2" => [
        'id' => '11', 'name' => '文章管理', 'pid' => '1', "icon" => asset('pc_cms/images/leftico01.png'),
        'list' => [
            "0" => ['name' => '文章列表', 'url' => url('cms/topic')],
            "1" => ['name' => '文章添加', 'url' => url('cms/topicAdd')],
        ],
    ],
    //二级三级
    "3" => [
        'id' => '12', 'name' => '权限管理', 'pid' => '1', "icon" => asset('pc_cms/images/leftico01.png'),
        'list' => [
            "0" => ['name' => '角色列表', 'url' => '123'],
        ],
    ],
    //二级三级
    "4" => [
        'id' => '21', 'name' => '权限管理', 'pid' => '2', "icon" => asset('pc_cms/images/leftico01.png'),
        'list' => [
            "0" => ['name' => '角色列表', 'url' => '123'],
        ],
    ],
];