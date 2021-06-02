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
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>View Evaluation Rubric
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
                    <table style="width: 100%;" id="table-viewEvaluationRubric" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>TITLE</th>
                                <th>UNACCEPTABLE</th>
                                <th>ACCEPTABLE</th>
                                <th>GOOD</th>
                                <th>SUPERIOR</th>
                                <th>CREATED</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluationRubricDetailsArr as $key => $evaluationRubricDetail): ?>
                                <tr>
                                    <td><?php echo $evaluationRubricDetail['title']; ?></td>
                                    <td><?php echo $evaluationRubricDetail['unacceptable']; ?></td>
                                    <td><?php echo $evaluationRubricDetail['acceptable']; ?></td>
                                    <td><?php echo $evaluationRubricDetail['good']; ?></td>
                                    <td><?php echo $evaluationRubricDetail['superior']; ?></td>
                                    <td><?php echo $evaluationRubricDetail['date_modified']; ?></td>
                                    <td>
                                        <a
                                            href="<?php echo base_url('instructor/head/createEvaluationRubric/'.$evaluationRubricDetail['id']); ?>"
                                            class="mb-2 mr-2 btn-icon btn-shadow btn-outline-2x btn btn-sm btn-outline-primary"
                                        >
                                            <i class="fa fa-edit btn-icon-wrapper"> </i>Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TITLE</th>
                                <th>UNACCEPTABLE</th>
                                <th>ACCEPTABLE</th>
                                <th>GOOD</th>
                                <th>SUPERIOR</th>
                                <th>CREATED</th>
                                <th>ACTION</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
