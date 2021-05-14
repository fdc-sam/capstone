<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/head'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/head'); ?>">
                                Proposal
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:history.back()">
                                Team Proposal
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
                        <div class="form-row">
							<div class="col-md-12">
								<div class="position-relative form-group">
									<h5 for="" class="">Reason</h5>

                                    <div class="col-md-12" >
                                        <b for="" class="float-right">
                                            <?php
                                            if (isset($hearingDetails->date_modified) && $hearingDetails->date_modified) {
                                                echo date('F j, Y', strtotime($hearingDetails->date_modified)); //June, 2017
                                            }
                                            ?>
                                        </b>
                                        <br>
                                        <p style="background-color:#E5E4E2; padding: 5px;"><?php echo isset($hearingDetails->reject_ression)? $hearingDetails->reject_ression: ""; ?></p>
                                    </div>

								</div>
							</div>
						</div>
                        <div class="divider"></div>
                        <div class="clearfix">
                            <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                            <a href="<?php echo base_url('instructor/head/removePanelist/'.$hearingId); ?>" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-danger">Remove</a>
                            <a href="javascript:history.back()" class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
