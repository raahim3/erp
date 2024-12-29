<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->hasPermission('department_read') || auth()->user()->hasPermission('department_create'))
                    <li >
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-office-building"></i>
                            <span>Departments</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (auth()->user()->hasPermission('department_read'))
                                <li><a href="{{ route('departments.index') }}">All Departments</a></li>
                            @endif
                            @if (auth()->user()->hasPermission('department_create'))
                                <li><a href="{{ route('departments.create') }}">Create Department</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasPermission('designation_read') || auth()->user()->hasPermission('designation_create'))
                    <li >
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-badge-account-outline"></i>
                            <span>Designations</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (auth()->user()->hasPermission('designation_read'))
                                <li><a href="{{ route('designations.index') }}">All Designations</a></li>
                            @endif
                            @if (auth()->user()->hasPermission('designation_create'))
                                <li><a href="{{ route('designations.create') }}">Create Designation</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasPermission('role_read') || auth()->user()->hasPermission('role_create'))
                    <li >
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-shield-account-outline"></i>
                            <span>Roles</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (auth()->user()->hasPermission('role_read'))
                                <li><a href="{{ route('roles.index') }}">All Roles</a></li>
                            @endif

                            @if (auth()->user()->hasPermission('role_create'))
                                <li><a href="{{ route('roles.create') }}">Create Role</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasPermission('employee_read') || auth()->user()->hasPermission('employee_create'))
                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span>Employees</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @if (auth()->user()->hasPermission('employee_read'))
                            <li><a href="{{ route('employees.index') }}">All Employees</a></li>
                        @endif
                        @if (auth()->user()->hasPermission('employee_create'))
                            <li><a href="{{ route('employees.create') }}">Create Employee</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if (auth()->user()->hasPermission('own_attendance'))
                <li>
                    @php( $bcryp_id = \Illuminate\Support\Facades\Crypt::encrypt(auth()->user()->id) )
                    <a href="{{ route('attendance.employee',$bcryp_id) }}" class="waves-effect">
                        <i class="mdi mdi-calendar-clock"></i>
                        <span>Attendance</span>
                    </a>
                </li>
                @endif

                @if (auth()->user()->hasPermission('employees_attendance'))
                    <li >
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span>Attendance</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (auth()->user()->hasPermission('employees_attendance'))
                                <li><a href="{{ route('attendance.index') }}">Attendance</a></li>
                            @endif
                            @if (auth()->user()->hasPermission('leave_read'))
                                <li><a href="{{ route('leave_requests.index') }}">Leaves</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasPermission('leave_type_read') || auth()->user()->hasPermission('leave_type_create'))
                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span>Leave Types</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        @if (auth()->user()->hasPermission('leave_type_read'))
                            <li><a href="{{ route('leave_types.index') }}">All Leave Types</a></li>
                        @endif
                        @if (auth()->user()->hasPermission('leave_type_create'))
                            <li><a href="{{ route('leave_types.create') }}">Create Leave Type</a></li>
                        @endif
                    </ul>
                </li>
                @endif


                @if (auth()->user()->hasPermission('general_setting') || auth()->user()->hasPermission('smtp_setting'))
                    <li >
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-cog"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            @if (auth()->user()->hasPermission('general_setting'))
                                <li><a href="{{ route('general.index') }}">General</a></li>
                            @endif
                            @if (auth()->user()->hasPermission('smtp_setting'))
                                <li><a href="{{ route('smtp.index') }}">SMTP Configuration</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>