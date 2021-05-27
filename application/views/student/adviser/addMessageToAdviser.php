<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('student/adviser'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            <a>
                                Comment
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <?php if (isset($_SESSION['message']) && $this->session->flashdata('message')): ?>
            <div class="alert  alert-dismissible fade show <?php echo isset($_SESSION['message']['class'])? $_SESSION['message']['class']: ""; ?>" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                </button>
                <?php
                    echo isset($_SESSION['message']['message'])? $_SESSION['message']['message']: "";
                    // pre($_SESSION['message']);
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
						<form id="form-addMoreProjectHearing" class=""
                            action="<?php echo base_url('student/adviser/addMessageToAdviser/'.$groupId); ?>" method="post">
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class="">Comment</label>
										<textarea name="remark" rows="1" class="form-control autosize-input" style="height: 77px;"></textarea>
									</div>
								</div>
							</div>
                            <div class="divider"></div>
                            <div class="clearfix">
                                <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                <button type="submit" id="updatePanelist" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Save</button>
                                <a href="<?php echo base_url('student/adviser'); ?>" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                            </div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
