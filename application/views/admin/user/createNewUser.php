
<div class="content">
    <div class="content">
        <div class="container-fluid">
			<div class="col-md-12">
                <form id="createUserForm" action="<?php echo base_url('auth/create_user'); ?>" method="POST" novalidate="novalidate">
                    <div class="card ">
                        <?php echo $this->session->flashdata('message'); ?>
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person_add</i>
                            </div>
                            <h4 class="card-title">Register Form</h4>
                        </div>
                        <br>
                        <div class="alert hidden" id="alertMessage">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="material-icons">close</i>
                            </button>
                            <span id="infoMessage"></span>
                        </div>
                        <div class="card-body ">
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">First Name *</label>
		                                <input type="text" class="form-control" name="first_name" id="first_name" required="true" aria-required="true">
		                            </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">Middle Name *</label>
		                                <input type="text" class="form-control" name="middle_name" id="middle_name" required="true" aria-required="true">
		                            </div>
								</div>
								<div class="col-sm-4">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">Last Name *</label>
		                                <input type="text" class="form-control" name="last_name" id="last_name" required="true" aria-required="true">
		                            </div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">E-mail *</label>
		                                <input type="email" class="form-control" name="email" id="email" required="true" aria-required="true">
		                            </div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">Mobile Number *</label>
		                                <input type="text" class="form-control" name="phone" id="phone" required="true" aria-required="true">
		                            </div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">Password *</label>
		                                <input type="password" class="form-control" name="password" id="password" required="true" aria-required="true">
		                            </div>
								</div>
								<div class="col-sm-6">
									<div class="form-group bmd-form-group">
		                                <label for="exampleEmail" class="bmd-label-floating">Comfirm Password *</label>
		                                <input type="password" class="form-control" name="password_confirm" id="password_confirm" required="true" aria-required="true">
		                            </div>
								</div>
							</div>
                            <div class="category form-category">* Required fields</div>
                        </div>
                        <div class="col-sm-12 hidden" id="loader" align="center" >
                            <img class="" src="<?php echo base_url('assets/img/ezgif.gif'); ?>" alt="" style="width:20%;">
                        </div>
                        <div class="card-footer text-right " id="footer">
                            <div class="form-check">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="group" value="1" checked=""> Admin
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="group" value="5" checked=""> Instructor
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="group" value="4" checked=""> Student
                                            <span class="circle">
                                                <span class="check"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="category form-category float-left">Please Select User Category</div>
                            </div>
                            <button type="submit" class="btn btn-info">Register</button>
                        </div>
                    </div>
                </form>
	        </div>
	    </div>          
    </div>
</div>
