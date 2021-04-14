<div class="app-main__outer">
    <div class="app-main__inner">
        
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
                            <a href="<?php echo base_url('instructor/head/batch'); ?>">
                                Batch
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>View Register Student</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="tab-content">
            <div id="alertMessege">
                
            </div>
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            
                            <div class="card-body">
                                <table style="width: 100%;" id="viewStudentBatchDataTable" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>E-mail</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    
                                    <tfoot>
                                        <tr>
                                            <th>Fullname</th>
                                            <th>E-mail</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Create Batch</h5>
                                <form class="" id="batch_form">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="position-relative form-group ">
                                                <label for="exampleEmail" class="">From</label>
                                                <input type="text" class="form-control date" name="batch_from" id="batch_from" value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="position-relative form-group ">
                                                <label for="exampleEmail" class="">To</label>
                                                <input type="text" class="form-control date" name="batch_to" id="batch_to" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="examplePassword" class="">Batch Code</label>
                                        <input type="text" class="form-control" name="batch_code" id="batch_code" value="<?php echo  $batch_code; ?>" disabled>
                                    </div>
                                    <div class="position-relative form-group">
                                        <label for="exampleText" class="">Batch Description</label>
                                        <textarea name="batch_description" id="batch_description"></textarea>
                                    </div>
                                    <div class="position-relative form-group">
                                        <small class="form-text text-muted">This is some placeholder block-level help
                                            text for the above input. It's a bit lighter and easily wraps to a new
                                            line.
                                        </small>
                                    </div>
                                    <button class="mt-1 btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>