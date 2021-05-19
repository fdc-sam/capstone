<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/panel'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                View Project - Project Title Hearing
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
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>
                            Project Title Hearing
                        </div>
                        <?php if (isset($chairmanFlag) && $chairmanFlag): ?>
                            <div class="btn-actions-pane-right actions-icon-btn">
                                <a href="<?php echo base_url('instructor/panel/approvedProposal/'.$groupId) ?>" class="mb-2 mr-2 btn-icon btn btn-primary btn-shadow">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper btn-icon-wrapper"> </i>
                                    Approve This Title
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <ul class="tabs-animated-shadow tabs-animated nav">
                            <?php foreach ($groupMemersDetails as $key => $groupMemersDetail): ?>
                                <?php $fullName = $groupMemersDetail['first_name'].' '.$groupMemersDetail['middle_name'].' '.$groupMemersDetail['last_name'];  ?>
                                <li class="nav-item">
                                    <a role="tab"
                                        class="nav-link <?php echo ($key == 0)? 'active' : ''; ?>"
                                        id="tab-c-<?php echo $groupMemersDetail['id']; ?>"
                                        data-toggle="tab"
                                        href="#tab-animated-<?php echo $groupMemersDetail['id']; ?>"
                                        aria-selected="true"
                                    >
                                        <span><?php echo $fullName; ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="divider"></div>
                        <div class="tab-content">
                            <?php foreach ($groupMemersDetails as $key => $groupMemersDetail): ?>
                                <?php $fullName = $groupMemersDetail['first_name'].' '.$groupMemersDetail['middle_name'].' '.$groupMemersDetail['last_name'];  ?>

                                <div class="tab-pane <?php echo ($key == 0)? 'active' : ''; ?>" id="tab-animated-<?php echo $groupMemersDetail['id']; ?>" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">E-mail</label>
                                                <p><?php echo $groupMemersDetail['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">Gender / Sex</label>
                                                <?php if ($groupMemersDetail['gender'] == 1): ?>
                                                    <p>Male</p>
                                                <?php else: ?>
                                                    <p>Female</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">Role</label>
                                                <p><?php echo isset($groupMemersDetail['role_name'])? $groupMemersDetail['role_name']: 'No Role Assigned'; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="position-relative form-group">
                                                <label for="exampleEmail" class="">Role Discreption</label>
                                                <p><?php echo $groupMemersDetail['discreption'] ?> </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="divider"></div>

                        <?php if (isset($approvedProposalDetails)): ?>
                            <?php if ($approvedProposalDetails['approvedFlag'] == 1): ?>
                                <b>Project Title : </b><br>
                                <p><?php echo $approvedProposalDetails['approvedProposalDetails']->title ?></p>
                                <b>Project Discreption : </b><br>
                                <?php echo $approvedProposalDetails['approvedProposalDetails']->discreption ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <table style="width: 100%;" id="getProposalDetailDatatable" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
