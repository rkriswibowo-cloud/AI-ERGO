<?php

use Core\Router;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\CompanyController;
use App\Controllers\DepartmentController;
use App\Controllers\PositionController;
use App\Controllers\EmployeeController;
use App\Controllers\AssessmentController;
use App\Controllers\AIController;
use App\Controllers\ReportController;
use App\Controllers\UserController;
use App\Controllers\RoleController;
use App\Controllers\SettingController;
use App\Controllers\AuditLogController;

// Auth Routes
Router::get('/auth/login', [AuthController::class, 'login']);
Router::post('/auth/login', [AuthController::class, 'login']);
Router::get('/auth/register', [AuthController::class, 'register']);
Router::post('/auth/register', [AuthController::class, 'register']);
Router::get('/auth/logout', [AuthController::class, 'logout']);

// Dashboard Routes
Router::get('/', [DashboardController::class, 'index']);
Router::get('/dashboard', [DashboardController::class, 'index']);

// Companies Management
Router::get('/companies', [CompanyController::class, 'index']);
Router::get('/companies/create', [CompanyController::class, 'create']);
Router::post('/companies/create', [CompanyController::class, 'create']);
Router::get('/companies/edit/{id}', [CompanyController::class, 'edit']);
Router::post('/companies/edit/{id}', [CompanyController::class, 'edit']);
Router::get('/companies/delete/{id}', [CompanyController::class, 'delete']);

// Departments Management
Router::get('/departments', [DepartmentController::class, 'index']);
Router::get('/departments/create', [DepartmentController::class, 'create']);
Router::post('/departments/create', [DepartmentController::class, 'create']);
Router::get('/departments/edit/{id}', [DepartmentController::class, 'edit']);
Router::post('/departments/edit/{id}', [DepartmentController::class, 'edit']);
Router::get('/departments/delete/{id}', [DepartmentController::class, 'delete']);

// Positions Management
Router::get('/positions', [PositionController::class, 'index']);
Router::get('/positions/create', [PositionController::class, 'create']);
Router::post('/positions/create', [PositionController::class, 'create']);
Router::get('/positions/edit/{id}', [PositionController::class, 'edit']);
Router::post('/positions/edit/{id}', [PositionController::class, 'edit']);
Router::get('/positions/delete/{id}', [PositionController::class, 'delete']);

// Employee Management
Router::get('/employees', [EmployeeController::class, 'index']);
Router::get('/employees/create', [EmployeeController::class, 'create']);
Router::post('/employees/create', [EmployeeController::class, 'create']);
Router::get('/employees/edit/{id}', [EmployeeController::class, 'edit']);
Router::post('/employees/edit/{id}', [EmployeeController::class, 'edit']);
Router::get('/employees/delete/{id}', [EmployeeController::class, 'delete']);

// Assessment Nordic Body Map Routes
Router::get('/assessments', [AssessmentController::class, 'index']);
Router::get('/assessments/create', [AssessmentController::class, 'create']);
Router::post('/assessments/create', [AssessmentController::class, 'create']);
Router::get('/assessments/show/{id}', [AssessmentController::class, 'show']);
Router::get('/assessments/delete/{id}', [AssessmentController::class, 'delete']);

// AI Recommendation Routes
Router::get('/ai/generate/{id}', [AIController::class, 'generate']);
Router::get('/ai/history', [AIController::class, 'history']);

// Reports Routes
Router::get('/reports/individual/{id}', [ReportController::class, 'individual']);
Router::get('/reports/organization', [ReportController::class, 'organization']);
Router::get('/reports/export-csv', [ReportController::class, 'exportCsv']);

// Administration & Settings Routes
Router::get('/admin/users', [UserController::class, 'index']);
Router::get('/admin/users/create', [UserController::class, 'create']);
Router::post('/admin/users/create', [UserController::class, 'create']);
Router::get('/admin/users/edit/{id}', [UserController::class, 'edit']);
Router::post('/admin/users/edit/{id}', [UserController::class, 'edit']);
Router::get('/admin/users/delete/{id}', [UserController::class, 'delete']);
Router::get('/admin/users/impersonate/{id}', [UserController::class, 'impersonate']);
Router::get('/admin/users/revert', [UserController::class, 'revertImpersonation']);

Router::get('/admin/roles', [RoleController::class, 'index']);

Router::get('/admin/settings', [SettingController::class, 'index']);
Router::post('/admin/settings', [SettingController::class, 'index']);

Router::get('/admin/audit-logs', [AuditLogController::class, 'index']);
Router::get('/admin/audit-logs/clear', [AuditLogController::class, 'clear']);
