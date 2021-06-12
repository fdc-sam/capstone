<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/panel/capstone2') ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                Capstone 2 Final Remark
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
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon fa fa-fw mr-3 text-muted opacity-6"></i>

                        </div>
                    </div>
                    <form class="" action="<?php echo base_url('instructor/panel/capstone2Remark/'.$groupId) ?>" method="post">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="" class=""> <h5 class="card-title">Final Remark</h5></label>
                                        <textarea name="capstone1Remark" id="capstone1Remark" class="form-control"><?php echo isset($finalRemarks->remarks)? $finalRemarks->remarks: ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            <a href="<?php echo base_url('instructor/panel/capstone2') ?>" class="mr-2 btn btn-link btn-sm">Cancel</a>
                            <button class="btn-wide btn-shadow btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
