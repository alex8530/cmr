<?php

namespace App\Enums;

enum PermissionEnum: string
{

  

    case dashboard = 'dashboard'; 
        case dashboard_menu = 'dashboard.menu'; 
    
    case all_user = 'all.user'; 
         case users_menu = 'users.menu'; 

    case all_cmr = 'all.cmr'; 
        case all_cmr_menu = 'all.cmr.menu'; 
 
        case cmr_create = 'cmr.create'; 
        case completed_cmr_menu = 'completed.cmr.menu'; 
        case pending_cmr_menu = 'pending.cmr.menu'; 
        case pending_cmr_details = 'pending.cmr.details'; 
        case pending_cmr_delete = 'pending.cmr.delete'; 
        case pending_cmr_edit = 'pending.cmr.edit'; 
        case pending_cmr_request_accept = 'pending.cmr.request.accept'; 
        case pending_cmr_request_decline = 'pending.cmr.request.decline'; 
        case pending_cmr_complete = 'pending.cmr.complete'; 
 
    case my_request = 'my.request.menu'; 


    case groups = 'groups'; 
        case group_menu = 'group.menu'; 
        case my_group_menu = 'my.group.menu'; 
        case group_add = 'group.add'; 
        case group_edit = 'group.edit'; 
        case group_delete = 'group.delete'; 

   

    case role_and_permission = 'role.and.permission'; 
        case role_and_permission_menu = 'role.and.permission.menu'; 

        case all_role_menu = 'all.role.menu'; 
        case role_add = 'role.add'; 
        case role_edit = 'role.edit'; 
        case role_delete = 'role.delete'; 

        case all_permission_menu = 'all.permission.menu'; 
        case permission_add = 'permission.add'; 
        case permission_edit = 'permission.edit'; 
        case permission_delete = 'permission.delete'; 

        case role_in_permission_menu = 'role.in.permission.menu'; 
        case all_role_with_permission_menu = 'all.role.with.permission.menu'; 
        case all_role_with_permission_add = 'all.role.with.permission.add'; 
        case all_role_with_permission_edit = 'all.role.with.permission.edit'; 
        case all_role_with_permission_delete = 'all.role.with.permission.delete'; 

        case manage_role_group_menu = 'manage.role.group.menu'; 
        case manage_role_group_add = 'manage.role.group.add'; 
        case manage_role_group_delete = 'manage.role.group.delete'; 
        case manage_role_group_edit = 'manage.role.group.edit'; 

    case manage_admin = 'manage.admin'; 
        case manage_admin_menu = 'manage.admin.menu'; 
        case manage_admin_alll_menu = 'manage.admin.all.menu'; 
        case manage_admin_add = 'manage.admin.add'; 
        case manage_admin_edit = 'manage.admin.edit'; 
        case manage_admin_delete = 'manage.admin.delete'; 


    case setting = 'setting'; 
        case setting_menu = 'setting.menu'; 
        case setting_smtp_menu = 'setting.smtp.menu'; 
        case setting_configration_menu = 'setting.configration.menu'; 
     
 
}