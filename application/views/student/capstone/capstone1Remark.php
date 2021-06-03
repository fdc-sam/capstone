<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('student/capstone'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Remarks
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="header-icon fa fa-user icon-gradient bg-plum-plate"> </i> <?php echo $fullName; ?>
                </div>
                <div class="card-body">
                    Panelist
                    <br>
                    <br>
                    <p>
                        <i class="header-icon fa fa-quote-left "> </i>
                        <?php echo isset($remark)? $remark: "No Remark Yet"; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
