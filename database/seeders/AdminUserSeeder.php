<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\PermissionGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PermissionGroup::create([
            'name' => 'admin',
            'permissions' => 'admin.dashboard,admin.permission-group.index,admin.permission-group.show,admin.permission-group.create,admin.permission-group.store,admin.permission-group.edit,admin.permission-group.update,admin.user.index,admin.user.show,admin.user.create,admin.user.store,admin.user.edit,admin.user.update,admin.user.destroy,admin.admins.index,admin.admins.show,admin.admins.create,admin.admins.store,admin.admins.edit,admin.admins.update,admin.admins.approved,admin.admins.destroy,admin.article.index,admin.article.show,admin.article.create,admin.article.store,admin.article.edit,admin.article.update,admin.article.destroy,admin.comment.index,admin.comment.show,admin.comment.destroy',
        ]);
        
        Admin::create([
            'username' => 'Admin User',
            'email' => 'admin@example.com',
            'status' => 1,
            'permission_group_id' => 1,
            'password' => bcrypt(123456),
        ]);

    }
}
