<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-info card-header-text">
                        <div class="card-text">
                            <h4 class="card-title">Edit Subject</h4>
                        </div>
                    </div>
                    <div class="card-body ">
                        <?php echo $this->session->flashdata('message'); ?>
                        <form method="POST" action="<?php echo base_url('admin/subject/edit/').$subject_id ; ?>" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject ID</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" name="subjectId" class="form-control" required value="<?php echo $subject_details->subject_id; ?>">
                                        <span class="bmd-help">Please Enter the Complete ID of the subject</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject Name</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <input type="text" name="subjectName" class="form-control" required value="<?php echo $subject_details->subject_name; ?>">
                                        <span class="bmd-help">Please Enter the Complete name of the subject</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Subject Description</label>
                                <div class="col-sm-10">
                                    <div class="form-group bmd-form-group">
                                        <textarea type="text" name="subjectDescription" class="form-control" required><?php echo $subject_details->subject_description; ?></textarea>
                                        <span class="bmd-help">Please Enter some description</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <div class="form-check mr-auto">
                                </div>
                                <button type="submit" class="btn btn-facebook">Update<div class="ripple-container"></div></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>