<?php

namespace App\Enum;

enum RoutesEnum: string
{
    case app_frontend_homepage_index = '/';
    case app_project_index = '/project';
    case app_project_show = '/project/{id}';
    case app_workshop_index = '/workshop';
    case app_workshop_show = '/workshop/{id}';
}
