<div class="app-container app-theme-white body-tabs-shadow">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 no-gutters row">
                <div class="d-none d-lg-block col-lg-4">
                    <div class="slider-light">
                        <div class="slick-slider">
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate" tabindex="-1">
                                    <div class="slide-img-bg" style="background-image: url('assets/images/originals/favicon.png');"></div>
                                    <div class="slider-content">
                                        <h3>Perfect Balance</h3>
                                        <p>ArchitectUI is like a dream. Some think it's too good to be true! Extensive
                                            collection of unified React Boostrap Components and Elements.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                    <div class="slide-img-bg" style="background-image: url('assets/images/originals/favicon.png');"></div>
                                    <div class="slider-content">
                                        <h3>Scalable, Modular, Consistent</h3>
                                        <p>Easily exclude the components you don't require. Lightweight, consistent
                                            Bootstrap based styles across all elements and components
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-sunny-morning" tabindex="-1">
                                    <div class="slide-img-bg" style="background-image: url('assets/images/originals/favicon.png');"></div>
                                    <div class="slider-content">
                                        <h3>Complex, but lightweight</h3>
                                        <p>We've included a lot of components that cover almost all use cases for any type of application.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                        <div class="app-logo"></div>
                        <h4 class="mb-0">
                            <span class="d-block">Welcome back,</span>
                            <span>Please sign in to your account.</span>
                        </h4>
                        <h6 class="mt-3">No account? <a href="<?php echo base_url('register'); ?>" class="text-primary">Sign up now</a></h6>
                        <div class="divider row"></div>
                        <div>
                            <?php if (isset($message) && $message): ?>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <?php echo $message;?>
                                </div>
                            <?php endif; ?>
                            <div class="alert alert-danger hidden" id="alertMessage">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="pe-7s-close"> </i>
                                </button>
                                <span id="infoMessage"></span>
                            </div>
                            <form class="" id="formLogin">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class="">Email</label>
                                            <input name="identity" id="identity" placeholder="User Name or Student ID" required type="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="examplePassword" class="">Password</label>
                                            <input name="password" id="password" placeholder="Password" required type="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="divider row"></div>
                                <div class="d-flex align-items-center">
                                    <div class="ml-auto">
                                        <a href="<?php echo base_url('recoverPassword'); ?>" class="btn-lg btn btn-link">Recover Password</a>
                                        <button class="btn btn-primary btn-lg block-page-btn-example-2">Login to Dashboard</button>
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
