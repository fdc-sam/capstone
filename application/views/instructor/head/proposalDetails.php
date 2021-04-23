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
                <?php echo $this->layout->element('demo'); ?>
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                            class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Easy Dynamic Tables
                    </div>
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="getAllProposal" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Group Name</th>
                                <th>Proposal</th>
                                <th>Group Member</th>
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
                                <th>Group Member</th>
                                <th>Created</th>
                                <th>Modified</th>
                                <th>Action</th
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>