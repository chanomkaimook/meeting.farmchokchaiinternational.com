<div class="topbar-menu">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <li class="has-submenu d-none">
                    <a href="<?=base_url('dashboard/ctl_dashboard/')?>"> <i
                            class="mdi mdi-tablet-dashboard"></i>Dashboard</a>
                </li>
                <li class="has-submenu">
                    <a href="<?=base_url('appointment/ctl_calendar/')?>"><i class="mdi mdi-calendar-month"></i> ปฏิทิน</a>
                </li>
                <li class="has-submenu">
                    <a href="<?=base_url('appointment/ctl_datatable/')?>"><i class="mdi mdi-table"></i> ตารางข้อมูล</a>
                </li>

                <li class="has-submenu d-none">
                    <a href="#">
                        <i class="mdi mdi-calendar-month"></i>การนัดหมาย
                    </a>
                    <ul class="submenu">
                        <li><a href="<?=base_url('appointment/ctl_calendar/')?>"> ปฏิทิน</a></li>
                        <li><a href="<?=base_url('appointment/ctl_datatable/')?>"> ตารางข้อมูล</a></li>
                    </ul>
                </li>

                <li class="has-submenu d-none">
                    <a href="#">
                        <i class="mdi mdi-google-classroom"></i>Admin</a>
                    <ul class="submenu">
                        <li class="has-submenu">
                            <a href="#">จัดการข้อมูลผู้ใช้งาน</a>
                            <ul class="submenu">
                                <li><a href="<?=base_url('admin/ctl_register/')?>">ลงทะเบียน</a></li>
                                <li><a href="<?=base_url('admin/ctl_user/')?>">ผู้ใช้งาน</a></li>
                            </ul>
                        </li>
                        <li class="d-none"><a href="<?=base_url('admin/ctl_permit/')?>">จัดการข้อมูลสิทธิ์</a></li>
                        <li class="has-submenu">
                            <a href="#">จัดการข้อมูลการนัดหมาย</a>
                            <ul class="submenu">
                                <li><a href="<?=base_url('admin/ctl_calendar/')?>"> ปฏิทิน</a></li>
                                <li><a href="<?=base_url('admin/ctl_datatable/')?>"> ตารางข้อมูล</a></li>
                            </ul>
                        </li>
                        <!-- 
                        <li><a href="icons-simple-line.html">Simple line Icons</a></li>
                        <li><a href="icons-flags.html">Flag Icons</a></li>
                        <li><a href="icons-file.html">File Icons</a></li>
                        <li><a href="icons-pe7.html">PE7 Icons</a></li>
                        <li><a href="icons-typicons.html">Typicons</a></li> -->
                    </ul>
                </li>

            </ul>
            <!-- End navigation menu -->

            <div class="clearfix"></div>
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>