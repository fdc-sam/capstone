<div class="content">
    
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <form id="subjectCreateFrom" action="<?php echo base_url('admin/classRoom/createClassRoom'); ?>" method="POST" novalidate="novalidate">
                <div class="card ">
                    <div class="card-header card-header-rose card-header-icon">
                        <h4 class="card-title">Create Subject Title</h4>
                    </div>
                    <div class="card-body ">
                        <?php echo $this->session->flashdata('message'); ?>
                        <label for="exampleEmail" class="bmd-label-floating"> Select Instructor </label>
                        <div class="form-group bmd-form-group">
                            <select class="form-control" name="instructor_id" required>
                                <option  selected> --- SELECT --- </option>
                                <?php foreach ($instructors as $key => $value): ?>
                                    <option value="<?php echo $value->user_id; ?>"><?php echo $value->first_name." ".$value->middle_name." ". $value->last_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <br>
                        <label for="exampleEmail" class="bmd-label-floating"> Select Subject </label>
                        <div class="form-group bmd-form-group">
                            <select class="form-control" name="subject_id" required>
                                <option  selected> --- SELECT --- </option>
                                <?php foreach ($subjects as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->subject_id." || ".$value->subject_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <br>
                        <div class="form-group bmd-form-group">
                            <label for="exampleEmail" class="bmd-label-floating"> Class Name </label>
                            <input type="text" class="form-control" name="class_name" required="" aria-required="true" >
                        </div>
                        <div class="form-group bmd-form-group">
                            <label for="examplePassword" class="bmd-label-floating"> Class Description </label>
                            <textarea class="form-control" name="class_description" aria-required="true" rows="5" cols="80"></textarea>
                        </div>
                        <div class="category form-category">* Required fields</div>
                    </div>
                    <div class="card-footer text-right">
                        <div class="form-check mr-auto">
                            
                        </div>
                        <button type="submit" class="btn btn-facebook">Create</button>
                    </div>
                    </div>
                </form>
                <!-- end content-->
          </div>
      </div>
    </div>
</div>


<script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>';
</script>