<!-- 
#
# Themem
#

color-1     = #034ea2
color-2     = #ffbf00

navbar      = #092640

logo      = #fff

title bar   = #1d3143

menu bar    = #061726

body        = #344955
-----------------------------
@param $bg-topbar-dark:             navbar

# custom/structure/_topbar.scss
.logo-box {color}:                  logo

# custom/structure/_page-head.scss
.page-title-box {background-color}: title bar

@param bg-leftbar-dark:             menu bar 
@param $menu-item-hover:            color-2;
@param $name$menu-item-active:      color-2;

@param  body-bg:                    body
-->

<!-- 
#
# Element
#

primary     = #034ea2

warning     = #ffa91c

success     = #32c861

danger      = #f84552

info        = #34d3eb

secondary   = #6c757d

light       = #f3f3f3

purple      = #5553ce
-->
<button class="btn btn-primary">button</button>
<button class="btn btn-warning">button</button>
<button class="btn btn-success">button</button>
<button class="btn btn-danger">button</button>
<button class="btn btn-info">button</button>
<button class="btn btn-secondary">button</button>
<button class="btn btn-light">button</button>
<button class="btn btn-purple">button</button>

<!-- 
#
# Status
#

color[primary]     = #034ea2 normal, add, view, etc

color[warning]     = #ffa91c notify, edit

color[success]     = #32c861 success, submit

color[danger]      = #f84552 delete, serious, height priority

color[secondary]   = #6c757d disable, low priority

color[light]       = #f3f3f3 additional
-->

<!-- 
#
# Loading
#
-->
<div class="sk-circle loading">
    <div class="sk-circle1 sk-child"></div>
    <div class="sk-circle2 sk-child"></div>
    <div class="sk-circle3 sk-child"></div>
    <div class="sk-circle4 sk-child"></div>
    <div class="sk-circle5 sk-child"></div>
    <div class="sk-circle6 sk-child"></div>
    <div class="sk-circle7 sk-child"></div>
    <div class="sk-circle8 sk-child"></div>
    <div class="sk-circle9 sk-child"></div>
    <div class="sk-circle10 sk-child"></div>
    <div class="sk-circle11 sk-child"></div>
    <div class="sk-circle12 sk-child"></div>
</div>

<!-- 
#
# Session
#
Array
(
    [__ci_last_regenerate] => 1683858794
    [user_code] => 12
    [user_emp] => 6
    [user_name] => Passakorn
    [level] => String(1) || null(non level)
    [depertment] => 
    [section] => 
    [role] => [rolename_1,rolename_2]
    [role_level] => 2
    [permit] => JWT endcode [
            API_TIME    => time begin session,
            permit      => [
                permitname_1 => [r,approve],
                permitname_2 => [c,r,u,d,approve,revise,comment],
            ],
        ]
)
 -->
<?php
$session = array(
    'user_code' => $staff_id,
    'user_emp' => $employee_id,
    'user_name' => $employee_name . " " . $employee_lastname,

    'level'         => $staff_level_id,
    'department'    => $employee_department,
    'department_id'    => $department_id,
    'section'       => $employee_section,
    'section_id'       => $section_id,

    'role' => $staff_role_name,
    'role_level' => $staff_role_level,
    'token' => $token,
);

// * check token
// $this->authorization_token->tokenIsExist();
?>

<?php
/**
 * 
 * * Permit
 * ** permit to event on page from table permit_control 
 * ** @session->userdata(permit)
 * ** @function check_login on mdl_login
 * Todo - นำ permit name มา คัดออกกับ permit ban
 * Todo - ส่งค่ากลับมาเป็น json มาเก็บไว้ที่ session->permit
 * 
 */
?>