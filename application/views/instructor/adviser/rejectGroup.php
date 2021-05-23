<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/adviser'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                Reject
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <?php if (isset($message) && $message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                </button>
                <?php echo $message;?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
						<form id="form-addMoreProjectHearing" class=""
                            action="<?php echo base_url('instructor/adviser/rejectGroup/'.$thisesGroupAssignedAdviserId); ?>" method="post">
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">Reason</label>
										<textarea name="reasion" rows="1" class="form-control autosize-input" style="height: 77px;"></textarea>
									</div>
								</div>
							</div>
                            <div class="divider"></div>
                            <div class="clearfix">
                                <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                <button type="submit" id="updatePanelist" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Save</button>
                                <a href="<?php echo base_url('instructor/adviser'); ?>" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                            </div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
