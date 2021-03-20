<div class="content">
    <?php  
        // echo "<pre>";
        // print_r($subjects);
        // die();
    ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-info card-header-icon" id="addStudent" style="cursor: pointer;">
                            <div class="card-icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <h4 class="card-title">Add Student</h4>
                        </div>
                        <div class="card-body">
                            <hr>
                            
                            <div class="material-datatables">
                                <table id="viewClassRoomTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> ID</th>
                                            <th>Class Name</th>
                                            <th>Subject Name</th>
                                            <th>Status</th>
                                            <th>Instructor Assigned</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th> ID</th>
                                            <th>Class Name</th>
                                            <th>Subject Name</th>
                                            <th>Status</th>
                                            <th>Instructor Assigned</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</dev>

<!-- Modal -->
<div class="modal fade" id="subject-assign-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" name="" id="subject-id" value="">
                <div class="row">
                    <label class="col-form-labe">Select Instructor</label>
                    <div class="col-sm-12">
                        <div class="form-group bmd-form-group">
                            <select class="form-control" name="subjectInstructor">
                                <option value=""  selected> --- SELECT --- </option>
                                <?php foreach ($instructors as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->first_name." ".$value->middle_name." ". $value->last_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-form-labe">Select Subject</label>
                    <div class="col-sm-12">
                        <div class="form-group bmd-form-group">
                            <select class="form-control" name="subjectInstructor">
                                <option value=""  selected> --- SELECT --- </option>
                                <?php foreach ($subjects as $key => $subject): ?>
                                    <option value="<?php echo $subject->id; ?>"><?php echo $subject->subject_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>

