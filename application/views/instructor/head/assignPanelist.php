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
                            <a href="<?php echo base_url('instructor/head/proposal'); ?>" >Proposal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Assign Panelist</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>   
        <div class="" id="message"></div>
        <div class="tab-content">
            <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input id="thesisGroupId" type="text" name="" value="<?php echo $thesisGroupId ?>">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><span class="text-danger">* </span> Panelist</label>
                                            <select id="panelist" class="form-control" multiple="multiple">
                                                <?php foreach ($intructors as $key => $intructors): ?>
                                                    <?php  
                                                        $fullName = $intructors->first_name." ".$intructors->middle_name." ".$intructors->last_name;
                                                    ?>
                                                    <option value="<?php echo $intructors->id; ?>"><?php echo $fullName; ?></option>
                                                <?php endforeach; ?>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="divider"></div>
                                <div class="clearfix">
                                    <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                    <button type="button" id="assignPanelist" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Update</button>
                                    <a href="<?php echo base_url('instructor/head/proposal'); ?>"  class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>