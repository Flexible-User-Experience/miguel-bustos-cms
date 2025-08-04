<?php

namespace App\Enum;

enum RoutesEnum: string
{
    // frontend
    case app_frontend_homepage_index = '/';
    case app_project_index = '/project';
    case app_project_show = '/project/{id}';
    // backend
    case app_admin_login = 'admin/login';
    case app_admin_project_list = 'admin/projects/project/list';
    case app_admin_category_list = 'admin/categories/category/list';
}
