<div class="app-main__outer">
    <div class="app-main__inner">

        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:history.back()">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>
                                <?php echo $groupName; ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <?php if (isset($message) && $message): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                    <span aria-hidden="true">×</span>
                </button>
                <?php echo $message;?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-8 col-lg-8">
                <div class="card mb-3">
                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                                class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>
                                Group Members
                        </div>
                    </div>
                    <div class="card-body">
                        <table style="width: 100%;" id="table-groupDetails" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Gender / Sex</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groupMemberDetails as $groupMemberDetailsKey => $groupMemberDetail): ?>
                                    <tr>
                                        <?php $fullName = $groupMemberDetail['first_name']." ".$groupMemberDetail['middle_name']." ".$groupMemberDetail['last_name']; ?>
                                        <td><?php echo $fullName; ?></td>
                                        <td><?php echo $groupMemberDetail['email']; ?></td>

                                        <td><?php echo $retVal = ($groupMemberDetail['gender'] == 1) ? '<i class="pe-7s-male"> </i> Male' : '<i class="pe-7s-female"> </i> Female' ;?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Gender / Sex</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4">
                <div class="mb-3 card">
                    <div class="pt-2 pb-0 card-body">
                        <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Panelist</h6>
                        <div class="scroll-area-md shadow-overflow">
                            <div class="scrollbar-container ps ps--active-y">
                                <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                                    <?php if (isset($allPanelist) && $allPanelist): ?>
                                        <?php foreach ($allPanelist as $key => $value): ?>
                                            <li class="list-group-item">
                                                <div class="widget-content p-0">
                                                    <div class="widget-content-wrapper">
                                                        <div class="widget-content-left">
                                                            <div class="widget-heading">
                                                                <?php echo $value['panelistFullName'] ?>
                                                            </div>
                                                            <div class="widget-subheading mt-1 opacity-10">
                                                                <?php if (isset($value['gender']) && $value['gender'] && $value['gender'] == "Male"): ?>
                                                                    <div class="badge badge-pill btn-sm btn-secondary">
                                                                        <?php echo $value['gender']; ?>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="badge badge-pill btn-sm btn-info">
                                                                        <?php echo $value['gender']; ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                                <?php if (isset($value['chairman_flag']) && $value['chairman_flag']): ?>
                                                                    <div class="badge badge-pill btn-sm btn-light">
                                                                        Chairman
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 300px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 206px;"></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
