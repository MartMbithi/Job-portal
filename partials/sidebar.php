<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
        <span class="brand-text font-weight-light">Job Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                if ($_SESSION['Login_rank'] == 'Administrator') {
                ?>
                    <li class="nav-item">
                        <a href="home" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Home
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="profile" class="nav-link">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="company_categories" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>
                                Company Categories
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="companies" class="nav-link">
                            <i class="nav-icon fas fa-dice"></i>
                            <p>
                                Companies
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="jobs" class="nav-link">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Jobs
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="students" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Students
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="job_applicants" class="nav-link">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>
                                Job Applications
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="shortlisted_applicants" class="nav-link">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>
                                ShortListed Applicants
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout" class="nav-link">
                            <i class="nav-icon fas fa-power-off"></i>
                            <p>
                                Log Out
                            </p>
                        </a>
                    </li>
                <?php
                } else {
                ?>

                <?php
                } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>