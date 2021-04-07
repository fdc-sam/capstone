<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="lnr-map text-info"></i>
                    </div>
                    <div>Chane Password
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
                            <form class="" action="<?php echo base_url('student/home/changePassword'); ?>" method="post">
                                <div class="card-body">
                                    <?php echo !empty($this->session->flashdata('message'))? $this->session->flashdata('message') : ''; ?>
                                    <div class="form-wizard-content">
                                        <div id="step-1">
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleName" class=""><span class="text-danger">*</span> Old Password</label>
                                                        <input name="old" id="old" placeholder="Old Password here..." type="password" class="form-control" value="<?php echo isset($old_password)? $old_password: ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail" class=""><span class="text-danger">*</span> New Password</label>
                                                        <input name="new" id="new" placeholder="New Password here..." type="password" class="form-control" value="<?php echo isset($new_password)? $new_password: ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                        <label for="exampleEmail" class=""><span class="text-danger">*</span> Confirm New Password</label>
                                                        <input name="new_confirm" id="new_confirm" placeholder="Confirm New Password here..." type="password" class="form-control" value="<?php echo isset($new_password_confirm)? $new_password_confirm: ''; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                        <button type="submit" id="btnUpdate" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                        <button type="button" id="btnCancel" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</button>
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