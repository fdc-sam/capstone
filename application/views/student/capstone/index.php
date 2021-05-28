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
                            <?php foreach ($panelistDetails as $key => $panelistDetail): ?>
                                <tr>
                                    <td><?php echo $panelistDetail['panelistFullName'] ?></td>
                                    <td><?php echo $panelistDetail['panelistEmail'] ?></td>
                                    <td><?php echo $panelistDetail['gender'] ?></td>
                                    <td>
                                        <?php
                                            if($panelistDetail['capstoneDetails']->status == 0){
                                                echo '<div class="mb-2 mr-2 badge badge-warning">Pending / On Process</div>';
                                            }elseif ($panelistDetail['capstoneDetails']->status == 1) {
                                                echo '<div class="mb-2 mr-2 badge badge-success">Approved / Pass</div>';
                                            }elseif ($panelistDetail['capstoneDetails']->status == 2){
                                                echo '<div class="mb-2 mr-2 badge badge-danger">Redefence</div>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo base_url('student/capstone/groupEvaluation/'.$panelistDetail['capstoneDetails']->id) ?>"
                                            class="mb-2 mr-2 btn-icon btn-sm btn-shadow btn-outline-2x btn btn-outline-primary"
                                        >
                                            <i class="fa fa-eye btn-icon-wrapper"> </i>
                                            Evaluate
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
