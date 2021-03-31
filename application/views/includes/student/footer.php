</div>
</div>

<?php if ($mainContent == 'student/home' && $subContent == 'home/index'): ?>
	<?php  
		// require_once(base_url('inc'));
	?>
<?php endif; ?>

</body>
</html>
<script src="<?php echo base_url('assets/scripts/jquery-3.6.0.js'); ?>" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>
<script type="text/javascript">
	// set variables
	var base_url = '<?php echo base_url()?>';
	var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>'; 
	var sub_content =  '<?php echo isset($subContent)? $subContent : null ?>'; 
</script>

<?php if ($mainContent == 'student/home'): ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
	<script src="<?php echo base_url('assets/scripts/student/home.js'); ?>"></script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#loadingState').hide();
});
</script>
