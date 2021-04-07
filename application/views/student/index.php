
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Member Dashboard
                        <div class="page-title-subheading">This is an example dashboard created using build-in elements and components.</div>
                    </div>
                </div> 
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
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    <tr>
                                        <td>Garrett Winters</td>
                                        <td>Accountant</td>
                                        <td>Tokyo</td>
                                        <td>63</td>
                                        <td>2011/07/25</td>
                                        <td>$170,750</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
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



