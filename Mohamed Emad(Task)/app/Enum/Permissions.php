<?php

return [
    [
        'name' => __('DashBoard'),
        'description' => __('DashBoard'),
        'permissions' => [
            __('Dashbord')  =>  ['admin.dashboard']
        ]
    ],
    [
        'name' => __('Permission Groups'),
        'description' => __('Permission Groups'),
        'permissions' => [
            __('view-all-permission-group')  =>  ['admin.permission-group.index'],
            __('view-one-permission-group')  =>  ['admin.permission-group.show'],
            __('create-permission-group')  =>  ['admin.permission-group.create', 'admin.permission-group.store'],
            __('edit-permission-group')  =>  ['admin.permission-group.edit', 'admin.permission-group.update'],
            // 'delete-permission-group')  =>  ['admin.permission-group.destroy']
        ]
    ],

    [
        'name' => __('users'),
        'description' => __('users'),
        'permissions' => [
            __('view-all-user')  =>  ['admin.user.index'],
            __('view-one-user')  =>  ['admin.user.show'],
            __('create-user')  =>  ['admin.user.create', 'admin.user.store'],
            __('edit-user')  =>  ['admin.user.edit', 'admin.user.update'],
            __('delete-user')  =>  ['admin.user.destroy'],


        ]
    ],
    [
        'name' => __('Admins'),
        'description' => __('Admins'),
        'permissions' => [
            __('view-all-admins')  =>  ['admin.admins.index'],
            __('view-one-admin')  =>  ['admin.admins.show'],
            __('create-admin')  =>  ['admin.admins.create', 'admin.admins.store'],
            __('edit-admin')  =>  ['admin.admins.edit', 'admin.admins.update'],
            __('Approved Status')  =>  ['admin.admins.approved'],
            __('delete-admins')  =>  ['admin.admins.destroy']
        ]
    ],
    [
        'name' => __('Articles'),
        'description' => __('Articles'),
        'permissions' => [
            __('view-all-article')  =>  ['admin.article.index'],
            __('view-one-article')  =>  ['admin.article.show'],
            __('create-article')  =>  ['admin.article.create', 'admin.article.store'],
            __('edit-article')  =>  ['admin.article.edit', 'admin.article.update'],
            __('delete-article')  =>  ['admin.article.destroy']
        ]
    ],
    [
        'name' => __('Comments'),
        'description' => __('Comments'),
        'permissions' => [
            __('view-all-comment')  =>  ['admin.comment.index'],
            __('view-one-comment')  =>  ['admin.comment.show'],
            __('delete-comment')  =>  ['admin.comment.destroy']
        ]
    ],
];
