
 <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo isset($currentPageTitle)? $currentPageTitle: 'Capstone'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <meta name="description" content="A Proposed Web-Based Capstone Project Management System">


    <!-- FB and twitter -->
    <meta property="og:title" content="Capstone Project">
    <meta property="og:description" content="A Proposed Web-Based Capstone Project Management System">
    <meta property="og:image" content="<?php echo base_url('assets/images/originals/it_logo.png'); ?>">
    <meta property="og:url" content="<?php echo base_url('login'); ?>">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">
    
    <link rel="shortcut icon" href="<?php echo base_url('assets/images/originals/it_logo.ico') ?>" />
    <link href="<?php echo base_url('assets/css/main.d810cf0ae7f39f28f336.css'); ?>  " rel="stylesheet">
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
