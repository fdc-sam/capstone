
 <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo isset($currentPageTitle)? $currentPageTitle: 'Capstone'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="<?php echo base_url('assets/css/main.d810cf0ae7f39f28f336.css'); ?>  " rel="stylesheet">
    <link href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/responsive.dataTables.css'); ?>" rel="stylesheet">

    <style media="screen">
        .hrefProposal:hover {
            color: #3b5998;
            text-decoration:none;
        }
        .hrefDocument:hover {
            color: #787878;
            text-decoration:none;
        }
        .pdfobject-container {
            height: 50rem !important;
        }
    </style>
</head>

<body>
    <!-- Loding state -->
    <div id="loadingState">
    	<div class="blockUI" style="display:none"></div>
    	<div class="blockUI blockOverlay" style="display: none; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; position: fixed; z-index: 100000;"></div>
    	<div class="blockUI undefined blockPage" style="position: fixed; z-index: 100000;">
    		<div class="font-icon-wrapper float-left mr-3 mb-3" style="background:#f8f9fa;color:#3f6ad8">
    	        <div class="loader-wrapper d-flex justify-content-center align-items-center">
    	            <div class="">
    	                <div class="pacman">
    	                    <div></div>
    	                    <div></div>
    	                    <div></div>
    	                    <div></div>
    	                    <div></div>
    	                </div>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <!-- navbar -->
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-dots">


                    </div>

                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <i class="fa fa-bars ml-2 opacity-8" aria-hidden="true"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-2" style="background-image: <?php echo base_url('assets/images/dropdown-header/city3.jpg') ?> "></div>
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading"><?php echo $fullName; ?></div>
                                                                    <div class="widget-subheading opacity-8"><?php echo $userInfo->email; ?></div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">
                                                                    <a href="<?php echo base_url('logout'); ?>" class="btn-pill btn-shadow btn-shine btn btn-focus">Logout</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="scrollbar-container ps">
                                                <ul class="nav flex-column">

                                                    <li class="nav-item-header nav-item">Personal</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('student/home/myProfile'); ?>" class="nav-link">My Profile</a>
                                                    </li>

                                                    <li class="nav-item-header nav-item">My Account</li>

                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('student/home/changePassword'); ?>" class="nav-link">Change Password</a>
                                                    </li>

                                                    <li class="nav-item-header nav-item">Project</li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('student/home/myGroup'); ?>" class="nav-link">My Group</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="<?php echo base_url('student/home/myRole'); ?>" class="nav-link">My Role</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="header-btn-lg">
                    </div>
                </div>
            </div>
        </div>
        <!-- end navbar -->

        <!-- sidebar -->
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <li class="app-sidebar__heading">Project UI</li>
                            <li>
                                <a href="<?php echo base_url('student/home') ?>"
                                    class="<?php echo isset($subContent)
                                        && $subContent == 'home/index'
                                        || $subContent == 'home/capstoneDetails'
                                        || $subContent == 'home/viewDocumentPDF'  ? 'mm-active': '' ?> btn-sm" >
                                    <i class="metismenu-icon fa fa-braille"></i>
                                    <i class="metismenu-icon"></i>Home
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('student/panel'); ?>"
                                    class="<?php echo isset($subContent)
                                        && $subContent == 'panel/index'
                                        ? 'mm-active': '' ?>  btn-sm">
                                    <i class="metismenu-icon fa fa-users"></i>
                                    Panel
                                    <span class="badge badge-pill badge-primary">3</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url('student/capstone'); ?>"
                                    class="<?php echo isset($subContent)
                                        && $subContent == 'capstone/index'
                                        || $subContent == 'capstone/groupEvaluation'
                                        || $subContent == 'capstone/capstone1Remark'
                                        ? 'mm-active': '' ?>  btn-sm">
                                    <i class="metismenu-icon fa fa-ils" aria-hidden="true"></i>
                                    Capstone
                                    <!-- <span class="badge badge-pill badge-primary">3</span> -->
                                </a>
                            </li>

                            <li class="app-sidebar__heading">Student UI</li>
                            <li>
                                <li>
                                    <a href="charts-chartjs.html" >
                                        <i class="metismenu-icon fa fa-genderless"></i>Grades
                                    </a>
                                </li>
                            </li>

                            <li class="app-sidebar__heading">ADVISER UI</li>
                            <li>
                                <a href="<?php echo base_url('student/adviser'); ?>"
                                    class="<?php echo isset($subContent)
                                        && $subContent == 'adviser/index'
                                        || $subContent == 'adviser/viewLogs'
                                        ? 'mm-active': '' ?>  btn-sm"
                                    >
                                    <i class="metismenu-icon fa fa-user-secret"></i>Adviser
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end sidebar -->
