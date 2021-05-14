		</div>
	</div>
</body>
</html>


<?php
if ($subContent == 'head/groups') {
	require_once(APPPATH.'elements/instructor/headModal.php');
}
?>

<script src="<?php echo base_url('assets/scripts/jquery-3.6.0.js'); ?>" ></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>



<script type="text/javascript">

	// set variables
	var base_url = '<?php echo base_url()?>';
	var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>';
	var sub_content =  '<?php echo isset($subContent)? $subContent : null ?>';
</script>

<?php if ($subContent == 'head/teamProposal'): ?>
	<script type="text/javascript">
		var thesisGroupId = '<?php echo $thesisGroupId ?>';
	</script>
<?php endif; ?>

<?php if ($subContent == 'head/proposalDetails'): ?>
	<script type="text/javascript">
		var thesisGroupId = '<?php echo $thesisGroupId ?>';
	</script>
<?php endif; ?>

<?php if ($subContent == 'head/viewStudent'): ?>
	<script type="text/javascript">
		var batchCode = '<?php echo $batchCode ?>';
	</script>
<?php endif; ?>

<?php if ($subContent == 'head/assignPanelist' || $subContent == 'head/titleHearingEdit'): ?>
	<script src="<?php echo base_url('assets/scripts/select2.min.js'); ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<?php endif; ?>

<!-- start -->
	<script src="<?php echo base_url('assets/scripts/ckeditor/ckeditor.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/jquery.dataTables.min.js'); ?>"></script>
	<?php if ($mainContent == 'instructor/head'): ?>
		<script src="<?php echo base_url('assets/scripts/instructor/head.js'); ?>"></script>
	<?php endif; ?>
	<?php if ($mainContent == 'instructor/panel'): ?>
		<script src="<?php echo base_url('assets/scripts/instructor/panel.js'); ?>"></script>
	<?php endif; ?>

	<script src="<?php echo base_url('assets/scripts/sweetalert2.js'); ?>"></script>
<!-- end -->

<?php if ($mainContent == 'instructor/head'): ?>
	<script type="text/javascript">

	// notifications
	function notification(){
		$.ajax({
			url:`${base_url}/instructor/autoLoad/headNotification`,
			type:'post',
			dataType:'json',
			success:function(data){
				if (data.totalNotificationCount != 0) {
					$('#getNotifications').html(data.output);
					$('#getCountUnread').html(data.totalNotificationCount);
				}else{
					$('#getNotifications').html(data.output);
					$('#getCountUnread').html(data.totalNotificationCount);
				}
			}
		});
	}
	notification();

	</script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#loadingState').hide();
});
</script>


<?php if ($subContent == 'head/assignPanel' || $subContent == 'head/titleHearingEdit'): ?>
	<script src="<?php echo base_url('assets/scripts/select2.min.js'); ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<?php endif; ?>

<?php if ($subContent == 'head/assignPanel'): ?>
	<style media="screen">
	    .select2-search__field{
	        width: 100% !important;
	    }
	</style>
	<!-- Large modal  add Project Title Hearing -->
	<div class="modal fade" id="projectTitleHearing" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
	        <form id="proposeForm" class="" action="index.html" method="post">
	            <div class="modal-content">
	                <div class="modal-header">
	                    <h5 class="modal-title" >Add Project Title</h5>
	                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                </div>
	                <div class="modal-body">
	                    <div class="modalContainer">
							<div class="form-row">
								<div class="col-md-12">
									<div class="position-relative form-group">
										<label for="" class=""> Hearing Date</label>
										<input id="hearingDateTime" type="datetime-local" name="hearingDate" value="" class="form-control proposeTitle" required>
									</div>
								</div>
							</div>

							<form id="form-addMoreProjectHearing" class="" action="index.html" method="post">
								<div class="form-row">
									<div class="col-md-12">
										<div class="position-relative form-group">
											<label for="" class=""> Group Name</label>
											<select id="groupName" class="select2-group form-control">

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
											<select id="panelist" multiple="multiple" class="select2-panelist form-control">

		                                    </select>
										</div>
									</div>
								</div>
							</form>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-primary addMoreProjectHearing">Propose</button>
	                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
<?php endif; ?>
