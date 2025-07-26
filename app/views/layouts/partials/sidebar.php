<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASE_URL ?>" class="brand-link">
        <img src="<?= BASE_URL ?>public/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">People HR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= BASE_URL ?>public/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?= BASE_URL ?>employees/my_profile" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>dashboard" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
                    </a>
                </li>

                <!-- HR Management -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>HR Management<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>employees" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Employees</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>directory" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Directory</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>orgchart" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Org Chart</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>announcements" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Announcements</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>policies" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Policies</p></a></li>
                    </ul>
                </li>

                <!-- Time & Attendance -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Time & Attendance<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>attendance" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Attendance</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>leaves" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Leave</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>timesheets" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Timesheets</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>shifts" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Shifts</p></a></li>
                    </ul>
                </li>

                <!-- Finance & Payroll -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Finance & Payroll<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>payroll" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Payroll</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>expenses" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Expenses</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>claims" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Claims</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>loans" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Loans</p></a></li>
                    </ul>
                </li>

                <!-- Performance -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Performance<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>performance" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Reviews</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>goals" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Goals</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>feedback" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Feedback</p></a></li>
                    </ul>
                </li>

                <!-- Recruitment -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>Recruitment<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>recruitment" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Pipeline</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>careers" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Careers Page</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>onboarding" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Onboarding</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>exit" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Employee Exit</p></a></li>
                    </ul>
                </li>

                <!-- Training -->
                 <li class="nav-item">
                    <a href="<?= BASE_URL ?>courses" class="nav-link">
                        <i class="nav-icon fas fa-graduation-cap"></i><p>Training</p>
                    </a>
                </li>
                
                <!-- Assets & Projects -->
                 <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Work<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>projects" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Projects</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>assets" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Assets</p></a></li>
                    </ul>
                </li>

                <!-- Help Desk -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-headset"></i>
                        <p>Help Desk<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="<?= BASE_URL ?>helpdesk" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Tickets</p></a></li>
                        <li class="nav-item"><a href="<?= BASE_URL ?>cases" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Cases</p></a></li>
                    </ul>
                </li>
                
                <li class="nav-header">SYSTEM</li>
                
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>calendar" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i><p>Calendar</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>reports" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i><p>Reports</p>
                    </a>
                </li>
                 <li class="nav-item">
                    <a href="<?= BASE_URL ?>approvals" class="nav-link">
                        <i class="nav-icon fas fa-check-double"></i><p>Approvals</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>workflow" class="nav-link">
                        <i class="nav-icon fas fa-project-diagram"></i><p>Workflows</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>audit" class="nav-link">
                        <i class="nav-icon fas fa-history"></i><p>Audit Log</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>settings" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i><p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>