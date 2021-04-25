<style>
    .kbw-signature { width: 100%; height: 200px;}
    #sig canvas{
        width: 100% !important;
        height: auto;
    }
</style>
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
                            <a>My Signature</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>       
        <!-- <?php if ($updateFlag): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                </button>
                Role Data Save
            </div>
        <?php endif; ?> -->
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="" id="message"></div>
                        <form class="" action="<?php echo base_url('student/home/mySignature'); ?>" method="post">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="exampleEmail" class=""><span class="text-danger">*</span> Signature</label>
                                        <div id="sig"></div>
                                        <textarea id="signature64" name="signed" hidden></textarea>
                                        <p style="clear: both;">
                                        	
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div class="clearfix">
                                <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                <button type="submit"  class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                <a href="<?php echo base_url('student/home/myProfile'); ?>" id="btnCancel" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                                <button class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary" id="clear">Clear</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>