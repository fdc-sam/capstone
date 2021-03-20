<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/apple-icon.png'); ?>">
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Intructor
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/material/iconfont/material-icons.css'); ?>" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="<?php echo base_url('assets/css/material-dashboard.min.css'); ?>" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
 
	<style type="text/css">
        /* Global CSS, you probably don't need that */

    .transition, p, .ul .li .i:before, .ul .li .i:after {
        transition: all 0.25s ease-in-out;
    }

    .flipIn, h1, .ul .li {
        animation: flipdown 0.5s ease both;
    }

    .no-select, h2 {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }


    @media (max-width: 550px) {
        body {
            box-sizing: border-box;
            transform: translate(0, 0);
            max-width: 100%;
            min-height: 100%;
            margin: 0;
            left: 0;
        } 
    }

    h1, h2 {
        color: #ff6873;
    }

    h1 {
        text-transform: uppercase;
        font-size: 36px;
        line-height: 42px;
        letter-spacing: 3px;
        font-weight: 100;
    }

    h2 {
        font-size: 26px;
        line-height: 34px;
        font-weight: 300;
        letter-spacing: 1px;
        display: block;
        background-color: #fefffa;
        margin: 0;
        cursor: pointer;
    }

    .p {
        color: rgba(48, 69, 92, 0.8);
        font-size: 17px;
        line-height: 26px;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
        max-height: 800px;
        opacity: 1;
        transform: translate(0, 0);
        margin-top: 14px;
        z-index: 2;
    }

    .ul {
      list-style: none;
      perspective: 900;
      padding: 0;
      margin: 0;
    }
    .ul .li {
        position: relative;
        padding: 0;
        margin: 0;
        padding-bottom: 4px;
        padding-top: 18px;
        border-top: 1px dotted #dce7eb;
    }
    .ul .li:nth-of-type(1) {
        animation-delay: 0.5s;
    }
    .ul .li:nth-of-type(2) {
        animation-delay: 0.75s;
    }
    .ul .li:nth-of-type(3) {
        animation-delay: 1s;
    }
    .ul .li:last-of-type {
        padding-bottom: 0;
    }
    .ul .li .i {
        position: absolute;
        transform: translate(-6px, 0);
        margin-top: 16px;
        right: 0;
    }
    .ul .li .i:before, .ul .li .i:after {
        content: "";
        position: absolute;
        background-color: #ff6873;
        width: 3px;
        height: 9px;
    }
    .ul .li .i:before {
        transform: translate(-2px, 0) rotate(45deg);
    }
    .ul .li .i:after {
        transform: translate(2px, 0) rotate(-45deg);
    }
    .ul .li input[type=checkbox] {
        position: absolute;
        cursor: pointer;
        width: 100%;
        height: 100%;
        z-index: 1;
        opacity: 0;
    }
    .ul li input[type=checkbox]:checked ~ p {
        margin-top: 0;
        max-height: 0;
        opacity: 0;
        transform: translate(0, 50%);
    }
    .ul .li input[type=checkbox]:checked ~ .i:before {
        transform: translate(2px, 0) rotate(45deg);
    }
    .ul .li input[type=checkbox]:checked ~ .i:after {
        transform: translate(-2px, 0) rotate(-45deg);
    }

    @keyframes flipdown {
        0% {
            opacity: 0;
            transform-origin: top center;
            transform: rotateX(-90deg);
        }
        5% {
            opacity: 1;
        }
        80% {
            transform: rotateX(8deg);
        }
        83% {
            transform: rotateX(6deg);
        }
        92% {
            transform: rotateX(-3deg);
        }
        100% {
            transform-origin: top center;
            transform: rotateX(0deg);
        }
    }

  </style>
</head>

<body class="">

  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="<?php echo base_url('assets/img/sidebar-1.jpg'); ?>">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
        <div class="logo">
            <a href="" class="simple-text logo-mini">
                S
            </a>
            <a href="" class="simple-text logo-normal">
                Student
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                    <img src="<?php echo base_url('assets/img/faces/avatar.jpg'); ?>" />
                </div>
                <div class="user-info">
                    <a data-toggle="collapse" href="#collapseExample" class="username">
                        <span>
                            <?php echo $userInfo->first_name." ".$userInfo->middle_name." ".$userInfo->last_name; ?>
                            <b class="caret"></b>
                        </span>
                    </a>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini"> MP </span>
                                    <span class="sidebar-normal"> My Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini"> EP </span>
                                    <span class="sidebar-normal"> Edit Profile </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="sidebar-mini"> S </span>
                                    <span class="sidebar-normal"> Settings </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item active ">
                    <a class="nav-link" href="">
                        <i class="material-icons">dashboard</i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                        <i class="material-icons">image</i>
                        <p> Pages
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="pagesExamples">
                        <ul class="nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="pages/pricing.html">
                                    <span class="sidebar-mini"> P </span>
                                    <span class="sidebar-normal"> Pricing </span>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="pages/rtl.html">
                                    <span class="sidebar-mini"> RS </span>
                                    <span class="sidebar-normal"> RTL Support </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="widgets.html">
                        <i class="material-icons">widgets</i>
                        <p> Widgets </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <a class="navbar-brand" href="#pablo">Dashboard</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
      <!-- End Navbar -->
