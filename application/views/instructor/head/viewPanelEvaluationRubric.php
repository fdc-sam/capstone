<div class="app-main__outer">
    <div class="app-main__inner">
    <div class="page-title-heading">
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
                            <a href="<?php echo base_url('instructor/head/proposal'); ?>">Proposal</a>
                        </li>
                        <li class="active breadcrumb-item" aria-current="page">
                            <a href="<?php echo base_url('instructor/head/teamProposal/'.$groupId); ?>">Team Proposal</a>
                        </li>
                        <li class="breadcrumb-item">
                            Panel Evaluation
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                            class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i> <?php echo $panelistFullName ?>
                    </div>
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="table-viewPanelEvaluationRubric" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>1 = UNACCEPTABLE</th>
                                <th>2 = ACCEPTABLE</th>
                                <th>3 = GOOD</th>
                                <th>4 = SUPERIOR</th>
                                <th>SCORE</th>
                                <th>COMMENT</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $count=0; foreach ($evaluationRubricDetailsArr as $key => $value): ?>
                                <?php if ($value['category'] == "Personal Development"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7"><b>Personal Development</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>

                                    <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['unacceptable']; ?></td>
                                        <td><?php echo $value['acceptable']; ?></td>
                                        <td><?php echo $value['good']; ?></td>
                                        <td><?php echo $value['superior']; ?></td>
                                        <td><?php echo $value['score']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($evaluationRubricDetailsArr as $key => $value): ?>
                                <?php if ($value['category'] == "Written Paper"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7"> <b>Written Paper</b></td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['unacceptable']; ?></td>
                                        <td><?php echo $value['acceptable']; ?></td>
                                        <td><?php echo $value['good']; ?></td>
                                        <td><?php echo $value['superior']; ?></td>
                                        <td><?php echo $value['score']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>


                            <?php $count=0; foreach ($evaluationRubricDetailsArr as $key => $value): ?>
                                <?php if ($value['category'] == "Oral Presentation"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7"> <b>Oral Presentation</b> </td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['unacceptable']; ?></td>
                                        <td><?php echo $value['acceptable']; ?></td>
                                        <td><?php echo $value['good']; ?></td>
                                        <td><?php echo $value['superior']; ?></td>
                                        <td><?php echo $value['score']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>


                            <?php $count=0; foreach ($evaluationRubricDetailsArr as $key => $value): ?>
                                <?php if ($value['category'] == "Design"): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7"><b>Design</b></td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['unacceptable']; ?></td>
                                        <td><?php echo $value['acceptable']; ?></td>
                                        <td><?php echo $value['good']; ?></td>
                                        <td><?php echo $value['superior']; ?></td>
                                        <td><?php echo $value['score']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php $count=0; foreach ($evaluationRubricDetailsArr as $key => $value): ?>
                                <?php if ($value['category'] == null): ?>
                                    <?php
                                    if ($count == 0) {
                                        ?>
                                        <tr>
                                            <td colspan="7"><b>NO CATEGORY YET</b></td>
                                        </tr>
                                        <?php
                                    }
                                    $count ++;
                                    ?>
                                    <tr>
                                        <td><?php echo $value['title']; ?></td>
                                        <td><?php echo $value['unacceptable']; ?></td>
                                        <td><?php echo $value['acceptable']; ?></td>
                                        <td><?php echo $value['good']; ?></td>
                                        <td><?php echo $value['superior']; ?></td>
                                        <td><?php echo $value['score']; ?></td>
                                        <td><?php echo $value['comment']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>1 = UNACCEPTABLE</th>
                                <th>2 = ACCEPTABLE</th>
                                <th>3 = GOOD</th>
                                <th>4 = SUPERIOR</th>
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
