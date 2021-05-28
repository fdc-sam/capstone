<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('student/capstone'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Capstone 1 Evaluation
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
                                <th>SCORE</th>
                                <th>COMMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($panelistIdEvaluationDetails as $key => $panelistIdEvaluationDetail): ?>
                                <tr>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->title; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->unacceptable; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->acceptable; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->good; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluationDetails']->superior; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_score']; ?></td>
                                    <td><?php echo $panelistIdEvaluationDetail['evaluation_rubric_comment']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>UNACCEPTABLE</th>
                                <th>ACCEPTABLE</th>
                                <th>GOOD</th>
                                <th>SUPERIOR</th>
                                <th>SCORE</th>
                                <th>COMMENT</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
