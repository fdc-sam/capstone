<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/panel/projectTitleHearingResult'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                Adviser
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php
            echo $this->session->flashdata('message');
            unset($_SESSION['message']);
        ?>

        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card mb-3">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>
                            Add Adviser
                        </div>
                    </div>
                    <form class="" action="<?php echo base_url('instructor/panel/assignAdviser/'.$groupId.'/'.$thisesId) ?>" method="post">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <label for="" class=""> <h5 class="card-title">Select Adviser </h5></label>
                                        <select name="selec2-assignAdviser" id="selec2-assignAdviser" class="form-control">
                                            <optgroup label="Instructors">
                                                <?php foreach ($allInstructors as $key => $allInstructor): ?>
                                                    <?php $fullName = $allInstructor['first_name'].' '.$allInstructor['middle_name'].' '.$allInstructor['last_name']; ?>
                                                    <?php if ($currentGroupAdviserId == $allInstructor['id']): ?>
                                                        <option value="<?php echo $allInstructor['id'] ?>" selected>
                                                            <?php echo $fullName; ?>
                                                        </option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $allInstructor['id'] ?>">
                                                            <?php echo $fullName; ?>
                                                        </option>
                                                    <?php endif; ?>

                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-block text-right card-footer">
                            <a href="<?php echo base_url('instructor/panel/projectTitleHearingResult') ?>" class="mr-2 btn btn-link btn-sm">Cancel</a>
                            <button class="btn-wide btn-shadow btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
