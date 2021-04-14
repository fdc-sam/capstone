		</div>
	</div>
</body>
</html>
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

<?php if ($subContent == 'head/viewStudent'): ?>
	<script type="text/javascript">
		var batchCode = '<?php echo $batchCode ?>';
	</script>
<?php endif; ?>

<?php if ($mainContent == 'instructor/head'): ?>
	<script src="<?php echo base_url('assets/scripts/ckeditor/ckeditor.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/instructor/head.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/sweetalert2.js'); ?>"></script>
<?php endif; ?>

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
