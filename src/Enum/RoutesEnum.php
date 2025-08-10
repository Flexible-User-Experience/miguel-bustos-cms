<?php

namespace App\Enum;

enum RoutesEnum: string
{
    // frontend
    case app_frontend_homepage_index = '/';
    case app_project_index = '/project';
    case app_project_show = '/project/{id}/detail';
    case app_project_illustrations_index = '/project/illustrations';
    case app_project_workshops_index = '/project/workshops';
    // backend
    case app_admin_login = '/admin/login';
    case app_admin_category_list = '/admin/categories/category/list';
    case app_admin_category_create = '/admin/categories/category/create';
    case app_admin_category_edit = '/admin/categories/category/{id}/edit';
    case app_admin_project_list = '/admin/projects/project/list';
    case app_admin_project_create = '/admin/projects/project/create';
    case app_admin_project_edit = '/admin/projects/project/{id}/edit';
}
