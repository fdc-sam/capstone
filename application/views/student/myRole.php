<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('student/home'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>My Role</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>       
        <?php if ($updateFlag): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                </button>
                Role Data Save
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="" id="message"></div>
                        
                        <form class="" action="<?php echo base_url('student/home/myRole'); ?>" method="post">
                            
                            <div class="form-row">
                                <div class="col-md-4">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class=""><span class="text-danger">*</span> Sex/Gender</label>
                                        <select name="selectedRole" class="mb-2 form-control">
                                            <?php foreach ($roles as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>" <?php echo (isset($usersRoles->role_id) && $value->id == $usersRoles->role_id)? 'Selected': null; ?> >
                                                    <?php echo $value->role_name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="clearfix">
                                <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                <button type="submit"  class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                <a href="<?php echo base_url('student/home'); ?>" id="btnCancel" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>