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
                            <a>Hearing Details</a>
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
    								<div class="col-md-12">
    									<div class="position-relative form-group">
    										<label for="" class=""> Hearing Date</label>
                                            <?php
                                                    $timeStamp =isset($projectHearingDetail[0]['hearing_date'])? date('Y-m-d\TH:i', strtotime($projectHearingDetail[0]['hearing_date'])): ''; // yyyy-MM-dd'T'HH:mm:ss.SSSZ
                                            ?>
    										<input id="hearingDateTime" type="datetime-local" name="hearingDate" value="<?php echo $timeStamp; ?>" class="form-control proposeTitle" required>
    									</div>
    								</div>
    							</div>

    							<form id="form-addMoreProjectHearing" class="" action="index.html" method="post">
    								<div class="form-row">
    									<div class="col-md-12">
    										<div class="position-relative form-group">
    											<label for="" class=""> Group Name</label>
    											<select id="groupName" class=" form-control" disabled>
    		                                       <option value="<?php echo $groupDetail->id; ?>" selected><?php echo $groupDetail->thesis_group_name; ?></option>
    		                                    </select>
    										</div>
    									</div>
    								</div>

    								<div class="form-row">
    									<div class="col-md-12">
    										<div class="position-relative form-group">
    											<ul id="proposalTitles" class="proposalTitles">

    											</ul>
    										</div>
    									</div>
    								</div>
    								<div class="form-row">
    									<div class="col-md-12">
    										<div class="position-relative form-group">
    											<label for="" class=""> Panelist</label>
    											<select id="panelist" class="select2-panelist form-control">

    		                                    </select>
    										</div>
    									</div>
    								</div>
    							</form>

                                <div class="divider"></div>
                                <div class="clearfix">
                                    <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                    <button type="button" id="updatePanelist" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Save</button>
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
<script type="text/javascript">
    var groupId = '<?php echo $groupId ?>';
</script>
