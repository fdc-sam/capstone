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
                            <a>Proposal</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>Proposals Details
                    <!-- <div class="btn-actions-pane-right actions-icon-btn">
                        <a href="<?php echo base_url('instructor/head/assignPanel'); ?>" class="mb-2 mr-2 btn-icon btn btn-primary btn-shadow">
                            <i class="lnr-users btn-icon-wrapper"> </i> Assign Panelist
                        </a>
                        <a href="<?php echo base_url('instructor/head/titleHearingDetails'); ?>" class="mb-2 mr-2 btn-icon btn btn-primary btn-shadow">
                            <i class="lnr lnr-file-empty btn-icon-wrapper"> </i> View Hearing
                        </a>
                    </div> -->

                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="getAllProposal" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Proposal</th>
                                <th>Panelist Status</th>
                                <th>Chairman</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Proposal</th>
                                <th>Panelist Status</th>
                                <th>Chairman</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
