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

<?php if ($subContent == 'head/batch'): ?>
	<script src="<?php echo base_url('assets/scripts/ckeditor/ckeditor.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/instructor/head.js'); ?>"></script>
	<script src="<?php echo base_url('assets/scripts/sweetalert2.js'); ?>"></script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#loadingState').hide();
});
</script>
