<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-display1 icon-gradient bg-premium-dark"></i>
                    </div>
                    <div>Student Batch
                        <div class="page-title-subheading">Wide selection of forms controls, using the Bootstrap 4 code base, but built with React.</div>
                    </div>
                </div>
            </div>
        </div>        
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                    <span>Batch's</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                    <span>Add New Batch</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="alertMessege">
                
            </div>
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-card mb-3 card">
                            <!-- <div class="card-body">
                                <table style="width: 100%;" id="batchDataTable" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Batch Code</th>
                                            <th>Batch Year From</th>
                                            <th>Batch Year To</th>
                                            <th>Batch Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tfoot>
                                        <tr>
                                            <th>Batch Code</th>
                                            <th>Batch Year From</th>
                                            <th>Batch Year To</th>
                                            <th>Batch Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div> -->
                            
                            <div class="card-body">
                                <table style="width: 100%;" id="batchDataTable" class="table table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Batch Code</th>
                                            <th>Batch Year From</th>
                                            <th>Batch Year To</th>
                                            <th>Batch Status</th>
                                            <th>Registered Student</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tfoot>
                                        <tr>
                                            <th>Batch Code</th>
                                            <th>Batch Year From</th>
                                            <th>Batch Year To</th>
                                            <th>Batch Status</th>
                                            <th>Registered Student</th>
                                            <th>Action</th>
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