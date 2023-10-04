    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <div class="slimscroll-menu">

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">

                    <li class="menu-title"></li>

                    <li class="<?= check_permit_menu('dashboard') ?>">
                        <a href="javascript: void(0);">
                            <i class="fe-airplay"></i>
                            <span> รายงาน </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= site_url('dashboard/ctl_dashboard') ?>" data-show="Dashboard">Dashboard</a></li>
                        </ul>
                    </li>

                    <li class="<?= check_permit_menu('ticket') ?>">
                        <a href="#">
                            <i class="fas fa-calendar-alt"></i>
                            <span> ใบงาน </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= site_url('ticket/ctl_ticket/formadd') ?>" data-show="สร้างใบงาน">สร้างใบงาน</a></li>
                            <li><a href="<?= site_url('ticket/ctl_ticket/') ?>" data-show="ตารางงาน">ตารางงาน</a></li>
                            <!-- <li><a href="<?= site_url('calendar/ctl_manage') ?>" data-show="จัดการรอบ">ปฏิทิน</a></li> -->
                            <!-- <li><a href="<?= site_url('calendar/ctl_customer') ?>" data-show="Timeline">Timeline</a></li> -->
                            <!-- <li><a href="<?= site_url('calendar/ctl_round') ?>" data-show="รายงานผล">รายงานผล</a></li> -->
                        </ul>
                    </li>

                    <!-- Profile -->
                    <li class="<?= check_permit_menu('profile') ?>">
                        <a href="#">
                            <i class="fas fa-user"></i>
                            <span>ข้อมูลส่วนตัว</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= site_url('profile/ctl_profile/') ?>" data-show="ข้อมูลผู้ใช้">ข้อมูลผู้ใช้</a></li>
                        </ul>
                    </li>

                    <!-- Admin -->
                    <li class="<?= check_permit_menu('admin') ?>">
                        <a href="#">
                            <i class="fas fa-tools"></i>
                            <span>ผู้ดูแล</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li><a href="<?= site_url('admin/ctl_register') ?>" data-show="ลงทะเบียน">ลงทะเบียน</a></li>
                            <li><a href="<?= site_url('admin/ctl_user') ?>" data-show="ผู้ใช้งาน">ผู้ใช้งาน</a></li>
                            <li><a href="<?= site_url('staff/ctl_page') ?>" data-show="พนักงาน">พนักงาน</a></li>
                            <li><a href="<?= site_url('page/ctl_page') ?>" data-show="Blank">Blank</a></li>
                        </ul>
                    </li>

                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->
    <script>
        document.getElementById('side-menu').getElementsByClassName('menu-title')[0].innerHTML = menuTitle
    </script>