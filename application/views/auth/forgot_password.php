<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Forgot Password - ArchitectUI HTML Bootstrap 4 Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="ArchitectUI HTML Bootstrap 4 Dashboard Template">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <link href="<?php echo base_url('assets/css/main.d810cf0ae7f39f28f336.css'); ?>  " rel="stylesheet">

<body>
    <div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-tempting-evsu" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url(<?php echo base_url('assets/images/originals/it_logo.png'); ?>);"></div>
                                        <!-- <div class="slider-content">
                                            <h3>Perfect Balance</h3>
                                            <p>ArchitectUI is like a dream. Some think it's too good to be true! Extensive
                                                collection of unified React Boostrap Components and Elements.
                                            </p>
                                        </div> -->
                                    </div>
                                </div>
                                <div>
                                    <div class="h-100 d-flex justify-content-center align-items-center bg-tempting-evsu"
                                        tabindex="-1">
                                        <div class="position-relative slide-img-bg" style="background-image: url(<?php echo base_url('assets/images/originals/it_logo.png'); ?>);"></div>
                                        <!-- <div class="slider-content">
                                            <h3>Scalable, Modular, Consistent</h3>
                                            <p>Easily exclude the components you don't require. Lightweight, consistent
                                                Bootstrap based styles across all elements and components
                                            </p>
                                        </div> -->
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-tempting-evsu" tabindex="-1">
                                        <div class="slide-img-bg opacity-6" style="background-image: url(<?php echo base_url('assets/images/originals/it_logo.png'); ?>);"></div>
                                        <!-- <div class="slider-content">
                                            <h3>Complex, but lightweight</h3>
                                            <p>We've included a lot of components that cover almost all use cases for any type of application.</p>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-8 col-lg-6">
                            <!-- <div class="app-logo">A Proposed Web-Based Capstone Project Management System</div> -->
                            <h3>
                                <div>A Proposed Web-Based Capstone Project Management System</div>
                            </h3>
                            <h4>
                                <div>Forgot your Password?</div>
                                <span>Use the form below to recover it.</span>
                            </h4>
                            <div>
                                <form class="" action="<?php echo base_url('recoverPassword'); ?>" method="POST">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <?php if (isset($message) && $message): ?>
                                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <?php echo $message;?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">Email</label>
                                                <input name="identity" id="identity"  placeholder="Email here..." type="email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex align-items-center">
                                        <h6 class="mb-0">
                                            <a href="<?php echo base_url('login'); ?>" class="text-primary">Sign in existing account</a>
                                        </h6>
                                        <div class="ml-auto">
                                            <button type="submit" class="btn btn-primary btn-lg">Recover Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</html>
<script src="<?php echo base_url('assets/scripts/jquery-3.6.0.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>
