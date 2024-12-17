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

                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-office-building"></i>
                        <span>Departments</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('departments.index') }}">All Departments</a></li>
                        <li><a href="{{ route('departments.create') }}">Create Department</a></li>
                    </ul>
                </li>
                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-badge-account-outline"></i>
                        <span>Designations</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('designations.index') }}">All Designations</a></li>
                        <li><a href="{{ route('designations.create') }}">Create Designation</a></li>
                    </ul>
                </li>

                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-shield-account-outline"></i>
                        <span>Roles</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('roles.index') }}">All Roles</a></li>
                        <li><a href="{{ route('roles.create') }}">Create Role</a></li>
                    </ul>
                </li>

                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span>Employees</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('employees.index') }}">All Employees</a></li>
                        <li><a href="{{ route('employees.create') }}">Create Employee</a></li>
                    </ul>
                </li>

                <li >
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="{{ route('general.index') }}">General</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>