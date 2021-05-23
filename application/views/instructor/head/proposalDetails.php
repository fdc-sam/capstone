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
                            <a href="<?php echo base_url('instructor/head/proposal'); ?>">Proposal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Details</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <?php echo $this->layout->element('proposalDetails'); ?>
        </div>
    </div>
</div>
