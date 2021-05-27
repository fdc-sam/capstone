<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a>
                                <i aria-hidden="true" class="fa fa-home"></i>
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
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                                class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Assigned
                        </div>
                    </div>
                    <div class="card-body">
                        <table style="width: 100%;" id="table-advisory" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NO. </th>
                                    <th>GROUP NAME</th>
                                    <th>STATUS</th>
                                    <th>DATE ASSIGNED</th>
                                    <th>DOCUMENT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignedGroups as $assignedGroupKey => $assignedGroup): ?>
                                    <td><?php echo $assignedGroupKey + 1; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('instructor/panel/groupDetails/'.$assignedGroup['group_id']); ?>">
                                            <?php echo $assignedGroup['groupName']; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $assignedGroup['statusFlag']; ?></td>
                                    <td><?php echo $assignedGroup['date_modified']; ?></td>

                                    <td>
                                        <?php if (isset($assignedGroup['thesisDocuments']->id) && $assignedGroup['thesisDocuments']->id): ?>
                                            <a  href="<?php echo base_url('instructor/adviser/viewDocumentPDF/'.$assignedGroup['thesisDocuments']->id.'/'.$assignedGroup['thesisDocuments']->group_id.'/'.$assignedGroup['thesisDocuments']->file_name); ?>"
                                                class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-info"
                                                data-toggle="tooltip" data-placement="top" title="Reject Assigned Group"
                                            >
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                View Files
                                            </a>
                                            <a  href="<?php echo base_url('instructor/adviser/viewLogs/'.$assignedGroup['thesisDocuments']->group_id); ?>"
                                                class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-alternate"
                                            >
                                                <i class="fa fa-list" aria-hidden="true"></i>
                                                View Logs
                                            </a>
                                        <?php else: ?>
                                            No Document
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>NO. </th>
                                    <th>GROUP NAME</th>
                                    <th>STATUS</th>
                                    <th>DATE ASSIGNED</th>
                                    <th>DOCUMENT</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
