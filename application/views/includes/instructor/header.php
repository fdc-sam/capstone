
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
    <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
    <style media="screen">
        .notification:hover {
            color: #3b5998;
            text-decoration:none;
        }
        .timeline-title{
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .description {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body>
    <!-- Loding state -->
    <div id="loadingState">
    	<div class="blockUI" style="display:none"></div>
    	<div class="blockUI blockOverlay" style="display: none; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; position: fixed;"></div>
    	<div class="blockUI undefined blockPage" style="position: fixed;">
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
                        
                        <div class="dropdown">
                            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                                class="p-0 mr-2 btn btn-link">
                                <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                    <span class="icon-wrapper-bg bg-danger"></span>
                                    <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                                    <span class="badge badge-dot badge-dot-sm badge-danger">Notifications</span>
                                </span>
                            </button>
                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                <div class="dropdown-menu-header mb-0">
                                    <div class="dropdown-menu-header-inner bg-deep-blue">
                                        <div class="menu-header-image opacity-1" style="background-image: <?php echo base_url('assets/images/dropdown-header/city3.jpg') ?>"></div>
                                        <div class="menu-header-content text-dark">
                                            <h5 class="menu-header-title">Notifications</h5>
                                            <h6 class="menu-header-subtitle">You have <b id="getCountUnread">21</b> unread messages</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-events-header" role="tabpanel">
                                        <div class="scroll-area-sm">
                                            <div class="scrollbar-container">
                                                <div class="p-3">
                                                    <div class="vertical-without-time vertical-timeline vertical-timeline--animate vertical-timeline--one-column" id="getNotifications">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav flex-column">
                                    <li class="nav-item-divider nav-item"></li>
                                    <li class="nav-item-btn text-center nav-item">
                                        <button class="btn-shadow btn-wide btn-pill btn btn-focus btn-sm">View Latest Changes</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
                                                                <!-- <div class="widget-content-left mr-3">
                                                                    <img width="42" class="rounded-circle" src="<?php echo base_url('assets/images/avatars/1.jpg') ?>" alt="">
                                                                </div> -->
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
                                            <div class="scroll-area-xs" style="height: 150px;">
                                                <div class="scrollbar-container ps">
                                                    <ul class="nav flex-column">
                                                        <li class="nav-item-header nav-item">Activity</li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Chat
                                                                <div class="ml-auto badge badge-pill badge-info">8</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Recover Password</a>
                                                        </li>
                                                        <li class="nav-item-header nav-item">My Account
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Settings
                                                                <div class="ml-auto badge badge-success">New</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Messages
                                                                <div class="ml-auto badge badge-warning">512</div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="javascript:void(0);" class="nav-link">Logs</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider mb-0 nav-item"></li>
                                            </ul>
                                            <div class="grid-menu grid-menu-2col">
                                                <div class="no-gutters row">
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">
                                                            <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i> Message Inbox
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                                                            <i class="pe-7s-ticket icon-gradient bg-love-kiss btn-icon-wrapper mb-2"></i>
                                                            <b>Support Tickets</b>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nav flex-column">
                                                <li class="nav-item-divider nav-item">
                                                </li>
                                                <li class="nav-item-btn text-center nav-item">
                                                    <button class="btn-wide btn btn-primary btn-sm"> Open Messages </button>
                                                </li>
                                            </ul>
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
                            <?php if (isset($mainContent) && $mainContent == 'instructor/head'): ?>
                                <li class="app-sidebar__heading">Head UI</li>
                                <li  class="<?php echo isset($mainContent) && $mainContent == 'instructor/head' ? 'mm-active': '' ?>">
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-rocket"></i>Dashboards
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="<?php echo base_url('instructor/head') ?>"  class="<?php echo isset($subContent) && $subContent == 'head/index' ? 'mm-active': '' ?> " >
                                                <i class="metismenu-icon"></i>Panelist
                                            </a>
                                        </li>
                                        <li>
                                            <a 
                                                href="<?php echo base_url('instructor/head/batch') ?>" 
                                                class="<?php echo isset($subContent) && $subContent == 'head/batch' || $subContent == 'head/viewStudent' ? 'mm-active': '' ?> "
                                            >
                                                <i class="metismenu-icon"></i>Batch
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('instructor/head/proposal') ?>" class="<?php echo isset($subContent) && $subContent == 'head/proposal' || $subContent == 'head/teamProposal' ? 'mm-active': '' ?> ">
                                                <i class="metismenu-icon">
                                                </i>Proposal
                                            </a>
                                        </li>
                                        <li>
                                            <a href="dashboards-crm.html" >
                                                <i class="metismenu-icon"></i> CRM
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li class="app-sidebar__heading">Panel UI</li>
                            <li>
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-car"></i> Components
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a href="components-tabs.html" >
                                            <i class="metismenu-icon"></i>Tabs
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="app-sidebar__heading">ADVISER UI</li>
                            <li>
                                <a href="#">
                                    <i class="metismenu-icon pe-7s-light"></i> Elements
                                    <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                </a>
                                <ul>
                                    <li>
                                        <a href="forms-controls.html" >
                                            <i class="metismenu-icon"></i>Controls
                                        </a>
                                    </li>
                                    <li>
                                        <a href="forms-layouts.html" >
                                            <i class="metismenu-icon"></i>Layouts
                                        </a>
                                    </li>
                                    <li>
                                        <a href="forms-validation.html" >
                                            <i class="metismenu-icon"></i>Validation
                                        </a>
                                    </li>
                                    <li>
                                        <a href="forms-wizard.html" >
                                            <i class="metismenu-icon"></i>Wizard
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="charts-chartjs.html" >
                                    <i class="metismenu-icon pe-7s-graph2"></i>ChartJS
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end sidebar -->
        