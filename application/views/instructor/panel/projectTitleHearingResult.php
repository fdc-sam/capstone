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
        <div class="" id="alertMessege"></div>
        <div class="tabs-animation">

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>
                                Project Title Hearing Result
                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;" id="projectTitleHearing" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO. </th>
                                        <th>Group Name</th>
                                        <th>ASSIGNED ADVISER</th>
                                        <th>ADVISER REQUEST STATUS </th>
                                        <th>PROPOSAL TITLE </th>
                                        <th>REMARK </th>
                                        <th class="none">Group Members</th>
                                        <th class="none">Discreption</th>
                                        <th class="none">Limitations Of The Studies </th>
                                        <th class="none">Design Development Plans</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($approvedProposals as $key => $approvedProposal): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('instructor/panel/groupDetails/'.$approvedProposal['thesis_group_id']); ?>">
                                                    <?php echo $approvedProposal['groupName']; ?>
                                                </a>
                                            </td>
                                            <td><?php echo $approvedProposal['adviser']; ?></td>
                                            <td>

                                                <?php
                                                    if ($approvedProposal['adviserRequestStatus'] == 0) {
                                                        ?><div class="mb-2 mr-2 badge badge-warning">Pending</div><?php
                                                    }elseif ($approvedProposal['adviserRequestStatus'] == 1) {
                                                        ?><div class="mb-2 mr-2 badge badge-success">Accepted</div><?php
                                                    }elseif ($approvedProposal['adviserRequestStatus'] == 2) {
                                                        ?><div class="mb-2 mr-2 badge badge-danger">Reject</div><?php
                                                    }else {
                                                        ?><div class="mb-2 mr-2 badge badge-warning">Adviser Required</div><?php
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $approvedProposal['title']; ?> </td>
                                            <td>
                                                <?php if (isset($approvedProposal['chairmanFullname']) && $approvedProposal['chairmanFullname']): ?>
                                                    Approved by their chairman : <u><b><?php echo $approvedProposal['chairmanFullname']; ?> </b> </u>
                                                <?php endif; ?>

                                            </td>
                                            <td><br>
                                                <ul>
                                                <?php foreach ($approvedProposal['groupMemberFullname'] as $groupMemberFullnameKey => $fullname): ?>
                                                    <li><?php echo $fullname; ?> <br></li>
                                                <?php endforeach; ?>
                                                </ul>
                                            </td>
                                            <td><?php echo $approvedProposal['discreption']; ?> </td>
                                            <td><?php echo $approvedProposal['limitations_of_the_studies']; ?> </td>
                                            <td><?php echo $approvedProposal['design_development_plans']; ?> </td>
                                            <td>
                                                <?php if ($currentUserGroup == 'IT head'): ?>
                                                    <a  href="<?php echo base_url('instructor/panel/assignAdviser/'.$approvedProposal['thesis_group_id'].'/'.$approvedProposal['id']); ?>"
                                                        class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                                        data-toggle="tooltip" data-placement="top" title="Assign Adviser"
                                                    >
                                                        <i class="fa fa-fw" aria-hidden="true"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>NO. </th>
                                        <th>Group Name</th>
                                        <th>ASSIGNED ADVISER</th>
                                        <th>ADVISER REQUEST STATUS </th>
                                        <th>PROPOSAL TITLE </th>
                                        <th>REMARK </th>
                                        <th>Group Members</th>
                                        <th>Discreption</th>
                                        <th>Limitations Of The Studies </th>
                                        <th>Design Development Plans</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
