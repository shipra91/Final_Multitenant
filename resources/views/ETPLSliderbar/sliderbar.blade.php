

    <div class="sidebar" data-active-color="mediumaquamarine" data-background-color="white" data-image="#">
        <div class="logo">
            <div class="photo1" style="margin-top:7;">
                <img src=""/>
            </div>
            <a href="#" class="simple-text logo-normal" style="margin-top:3px;">
                {{Session::get('fullname')}}
            </a>
        </div>

        <div class="sidebar-wrapper">
            <div class="user">
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                        <span>
                            {{Session::get('role')}}
                            <b class="caret"></b>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li style="padding-left:20px;padding-right:20px;">
                                <a href="profile.php">
                                   <i class="material-icons">settings</i>
                                    <span class="sidebar-normal"> Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul class="nav">

                <li>
                    <a href="">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>

                <?php

                if(Session::get('role') == 'developer'){
                ?>
                    <li>
                        <a href="{{url('/etpl/module/create')}}">
                            <i class="material-icons">local_library</i>
                            <span class="sidebar-normal">Module</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/module-permission')}}">
                            <i class="material-icons">dashboard</i>
                            <p> Service Menu Permission </p>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/payment-gateway')}}">
                            <i class="material-icons">account_balance_wallet</i>
                            <p> Payment Gateway</p>
                        </a>
                    </li>
                <?php
                }else{

                    // $sideMenu = showMenu();
                    // print_r($sideMenu);
                    // exit;
                    // $menuItem = '';
                    // foreach ($sideMenu as $key => $value) {
                    //     //print_r($value['sub_menu']);
                    //     if ($value['sub_menu']) {
                    //         foreach ($value['sub_menu'] as $menu) {

                    //             if(count($menu['sub_menu']) > 0){

                    //                 $menuItem .= '<li>
                    //                             <a class="has-arrow" href="' . ($menu['file_path'] ? url($menu['file_path']) : 'javascript:void(0)') . '" aria-expanded="false">
                    //                                 <i class="'.$value['icon'].'"></i>
                    //                                 <span class="hide-menu">'.$menu['display_name'].'</span>
                    //                             </a>';
                    //                 $menuItem .= '<ul aria-expanded="false" class="collapse">';

                    //                     foreach ($menu['sub_menu'] as $subMenu) {

                    //                         $menuItem .= '<li>
                    //                                     <a href="' . ($subMenu['file_path'] ? url($subMenu['file_path']) : 'javascript:void(0)') . '">'.$subMenu['display_name'].'</a>
                    //                                 </li>';

                    //                         //print_r($subMenu['display_name']);
                    //                     }

                    //                 $menuItem .= '</ul>';
                    //                 $menuItem .= '</li>';
                    //             }else{
                    //                 $menuItem .= '<li>
                    //                                 <a href="' . ($menu['file_path'] ? url($menu['file_path']) : 'javascript:void(0)') . '" aria-expanded="false">
                    //                                     <i class="bx bx-home-circle"></i>
                    //                                     <span class="hide-menu">'.$menu['display_name'].'</span>
                    //                                 </a>
                    //                             </li>';
                    //             }

                    //         }
                    //     }
                    // }
                    // echo $menuItem;
                ?>

                    <li class="{{ (Request()->route()->getPrefix() == '/etpl/organization') ? 'active' : '' }}">
                        <a href="{{url('/etpl/organization')}}">
                            <i class="material-icons">school</i>
                            <p> Organization/Trust </p>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/institution')}}">
                            <i class="material-icons">school</i>
                            <p> Institution</p>
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{url('/etpl/academic-year-mapping')}}">
                            <i class="material-icons">dashboard</i>
                            <span class="sidebar-normal">Institution Academic Mapping</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/institution-fee-type-mapping')}}">
                            <i class="material-icons">dashboard</i>
                            <span class="sidebar-normal">Institution Fee Type Mapping</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/create-user')}}">
                            <i class="material-icons">school</i>
                            <p> Create Superadmin</p>
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/etpl/dynamic-template')}}">
                            <i class="material-icons">local_library</i>
                            <span class="sidebar-normal">Dynamic Templates </span>
                        </a>
                    </li>

                    <li>
                        <a data-toggle="collapse" href="#template_setting">
                            <i class="material-icons">school</i>
                            <p> Template Settings<b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="template_setting">
                            <ul class="nav">
                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/sms-template')}}">
                                        <i class="material-icons">local_library</i>
                                        <span class="sidebar-normal">SMS Template Setting</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/email-template')}}">
                                        <i class="material-icons">local_library</i>
                                        <span class="sidebar-normal">Email Template Setting</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a data-toggle="collapse" href="#configuration">
                            <i class="material-icons">dashboard</i>
                            <p> Configurations <b class="caret"></b></p>
                        </a>
                        <div class="collapse" id="configuration">
                            <ul class="nav">
                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/role')}}">
                                        <i class="material-icons">dashboard</i>
                                        <span class="sidebar-normal">Role</span>
                                    </a>
                                </li>
                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/academic-year')}}">
                                        <i class="material-icons">dashboard</i>
                                        <span class="sidebar-normal">Academic Year</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/standard')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Standard</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/caste-category')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Caste Category</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/designation')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Designation</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/staff-sub-category')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Staff Subcategory</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/division')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Division</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/course-master')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Course Master</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/standard-year')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Standard Year</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/subject')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Subject</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/blood-group')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Blood Group</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/religion')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Religion</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/nationality')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Nationality</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/department')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Department</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/fee-type')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Fee Type</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/fee-category')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Fee Category</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/fee-heading')}}">
                                        <i class="material-icons">school</i>
                                        <span class="sidebar-normal">Fee Heading</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/admission-type')}}">
                                        <i class="material-icons">dashboard</i>
                                        <span class="sidebar-normal">Admission Type</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/message-credit-details')}}">
                                        <i class="material-icons">dashboard</i>
                                        <span class="sidebar-normal">Message Credit Details</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/message-sender-entity')}}">
                                        <i class="material-icons">dashboard</i>
                                        <span class="sidebar-normal">Sender & Entity Id Details</span>
                                    </a>
                                </li>

                                <li style="padding-left:20px;padding-right:20px;">
                                    <a href="{{url('/etpl/document-header')}}">
                                        <i class="material-icons">description</i>
                                        <span class="sidebar-normal">Document Header</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>


