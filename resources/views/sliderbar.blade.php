<div class="sidebar" data-active-color="mediumaquamarine" data-background-color="white" data-image="#">
    <div class="logo">
        <div class="photo1">
            <img class="img-responsive" src="{{ Session::get('logo') }}" style="height: 60px; margin: 0 auto;"/>
        </div>
        <a href="#" class="simple-text logo-normal" style="margin-top: 5px; text-align: center; padding: 0px 20px;">
            {{ Session::get('institutionName') }}
        </a>
    </div>

    <div class="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        <i class="material-icons">account_box</i>
                        <span style="color:#3c4858; margin-left: 5px; vertical-align: middle;">{{ Auth::user()->username}}</span>
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li style="padding-left:10px;padding-right:10px;">
                            <a href="{{ url('/change-password') }}">
                               <i class="material-icons">settings</i>
                                <span class="sidebar-normal"> Change Password </span>
                            </a>
                        </li>
                        <li style="padding-left:10px;padding-right:10px;">
                            <a href="{{ url('/profile') }}">
                               <i class="material-icons">settings</i>
                                <span class="sidebar-normal"> Profile </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
            <li>
                <a href="{{ url('/dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Session::get('role') == 'superadmin')
                <li>
                    <a href="{{ url('/menu-permission') }}">
                        <i class="material-icons">dashboard</i>
                        <p>Menu Permission</p>
                    </a>
                </li>
            @endif

            <li>
                <a href="{{ url('/grade') }}">
                    <i class="material-icons">assessment</i>
                    <p>Grade</p>
                </a>
            </li>
            <!--<li>
                <a href="{{ url('calender') }}">
                    <i class="material-icons">dashboard</i>
                    <p>Calender</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#visitor">
                    <i class="material-icons">dashboard</i>
                    <p>Visitor Management <b class="caret"></b></p>
                </a>
                <div class="collapse" id="visitor">
                    <ul class="nav">
                        <li class="" style="padding-left:20px;padding-right:20px;">
                            <a href="{{ url('visitor') }}">
                                <i class="material-icons">school</i>
                                <span class="sidebar-normal">Visitor</span>
                            </a>
                        </li>
                        <li class="" style="padding-left:20px;padding-right:20px;">
                            <a href="{{ url('visitor-report') }}">
                                <i class="material-icons">school</i>
                                <span class="sidebar-normal">Report</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('/leave-management') }}">
                    <i class="material-icons">face</i>
                    <p>leave Management</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/student-leave-report') }}">
                    <i class="material-icons">face</i>
                    <p>leave Report</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/batch') }}">
                    <i class="material-icons">face</i>
                    <p>Batch Creation</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/practical-attendance') }}">
                    <i class="material-icons">face</i>
                    <p>Practical Attendance</p>
                </a>
            </li> -->
            <!-- <li>
                <a href="{{ url('/grading-range') }}">
                    <i class="material-icons">assessment</i>
                    <p>Grading Range</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/subject-part') }}">
                    <i class="material-icons">face</i>
                    <p>Subject Part Creation</p>
                </a>
            </li>
            <li>
                <a href="{{ url('/exam-subject-configuration') }}">
                    <i class="material-icons">face</i>
                    <p>Exam Subject Configuration</p>
                </a>
            </li> -->
            <!-- <li>
                <a href="{{ url('/mark-card-setting') }}">
                    <i class="material-icons">face</i>
                    <p>Mark Card Setting</p>
                </a>
            </li> -->
            <!-- <li>
                <a href="{{ url('/staff-time-table') }}">
                    <i class="material-icons">assessment</i>
                    <p>Staff Time Table</p>
                </a>
            </li> -->
            <?php
                $sideMenu = Helper::showMenu();
                $menuItem = '';
                foreach($sideMenu as $key => $menu){
                    if(count($menu['subMenu']) > 0){
                        if(in_array($page, $menu['pages'])){
                            $in = "in";
                        }else{
                            $in = "";
                        }
                        $menuItem .= '<li>
                            <a data-toggle="collapse" href="#'.$menu['label'].'">
                                <i class="material-icons">'.$menu['icon'].'</i>
                                <p>'.$menu['name'].' <b class="caret"></b></p>
                            </a>
                            <div class="collapse '.$in.'" id="'.$menu['label'].'">
                                <ul class="nav">';
                                    foreach($menu['subMenu'] as $subMenu){
                                        $getPage = Helper::getSubModulePage($subMenu['id']);
                                        $activeResponse = '';
                                        if($getPage->page === $page){
                                            $activeResponse = 'active';
                                        }
                                        $menuItem .= '<li class="'.$activeResponse.'" style="padding-left:10px;padding-right:10px;">
                                            <a href="'.url($subMenu["url"]).'">
                                                <i class="material-icons">'.$subMenu['icon'].'</i>
                                                <span class="sidebar-normal">'.$subMenu["name"].'</span>
                                            </a>
                                        </li>';
                                    }
                                $menuItem .= '</ul>
                            </div>
                        </li>';
                    }else{
                        if(in_array($page, $menu['pages'])){
                            $activeResponse = "active";
                        }else{
                            $activeResponse = "";
                        }
                        $menuItem .= '<li class="'.$activeResponse.'">
                            <a href="'.url($menu['url']).'">
                                <i class="material-icons">'.$menu['icon'].'</i>
                                <p>'.$menu['name'].'</p>
                            </a>
                        </li>';
                    }
                }
                echo $menuItem;
            ?>
        </ul>
    </div>
</div>
