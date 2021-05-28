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
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>Capstone 1
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="table-capstone1" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>GROUP NAME</th>
                                <th>PROPOSE TITLE</th>
                                <th>STATUS</th>
                                <th>CREATED</th>
                                <th>ACTION</th>
                                <th class="none">GROUP MEMBERS</th>
                                <th class="none">PROPOSE DETAILS</th>
                                <th class="none">PANELIST</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($capstone1Details) && $capstone1Details): ?>
                                <?php foreach ($capstone1Details as $capstone1DetailsKey => $capstone1Detail): ?>


                                    <tr>
                                        <td><?php echo $capstone1Detail['groupDetailsObj']->thesis_group_name; ?></td>
                                        <td><?php echo $capstone1Detail['proposalDetailsObj']->title; ?></td>
                                        <td>
                                            <?php
                                                if($capstone1Detail['status'] == 0){
                                                    echo '<div class="mb-2 mr-2 badge badge-warning">Pending / On Process</div>';
                                                }elseif ($capstone1Detail['status'] == 1) {
                                                    echo '<div class="mb-2 mr-2 badge badge-success">Approved / Pass</div>';
                                                }elseif ($capstone1Detail['status'] == 2){
                                                    echo '<div class="mb-2 mr-2 badge badge-danger">Redefence</div>';
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $capstone1Detail['date_modified']; ?></td>
                                        <td>
                                            <a
                                                href="<?php echo base_url('instructor/panel/groupEvaluation/'.$capstone1Detail['groupDetailsObj']->id.'/'.$capstone1Detail['id']) ?>"
                                                class="mb-2 mr-2 btn-icon btn-sm btn-shadow btn-outline-2x btn btn-outline-primary"
                                            >
                                                <i class="fa fa-eye btn-icon-wrapper"> </i>
                                                Evaluate
                                            </a>
                                        </td>
                                        <td>
                                            <!-- GROUP MEMBERS -->
                                            <ul>
                                                <?php foreach ($capstone1Detail['groupMemberDetails'] as $groupMemberDetailsKey => $groupMemberDetail): ?>
                                                    <?php
                                                    $groupMemberFullName = $groupMemberDetail['first_name'].' '.$groupMemberDetail['middle_name'].' '.$groupMemberDetail['last_name'];
                                                    ?>
                                                    <li><?php echo $groupMemberFullName; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <!-- GROUP MEMBERS -->
                                            <ul>
                                                <li><?php echo $capstone1Detail['proposalDetailsObj']->discreption; ?></li>
                                                <li><?php echo $capstone1Detail['proposalDetailsObj']->limitations_of_the_studies; ?></li>
                                                <li><?php echo $capstone1Detail['proposalDetailsObj']->limitations_of_the_studies; ?></li>
                                            </ul>
                                        </td>

                                        <td>
                                            <!-- PANELIST -->
                                            <ul>
                                                <?php foreach ($capstone1Detail['allPanelistArr'] as $allPanelistArrKey => $panelistDetail): ?>
                                                    <?php
                                                    if ($currentuserId == $panelistDetail['panelist_id']) {
                                                        $groupMemberFullName = "YOU";
                                                        if ($panelistDetail['chairman_flag'] == 1) {
                                                            $groupMemberFullName = 'YOU | <div class="mb-2 mr-2 badge badge-primary">CHAIRMAN</div>';
                                                        }
                                                    }else{
                                                        $groupMemberFullName = $panelistDetail['panelistFullName'];
                                                        if ($panelistDetail['chairman_flag'] == 1) {
                                                            $groupMemberFullName = $panelistDetail['panelistFullName'].' | <div class="mb-2 mr-2 badge badge-primary">CHAIRMAN</div>';
                                                        }
                                                    }
                                                    ?>
                                                    <li>
                                                        <?php echo $groupMemberFullName; ?>
                                                        <small class="form-text text-muted">
                                                            - Evaluation score : <?php echo isset($panelistDetail['evaluationRubricScore'])? $panelistDetail['evaluationRubricScore']: null; ?>
                                                        </small>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>GROUP NAME</th>
                                <th>PROPOSE TITLE</th>
                                <th>STATUS</th>
                                <th>CREATED</th>
                                <th>ACTION</th>
                                <th>GROUP MEMBERS</th>
                                <th>PROPOSE DETAILS</th>
                                <th>PANELIST</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
