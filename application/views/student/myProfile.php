<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="lnr-map text-info"></i>
                    </div>
                    <div>My Profile
                        <div class="page-title-subheading">You can Update you personal information here</div>
                    </div>
                </div>
            </div>
        </div>        
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="" id="message"></div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><span class="text-danger">*</span> First Name</label>
                                            <input name="first_name" id="firstName" placeholder="First Name here..." type="text" class="form-control" value="<?php echo $userInfo->first_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="examplePassword" class=""> Middle Name</label>
                                            <input name="middle_name" id="middleName" placeholder="Middle Name here..." type="text" class="form-control" value="<?php echo $userInfo->middle_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="examplePasswordRep" class=""><span class="text-danger">*</span> Last Name</label>
                                            <input name="last_name" id="lastName" placeholder="Last Name here..." type="text" class="form-control" value="<?php echo $userInfo->last_name; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><span class="text-danger">*</span> Email</label>
                                            <input name="email" id="email" placeholder="Email here..." type="email" class="form-control" value="<?php echo $userInfo->email; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><span class="text-danger">*</span> Sex/Gender</label>
                                            <select name="gender" id="gender" class="mb-2 form-control">
                                                <option value="1" <?php echo (isset($userInfo->gender) && $userInfo->gender == 1)? 'Selected': null; ?> >Male</option>
                                                <option value="2" <?php echo (isset($userInfo->gender) && $userInfo->gender == 2)? 'Selected': null; ?>>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="clearfix">
                                    <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                    <button type="button" id="btnUpdate" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                    <button type="button" id="btnCancel" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>