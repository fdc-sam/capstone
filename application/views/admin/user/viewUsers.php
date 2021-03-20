<div class="content">
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
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="material-datatables">
                                <table id="viewUsersTable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Full Name</th>
                                            <th>E-mail</th>
                                            <th>Group</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Full Name</th>
                                            <th>E-mail</th>
                                            <th>Group</th>
                                            <th>Status</th>
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