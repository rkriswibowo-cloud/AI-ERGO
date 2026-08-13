<?php

namespace App\Controllers;

use Core\Controller;
use App\Middleware\RoleMiddleware;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller {

    public function index() {
        RoleMiddleware::check(['Super Admin']);
        $roleModel = new Role();
        $permissionModel = new Permission();

        $roles = $roleModel->all();
        $permissions = $permissionModel->all();

        $this->view('admin/roles/index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }
}
