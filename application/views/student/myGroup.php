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
                            <a>Group</a>
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
                Group Data Updated
            </div>
        <?php endif; ?> 
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="" id="message"></div>
                        
                        <?php if ($groupDetails): ?>
                            <form class="" action="<?php echo base_url('student/home/myGroup'); ?>" method="post">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><span class="text-danger">* </span>Group Name</label>
                                            <input name="groupName" placeholder="Group Name Here..." type="text" class="form-control" value="<?php echo $groupDetails->thesis_group_name; ?>">
                                            <input name="id" placeholder="Group Name Here..." type="text" class="form-control" hidden value="<?php echo $groupDetails->id; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="divider"></div>
                                <div class="clearfix">
                                    <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                    <button type="submit" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                    <a href="<?php echo base_url('student/home'); ?>" id="btnCancel" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <h4 style="text-align: center;">No Group</h4>
                        <?php endif; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>