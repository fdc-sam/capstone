<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:history.go(-1)">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Capstone <?php echo $capstoneFlag; ?> Evaluation
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="header-icon fa fa-user icon-gradient bg-plum-plate"> </i>
                    <?php
                        echo $panelDetails->first_name.' '.$panelDetails->middle_name.' '.$panelDetails->last_name;
                    ?>
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="table-groupEvaluation" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>UNACCEPTABLE</th>
                                <th>ACCEPTABLE</th>
                                <th>GOOD</th>
                                <th>SUPERIOR</th>
                                <th>COMMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // pre();
                            // die();
                             ?>
                            <?php $count=0; foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <?php if ($panelistIdEvaluationDetail['evaluationDetails']->category == "Personal Development"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="4"><b>Personal Development</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <?php if ($panelistIdEvaluationDetail['evaluationDetails']->category == "Written Paper"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="4"><b>Written Paper</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <?php if ($panelistIdEvaluationDetail['evaluationDetails']->category == "Oral Presentation"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="4"><b>Oral Presentation</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <?php if ($panelistIdEvaluationDetail['evaluationDetails']->category == "Design"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="4"><b>Design</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <?php if ($panelistIdEvaluationDetail['evaluationDetails']->category == null): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="4"><b>NO CATEGORY YET</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                        <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>UNACCEPTABLE</th>
                                <th>ACCEPTABLE</th>
                                <th>GOOD</th>
                                <th>SUPERIOR</th>
                                <th>COMMENT</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
