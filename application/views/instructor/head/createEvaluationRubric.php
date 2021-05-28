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
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>
                    Thesis 2 Evaluation Rubric
                </div>
                <div class="card-body">
                    <?php
                        $actionUrl =  base_url('instructor/head/createEvaluationRubric');
                        if (isset($evaluationRubricId) && $evaluationRubricId) {
                            $actionUrl =  base_url('instructor/head/createEvaluationRubric/'.$evaluationRubricId);
                        }
                    ?>
                    <form class="" action="<?php echo$actionUrl; ?>" method="post">
                        <div class="position-relative form-group">
                            <label for="exampleEmail" class="">Title</label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                placeholder="Tilte here ..."
                                class="form-control"
                                value="<?php echo isset($evaluationRubricDetails->title)? $evaluationRubricDetails->title: null; ?>">
                        </div>
                        <br>
                        <h5 class="card-title">Controls Types</h5>
                        <div class="position-relative form-group">
                            <label for="exampleText" class="">Unacceptable</label>
                            <textarea name="unacceptable" id="exampleText" class="form-control"><?php echo isset($evaluationRubricDetails->unacceptable)? $evaluationRubricDetails->unacceptable: null; ?></textarea>
                        </div>
                        <div class="position-relative form-group">
                            <label for="exampleText" class="">Acceptable</label>
                            <textarea name="acceptable" id="exampleText" class="form-control"><?php echo isset($evaluationRubricDetails->acceptable)? $evaluationRubricDetails->acceptable: null; ?></textarea>
                        </div>
                        <div class="position-relative form-group">
                            <label for="exampleText" class="">Good</label>
                            <textarea name="good" id="exampleText" class="form-control"><?php echo isset($evaluationRubricDetails->good)? $evaluationRubricDetails->good: null; ?></textarea>
                        </div>
                        <div class="position-relative form-group">
                            <label for="exampleText" class="">Superior</label>
                            <textarea name="superior" id="exampleText" class="form-control"><?php echo isset($evaluationRubricDetails->superior)? $evaluationRubricDetails->superior: null; ?></textarea>
                        </div>

                        <button class="mt-1 btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
