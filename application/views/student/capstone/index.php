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
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a  role="tab" 
                    class="nav-link <?php echo isset($capstoneFlag) && $capstoneFlag == 1? 'active': null; ?> " 
                    href="<?php echo base_url('student/capstone'); ?>"
                >
                    <span>Capstone 1</span>
                </a>
            </li>
            <li class="nav-item">
                <a  role="tab" 
                    class="nav-link <?php echo isset($capstoneFlag) && $capstoneFlag == 2? 'active': null; ?> " 
                    href="<?php echo base_url('student/capstone?capstoneFlag=2'); ?>"
                >
                    <span>Capstone 2</span>
                </a>
            </li>
        </ul>
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="header-icon fa fa-users icon-gradient bg-plum-plate"> </i> Panelist
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="table-panelist" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>E-MAIL</th>
                                <th>GENDER</th>
                                <th>CAPSTONE 1 STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($panelistDetails) && $panelistDetails): ?>
                                <?php foreach ($panelistDetails as $key => $panelistDetail): ?>
                                    <tr>
                                        <td><?php echo $panelistDetail['panelistFullName'] ?></td>
                                        <td><?php echo $panelistDetail['panelistEmail'] ?></td>
                                        <td><?php echo $panelistDetail['gender'] ?></td>
                                        <td>
                                            <?php
                                            if (isset($panelistDetail['capstoneDetails']) && $panelistDetail['capstoneDetails']) {
                                                if($panelistDetail['capstoneDetails']->status == 0){
                                                    echo '<div class="mb-2 mr-2 badge badge-warning">Pending / On Process</div>';
                                                }elseif ($panelistDetail['capstoneDetails']->status == 1) {
                                                    echo '<div class="mb-2 mr-2 badge badge-success">Approved / Pass</div>';
                                                }elseif ($panelistDetail['capstoneDetails']->status == 2){
                                                    echo '<div class="mb-2 mr-2 badge badge-danger">Redefence</div>';
                                                }
                                            }else{
                                                echo '<div class="mb-2 mr-2 badge badge-warning">Pending / On Process</div>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (isset($panelistDetail['capstoneDetails']->id) && $panelistDetail['capstoneDetails']->id): ?>
                                                <a
                                                    href="<?php echo base_url('student/capstone/groupEvaluation/'.$panelistDetail['capstoneDetails']->id).'/'.$capstoneFlag ?>"
                                                    class="mb-2 mr-2 btn-icon btn-sm btn-shadow btn-outline-2x btn btn-outline-primary"
                                                >
                                                    <i class="fa fa-eye btn-icon-wrapper"> </i>
                                                    Evaluate
                                                </a>
                                                <a
                                                    href="<?php echo base_url('student/capstone/capstone'.$capstoneFlag.'Remark/'.$panelistDetail['capstoneDetails']->panelist_id) ?>"
                                                    class="mb-2 mr-2 btn-icon btn-sm btn-shadow btn-outline-2x btn btn-outline-primary"
                                                >
                                                    <i class="fa fa-eye btn-icon-wrapper"> </i>
                                                    View Remark
                                                </a>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NAME</th>
                                <th>E-MAIL</th>
                                <th>GENDER</th>
                                <th>CAPSTONE 1 STATUS</th>
                                <th>ACTION</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
