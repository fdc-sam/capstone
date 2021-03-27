		</div>
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>



<script type="text/javascript">

// set variables
var base_url = '<?php echo base_url()?>';
var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>'; 
var sub_content =  '<?php echo isset($subContent)? $subContent : null ?>'; 
</script>

<?php if ($subContent == 'head/batch'): ?>
	<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="<?php echo base_url('assets/scripts/instructor/head.js'); ?>"></script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
    $('#loadingState').hide();
});
</script>
