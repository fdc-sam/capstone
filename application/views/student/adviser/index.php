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
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card mb-3">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                                class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Assigned Adviser
                        </div>

                    </div>
                    <div class="card-body">
                        <table style="width: 100%;" id="table-adviser" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>E-mail</th>
                                    <th>GENDER</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($adviserDetails) && $adviserDetails): ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $fullname = $adviserDetails->first_name.' '.$adviserDetails->first_name.' '.$adviserDetails->first_name;
                                            echo $fullname;
                                            ?>
                                        </td>
                                        <td><?php echo $adviserDetails->email; ?></td>
                                        <td>
                                            <?php
                                                if ($adviserDetails->gender == 1) {
                                                    echo "Male";
                                                }elseif ($adviserDetails->gender == 2) {
                                                    echo "Female";
                                                }else{
                                                    echo "Others";
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a
                                                href="<?php echo base_url('student/adviser/addMessageToAdviser/'.$groupId); ?>"
                                                class="btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                            >
                                                <i class="metismenu-icon fa fa-fw"></i> Message Adviser
                                            </a>
                                            <a
                                                href="<?php echo base_url('student/adviser/viewLogs/'.$groupId); ?>"
                                                class="btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-alternate"
                                            >
                                                <i class="fa fa-list" aria-hidden="true"></i>
                                                View Logs
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>NAME</th>
                                    <th>E-mail</th>
                                    <th>GENDER</th>
                                    <th>ACTION</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
