<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Create New Subject</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <?php echo $this->session->flashdata('message'); ?>
                        <form method="POST" action="<?php echo base_url('admin/subject/createSubject') ?>" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject ID</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" name="subjectId" class="form-control" required>
                                        <span class="bmd-help">Please Enter the Complete ID of the subject</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject Name</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" name="subjectName" class="form-control" required>
                                        <span class="bmd-help">Please Enter the Complete name of the subject</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- <div class="row">
                                <label class="col-sm-2 col-form-label">Select Instructor</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <select class="form-control" name="subjectInstructor">
                                            <option value=""  selected> --- SELECT --- </option>
                                            <?php foreach ($instructor as $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->first_name." ".$value->middle_name." ". $value->last_name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <br>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject Description</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <textarea type="text" name="subjectDescription" class="form-control" required></textarea>
                                        <span class="bmd-help">Please Enter some description</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <div class="form-check mr-auto">
                                </div>
                                <button type="submit" class="btn btn-facebook">Register<div class="ripple-container"></div></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>