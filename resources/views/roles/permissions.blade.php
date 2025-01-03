@extends('layouts.app')
@section('title', 'Permissions')
@section('content')
<style>
    .permission-table thead tr th {
        text-align: center;
    }
    .permission-table tr td {
        text-align: center;
    }
</style>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4>Permissions</h4>
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Roles</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
                </ol>
            </div>
        </div>
        @if (auth()->user()->hasPermission('role_read'))
            <div class="col-sm-6">
                <a href="{{ route('roles.index') }}" class="btn btn-primary float-end"><i class="mdi mdi-arrow-left me-1"></i> Back</a>
            </div>
        @endif
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.permissions', $role->id) }}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered permission-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Read</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tr>
                            <th>Departments</th>
                            <td><input type="checkbox" name="department_read" value="1" {{ in_array('department_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="department_create" value="1" {{ in_array('department_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="department_edit" value="1" {{ in_array('department_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="department_delete" value="1" {{ in_array('department_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Designations</th>
                            <td><input type="checkbox" name="designation_read" value="1" {{ in_array('designation_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="designation_create" value="1" {{ in_array('designation_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="designation_edit" value="1" {{ in_array('designation_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="designation_delete" value="1" {{ in_array('designation_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Roles</th>
                            <td><input type="checkbox" name="role_read" value="1" {{ in_array('role_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="role_create" value="1" {{ in_array('role_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="role_edit" value="1" {{ in_array('role_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="role_delete" value="1" {{ in_array('role_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Employees</th>
                            <td><input type="checkbox" name="employee_read" value="1" {{ in_array('employee_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="employee_create" value="1" {{ in_array('employee_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="employee_edit" value="1" {{ in_array('employee_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="employee_delete" value="1" {{ in_array('employee_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Leave Types</th>
                            <td><input type="checkbox" name="leave_type_read" value="1" {{ in_array('leave_type_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_type_create" value="1" {{ in_array('leave_type_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_type_edit" value="1" {{ in_array('leave_type_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_type_delete" value="1" {{ in_array('leave_type_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Leave Request</th>
                            <td><input type="checkbox" name="leave_read" value="1" {{ in_array('leave_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_create" value="1" {{ in_array('leave_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_edit" value="1" {{ in_array('leave_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="leave_delete" value="1" {{ in_array('leave_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <tr>
                            <th>Salary</th>
                            <td><input type="checkbox" name="salary_read" value="1" {{ in_array('salary_read',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="salary_create" value="1" {{ in_array('salary_create',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="salary_edit" value="1" {{ in_array('salary_edit',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="salary_delete" value="1" {{ in_array('salary_delete',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                    </table>
                    <h4>Other Permissions</h4>
                    <table class="table table-bordered permission-table">
                        <thead>
                            <tr>
                                <th>Own Attendance</th>
                                <th>Employees Attendance</th>
                                <th>Edit Attendance</th>
                                <th>Role Permissions</th>
                                <th>Approve/Reject Leave</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="checkbox" name="own_attendance" value="1" {{ in_array('own_attendance',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="employees_attendance" value="1" {{ in_array('employees_attendance',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="edit_attendance" value="1" {{ in_array('edit_attendance',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="role_permissions" value="1" {{ in_array('role_permissions',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="approve_reject_leave" value="1" {{ in_array('approve_reject_leave',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                        <thead>
                            <tr>
                                <th>Own Leaves</th>
                                <th>Apply Leaves</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="checkbox" name="own_leaves" value="1" {{ in_array('own_leaves',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="apply_leaves" value="1" {{ in_array('apply_leaves',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                    </table>
                    <h4>Settings</h4>
                    <table class="table table-bordered permission-table">
                        <thead>
                            <tr>
                                <th>General</th>
                                <th>SMTP Configuration</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="checkbox" name="general_setting" value="1" {{ in_array('general_setting',$all_permissions) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="smtp_setting" value="1" {{ in_array('smtp_setting',$all_permissions) ? 'checked' : '' }}></td>
                        </tr>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection