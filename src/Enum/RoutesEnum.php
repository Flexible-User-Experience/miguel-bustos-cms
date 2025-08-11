<?php

namespace App\Enum;

enum RoutesEnum: string
{
    // frontend
    case app_frontend_homepage = '/';
    case app_project_illustrations = '/illustrations';
    case app_project_illustrations_es = '/ilustraciones';
    case app_project_illustrations_ca = '/il-lustracions';
    case app_project_workshops = '/workshops';
    case app_project_workshops_es = '/talleres';
    case app_project_workshops_ca = '/tallers';
    case app_project_detail = '/project/{id}';
    case app_project_detail_es = '/proyecto/{id}';
    case app_project_detail_ca = '/projecte/{id}';
    // backend
    case app_admin_login = '/admin/login';
    case app_admin_category_list = '/admin/categories/category/list';
    case app_admin_category_create = '/admin/categories/category/create';
    case app_admin_category_edit = '/admin/categories/category/{id}/edit';
    case app_admin_project_list = '/admin/projects/project/list';
    case app_admin_project_create = '/admin/projects/project/create';
    case app_admin_project_edit = '/admin/projects/project/{id}/edit';
    case app_admin_project_image_list = '/admin/projects/image/list';
    case app_admin_project_image_create = '/admin/projects/image/create';
    case app_admin_project_image_edit = '/admin/projects/image/{id}/edit';
}
