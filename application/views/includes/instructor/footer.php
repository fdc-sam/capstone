		</div>
	</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>

<?php if ($subContent == 'head/batch'): ?>
	<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<?php endif; ?>

<script type="text/javascript">

// set variables
var base_url = '<?php echo base_url()?>';
var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>'; 
var sub_content =  '<?php echo isset($subContent)? $subContent : null ?>'; 

$(document).ready(function(){
    $('#loadingState').hide();
    
    if (sub_content == "head/batch") {
		
		// this line of code is for the textarea design ang functionalities
    	CKEDITOR.replace('batch_description');
		
		$('#batch_form').on('submit', function(e){
			e.preventDefault();
			// get the CKEDITOR textarea value
			for ( batch_description in CKEDITOR.instances )
			var batch_description = CKEDITOR.instances[batch_description].getData();
			// CKEDITOR.instances[batch_description].updateElement();
			
			var batch_from = $('#batch_from').val();
			var batch_to = $('#batch_to').val();
			var batch_code = $('#batch_code').val();
			$.ajax({
	        	url:`${base_url}/instructor/head/insert_batch`,
	        	type:'post',
	        	dataType:'json',
	        	data:{batch_from:batch_from, batch_to:batch_to, batch_code:batch_code, batch_description:batch_description},
				beforeSend: function() {
					$('#loadingState').show();
				},
	        	success:function(data){
					if (!data.error) {
						$('#batch_form')[0].reset();
						var alertClass = `alert-success`;
						var alertMessege = `Batch has successfully <b>Created</b>`;
					}else{
						var alertClass = `alert-warning`;
						var alertMessege = `Batch was not created`;
					}
					
					$('#alertMessege').html(`
						<div class="alert alert-dismissible fade show ${alertClass}" role="alert">
							<button type="button" class="close" aria-label="Close" data-dismiss="alert">
								<span aria-hidden="true">×</span>
							</button>
							${alertMessege}
						</div>`
					);
					
	            	console.log(data);
	        	},
				error: function(xhr, status, error){
					$('#alertMessege').html(`
						<div class="alert alert-dismissible fade show alert-danger" role="alert">
							<button type="button" class="close" aria-label="Close" data-dismiss="alert">
								<span aria-hidden="true">×</span>
							</button>
							Batch was not created, please Refresh the page
						</div>`
					);
				},
				complete: function(){
					$('#loadingState').hide();
				}
	    	});
		});
		
		// get the batch data
		function getBatchData(){
	        //teacher view
	        var batchDataTable = $('#batchDataTable').DataTable({
	            "responsive" : true,
	            "processing" : true,
	            "serverSide" : true,
	            "order": [[0,'asc']],
	            "ajax" : {
	              "url" : `${base_url}/instructor/head/getBatchDataTable`,
	              "type" : "POST"
	            },
	            "columnDefs": [
	                {
	                    "targets": [ ], //first column / numbering column
	                    "orderable": false, //set not orderable
	                },
	                // { targets: 5 , class: 'text-center'}
	                // { targets: 5 , class: 'text-center'},
	            ],
	            "columns" : [
	                {"data": "code"},
	                {"data": "batch_from"}, 
	                {"data": "batch_to"},
	                {
	                    "data": "status",
	                    "render": function(data, type, row, meta){
	                        if (data == 1) {
	                            return `Active`;
	                        }else{
	                            return `Deactivate`;
	                        }
	                    }
	                },
	                
	                {
	                    "data": 'id',
	                    "render": function(data, type, row, meta){
							var btnReturn = '';
	                        if (row.status == 1 ) {
	                            btnReturn += `
									<button class="btn-deactivate btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger"  batchId="${data}" data-toggle="tooltip" data-placement="top" title="Deactivate">
										<i class="lnr-cross-circle btn-icon-wrapper"> </i>
									</button>
	                            `;
	                        }else{
	                            btnReturn +=  `
									<button class="btn-activate btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"  batchId="${data}" data-toggle="tooltip" data-placement="top" title="Activate">
										<i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
									</button>
	                            `;
	                        }
							btnReturn +=  `
								<button class="btn-edit btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-info" batchId="${data}" data-toggle="tooltip" data-placement="top" title="Edit">
									<i class="lnr-pencil btn-icon-wrapper"> </i>
								</button>
								<button class="btn-view btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-secondary"  batchId="${data}" data-toggle="tooltip" data-placement="top" title="View">
									<i class="lnr-eye btn-icon-wrapper"> </i>
								</button>
							`;
							return btnReturn;
	                                            
	                    }
	                }
	            ]
	        });// end of the data table variable
	    } // end of the getBatchData()
		
		// run the getBatchData()
		getBatchData();
		
		// edit
		$(document).on("click", ".btn-edit", function(e){
			
			var batchData = JSON.stringify({
				id: jQuery(this).attr('batchId')
			});
			
		});
		
		// activate
		$(document).on("click", ".btn-activate", function(e){
			
			var batchData = JSON.stringify({
				id: jQuery(this).attr('batchId')
			});
			
		});
		
		// deactivate
		$(document).on("click", ".btn-deactivate", function(e){
			
			var batchData = JSON.stringify({
				id: jQuery(this).attr('batchId')
			});
			
		});
		
		// view
		$(document).on("click", ".btn-view", function(e){
			
			var batchData = JSON.stringify({
				id: jQuery(this).attr('batchId')
			});
			
		});
		
		
    } // end of head/batch
});
</script>
