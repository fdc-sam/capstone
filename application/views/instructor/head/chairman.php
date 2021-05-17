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
                            <a>Chairman</a>
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

    							<form action="<?php echo base_url('instructor/head/addChairman'); ?>" method="post">
    								<div class="form-row">
    									<div class="col-md-12">
                                            <?php if (isset($panelistDetails) && $panelistDetails): ?>
        										<div class="position-relative form-group">
        											<label for="" class=""> Chairman</label>
        											<select id="panelist" name="panelist" class=" form-control">
                                                            <?php foreach ($panelistDetails as $key => $panelistDetail): ?>
                                                                <?php
                                                                $fullName = $panelistDetail->first_name.' '.$panelistDetail->middle_name.' '.$panelistDetail->last_name;
                                                                $selected = "";
                                                                if (isset($panelistId) && $panelistId == $panelistDetail->id) {
                                                                    $selected = "selected";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $panelistDetail->id; ?>"
                                                                    <?php echo $selected; ?>
                                                                >
                                                                    <?php echo $fullName; ?>
                                                                </option>
                                                            <?php endforeach; ?>
        		                                    </select>
        										</div>
                                            <?php else: ?>
                                                <h4>Please Assigne Panelist before assigning Chairman</h4>
                                            <?php endif; ?>
    									</div>
                                        <input type="text" name="oldChairman" value="<?php echo $panelistId ?>">
                                        <input type="text" name="thisesGroup" value="<?php echo $thisesGroup ?>">
    								</div>


                                    <div class="divider"></div>
                                    <div class="clearfix">
                                        <!-- <button type="button" id="reset-btn" class="btn-shadow float-left btn btn-link">Reset</button> -->
                                        <button type="submit" id="updatePanelist" class="btn-shadow btn-wide float-right btn-hover-shine btn btn-primary">Save</button>
                                        <a href="<?php echo base_url('instructor/head/proposal'); ?>"  class="btn-shadow float-right btn-wide mr-3 btn btn-outline-secondary">Cancel</a>
                                    </div>
                                </form>
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
