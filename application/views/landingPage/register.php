<div class="app-container app-theme-white body-tabs-shadow">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 no-gutters row">
                <div class="h-100 d-md-flex d-sm-block bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                    <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-10">
                        <div class="app-logo"></div>
                        <h4>
                            <div>Welcome,</div>
                            <span>It only takes a <span class="text-success">few seconds</span> to create your account</span>
                        </h4>
                        <div>
                            <?php echo $this->session->flashdata('message'); ?>
                            <form id="formRegister" class="" action="<?php echo base_url('register') ?>" method="POST">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><span class="text-danger">*</span> First Name</label>
                                            <input name="first_name" id="first_name" placeholder="First Name here..." type="text" class="form-control" value="<?php echo $first_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="examplePassword" class=""> Middle Name</label>
                                            <input name="middle_name" id="middle_name" placeholder="Middle Name here..." type="text" class="form-control" value="<?php echo $middle_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="examplePasswordRep" class=""><span class="text-danger">*</span> Last Name</label>
                                            <input name="last_name" id="last_name" placeholder="Last Name here..." type="text" class="form-control" value="<?php echo $last_name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><span class="text-danger">*</span> Email</label>
                                            <input name="email" id="email" placeholder="Email here..." type="email" class="form-control" value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><span class="text-danger">*</span> Sex/Gender</label>
                                            <select name="gender" class="mb-2 form-control">
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><span class="text-danger">*</span> Batch Code</label>
                                            <input name="batchCode" id="batchCode" placeholder="Enter Batch Code here..." type="text" class="form-control"  value="<?php echo $batchCode; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="examplePassword" class=""><span class="text-danger">*</span> Password</label>
                                            <input name="password" id="password" placeholder="Password here..." type="password" class="form-control"  value="<?php echo $password; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="examplePasswordRep" class=""><span class="text-danger">*</span> Repeat Password</label>
                                            <input name="password_confirm" id="password_confirm" placeholder="Repeat Password here..." type="password" class="form-control" value="<?php echo $password_confirm; ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-4 d-flex align-items-center">
                                    <h5 class="mb-0">Already have an account? <a href="<?php echo base_url('login'); ?>" class="text-primary">Sign in</a></h5>
                                    <div class="ml-auto">
                                        <button type="submit" class="btn-wide mb-2 mr-2 btn btn-primary">Create Account </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="d-lg-flex d-xs-none col-lg-4">
                    <div class="slider-light">
                        <div class="slick-slider slick-initialized">
                            <div>
                                <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark"
                                    tabindex="-1">
                                    <div class="slide-img-bg"
                                        style="background-image: url('assets/images/originals/favicon.png');"></div>
                                    <div class="slider-content">
                                        <h3>Scalable, Modular, Consistent</h3>
                                        <p>Easily exclude the components you don't require. Lightweight, consistent
                                            Bootstrap based styles across all elements and components
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
