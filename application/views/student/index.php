
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
        <div class="" id="alertMessege"></div>        
        <div class="tabs-animation">
            
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="card mb-3">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i
                                    class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Group Members
                            </div>
                            <div class="btn-actions-pane-right actions-icon-btn">
                                <div class="btn-group dropdown">
                                    <button class="mb-2 mr-2 btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="modal" data-target="#addGroupModal">
                                        <i class="pe-7s-add-user btn-icon-wrapper"> </i> Add Member
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;" id="dataTableGroupMembers" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>E-mail</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                                Group Proposals
                            </div>
                            <div class="btn-actions-pane-right text-capitalize">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="modal" data-target="#addProposeModal"><i class="lnr lnr-file-add btn-icon-wrapper"> </i>Propose</button>
                            </div>
                        </div>
                        <ul class="todo-list-wrapper list-group list-group-flush" id="proposals">
                            
                            
                        </ul>
                        <div class="d-block text-right card-footer">
                            <!-- <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                            <button class="btn btn-success btn-lg">Save</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



