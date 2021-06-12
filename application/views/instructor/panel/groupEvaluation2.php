<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/panel/capstone2') ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Group Evaluation
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
        <div class="tabs-animation">
            <form class="" action="<?php echo base_url('instructor/panel/groupEvaluation2/'.$groupId.'/'.$capstone1Id) ?>" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>Capstone 1
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <button class="mb-2 mr-2 btn-sm btn-icon btn-shadow btn btn-primary">
                                <i class="fa fa-download  btn-icon-wrapper"> </i>
                                Save Evaluation
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table style="width: 100%;" id="table-groupEvaluation2" class="table table-hover table-striped table-bordered">
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
                                
                                <?php $count=0; foreach ($evaluationRubricDetails as $key => $evaluationRubricDetail): ?>
                                    <?php if ($evaluationRubricDetail['category'] == "Personal Development"): ?>
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
                                            <td><?php echo $evaluationRubricDetail['title'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['unacceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['acceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['good'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['superior'] ?></td>
                                            <td>
                                                <?php
                                                $score = isset($evaluationRubricDetail['score'])? $evaluationRubricDetail['score']: 0;
                                                $comment = isset($evaluationRubricDetail['comment'])? $evaluationRubricDetail['comment']: null;
                                                ?>
                                                <input type="number" name="score[]" min="0" max="4" value="<?php echo $score; ?>"  class="form-control">
                                                <input type="hidden" name="evaluationRubricId[]" value="<?php echo $evaluationRubricDetail['id'] ?>"  class="form-control">
                                            </td>
                                            <td>
                                                <textarea name="comment[]" class="form-control"><?php echo $comment; ?></textarea>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php $count = 0; foreach ($evaluationRubricDetails as $evaluationRubricDetailsKey => $evaluationRubricDetail): ?>
                                    <?php if ($evaluationRubricDetail['category'] == "Written Paper"): ?>
                                        <?php
                                        if ($count == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="7"><b>Written Paper</b> </td>
                                            </tr>
                                            <?php
                                        }
                                        $count ++;
                                        ?>

                                        <tr>
                                            <td><?php echo $evaluationRubricDetail['title'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['unacceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['acceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['good'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['superior'] ?></td>
                                            <td>
                                                <?php
                                                $score = isset($evaluationRubricDetail['score'])? $evaluationRubricDetail['score']: 0;
                                                $comment = isset($evaluationRubricDetail['comment'])? $evaluationRubricDetail['comment']: null;
                                                ?>
                                                <input type="number" name="score[]" min="0" max="4" value="<?php echo $score; ?>"  class="form-control">
                                                <input type="hidden" name="evaluationRubricId[]" value="<?php echo $evaluationRubricDetail['id'] ?>"  class="form-control">
                                            </td>
                                            <td>
                                                <textarea name="comment[]" class="form-control"><?php echo $comment; ?></textarea>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php $count = 0; foreach ($evaluationRubricDetails as $evaluationRubricDetailsKey => $evaluationRubricDetail): ?>
                                    <?php if ($evaluationRubricDetail['category'] == "Oral Presentation"): ?>
                                        <?php
                                        if ($count == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="7"><b>Oral Presentation</b> </td>
                                            </tr>
                                            <?php
                                        }
                                        $count ++;
                                        ?>

                                        <tr>
                                            <td><?php echo $evaluationRubricDetail['title'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['unacceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['acceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['good'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['superior'] ?></td>
                                            <td>
                                                <?php
                                                $score = isset($evaluationRubricDetail['score'])? $evaluationRubricDetail['score']: 0;
                                                $comment = isset($evaluationRubricDetail['comment'])? $evaluationRubricDetail['comment']: null;
                                                ?>
                                                <input type="number" name="score[]" min="0" max="4" value="<?php echo $score; ?>"  class="form-control">
                                                <input type="hidden" name="evaluationRubricId[]" value="<?php echo $evaluationRubricDetail['id'] ?>"  class="form-control">
                                            </td>
                                            <td>
                                                <textarea name="comment[]" class="form-control"><?php echo $comment; ?></textarea>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php $count = 0; foreach ($evaluationRubricDetails as $evaluationRubricDetailsKey => $evaluationRubricDetail): ?>
                                    <?php if ($evaluationRubricDetail['category'] == "Design"): ?>
                                        <?php
                                        if ($count == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="7"><b>Design</b> </td>
                                            </tr>
                                            <?php
                                        }
                                        $count ++;
                                        ?>

                                        <tr>
                                            <td><?php echo $evaluationRubricDetail['title'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['unacceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['acceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['good'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['superior'] ?></td>
                                            <td>
                                                <?php
                                                $score = isset($evaluationRubricDetail['score'])? $evaluationRubricDetail['score']: 0;
                                                $comment = isset($evaluationRubricDetail['comment'])? $evaluationRubricDetail['comment']: null;
                                                ?>
                                                <input type="number" name="score[]" min="0" max="4" value="<?php echo $score; ?>"  class="form-control">
                                                <input type="hidden" name="evaluationRubricId[]" value="<?php echo $evaluationRubricDetail['id'] ?>"  class="form-control">
                                            </td>
                                            <td>
                                                <textarea name="comment[]" class="form-control"><?php echo $comment; ?></textarea>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php $count = 0; foreach ($evaluationRubricDetails as $evaluationRubricDetailsKey => $evaluationRubricDetail): ?>
                                    <?php if ($evaluationRubricDetail['category'] == null): ?>
                                        <?php
                                        if ($count == 0) {
                                            ?>
                                            <tr>
                                                <td colspan="7"><b>NO CATEGORY YET</b> </td>
                                            </tr>
                                            <?php
                                        }
                                        $count ++;
                                        ?>

                                        <tr>
                                            <td><?php echo $evaluationRubricDetail['title'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['unacceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['acceptable'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['good'] ?></td>
                                            <td><?php echo $evaluationRubricDetail['superior'] ?></td>
                                            <td>
                                                <?php
                                                $score = isset($evaluationRubricDetail['score'])? $evaluationRubricDetail['score']: 0;
                                                $comment = isset($evaluationRubricDetail['comment'])? $evaluationRubricDetail['comment']: null;
                                                ?>
                                                <input type="number" name="score[]" min="0" max="4" value="<?php echo $score; ?>"  class="form-control">
                                                <input type="hidden" name="evaluationRubricId[]" value="<?php echo $evaluationRubricDetail['id'] ?>"  class="form-control">
                                            </td>
                                            <td>
                                                <textarea name="comment[]" class="form-control"><?php echo $comment; ?></textarea>
                                            </td>
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
            </form>
        </div>
    </div>
</div>
