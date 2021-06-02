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
                    <i class="header-icon lnr-laptop-phone icon-gradient bg-plum-plate"> </i>Student
                </div>
                <div class="card-body">
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
                                ?>

                                    <tr>
                                        <td><?php echo $studentDetail['school_users_id']; ?></td>
                                        <td><?php echo $fullName; ?></td>
                                        <td><?php echo $studentDetail['email']; ?></td>
                                        <td><?php echo $studentDetail['date_created']; ?></td>
                                    </tr>
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
