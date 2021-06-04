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
            <div class="card mb-12">
                <div class="card-header">
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>Student

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">

                        </div>
                        <div class="col-md-3">
                            <div class="position-relative row form-group">
                                <label for="exampleSelect" class="col-sm-12 col-form-label">Sort By Date</label>
                                <div class="col-sm-12">
                                    <select name="select" id="searchDate" class="form-control">

                                        <?php if (isset($studentDetails) && $studentDetails): ?>
                                            <?php foreach ($studentDetails as $key1 => $studentDetail1):?>
                                                <?php
                                                $displayDate = date('Y-m', strtotime($studentDetail1['date_created']));
                                                ?>
                                                <?php if (isset($studentDetails[$key1+1]['date_created']) && $studentDetails[$key1+1]['date_created'] != $studentDetail1['date_created']): ?>
                                                    <option value="<?php echo $displayDate; ?>" <?php echo ($searchDate == $displayDate)? 'selected': ''; ?> >
                                                        Summer of <?php echo  date('Y', strtotime($studentDetail1['date_created'])); ?>
                                                    </option>
                                                <?php endif; ?>

                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <table style="width: 100%;" id="table-student" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STUDENT ID</th>
                                <th>NAME</th>
                                <th>E-MAIL</th>
                                <th>CREATED</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($studentDetails) && $studentDetails): ?>
                                <?php foreach ($studentDetails as $key => $studentDetail):
                                    $fullName = $studentDetail['first_name'].' '.$studentDetail['middle_name'].' '.$studentDetail['last_name'];
                                    $displayDate = date('Y-m', strtotime($studentDetail['date_created']));
                                ?>
                                <?php if ($searchDate == $displayDate): ?>
                                    <tr>
                                        <td><?php echo $studentDetail['school_users_id']; ?></td>
                                        <td><?php echo $fullName; ?></td>
                                        <td><?php echo $studentDetail['email']; ?></td>
                                        <td><?php echo $studentDetail['date_created']; ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>STUDENT ID</th>
                                <th>NAME</th>
                                <th>E-MAIL</th>
                                <th>CREATED</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
