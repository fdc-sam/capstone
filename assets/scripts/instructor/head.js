// this line of code is for the textarea design ang functionalities
CKEDITOR.replace('batch_description');

// insert batch data
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
    // "columnDefs": [
    //     {
    //         "targets": [ ], //first column / numbering column
    //         "orderable": false, //set not orderable
    //     },
    //     // { targets: 5 , class: 'text-center'}
    //     // { targets: 5 , class: 'text-center'},
    // ],
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
            "data": "count"
        },
        {
            "data": 'id',
            "render": function(data, type, row, meta){
                var btnReturn = '';
                if (row.status == 1 ) {
                    // batch status to deactivate
                    btnReturn += `
                        <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger"  batchId="${data}" batchStatus="${row.status}" data-toggle="tooltip" data-placement="top" title="Deactivate">
                            <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                        </button>
                    `;
                }else{
                    // batch status to active
                    btnReturn +=  `
                        <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"  batchId="${data}"  batchStatus="${row.status}" data-toggle="tooltip" data-placement="top" title="Activate">
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

// run the getBatchData()
// getBatchData();

// edit
$(document).on("click", ".btn-edit", function(e){
    
    var batchData = JSON.stringify({
        id: jQuery(this).attr('batchId')
    });
    console.log(batchData);
});

// activate
$(document).on("click", ".btn-changeStatus", function(e){
    
    var batchStatus = jQuery(this).attr('batchStatus');
    var batchData = {id:jQuery(this).attr('batchId'), batchStatus:batchStatus };
    // console.log(batchStatus);
    if (batchStatus == 1) {
        // to deactivate
        var batchMessageTitle = 'Are you sure you want to Deactivate?';
        var batchMessageText = 'Please be advise the if you do this, the batch will not be seen by the student registered to this batch';
        var batchBtnText = 'Yes, Deactivate it!';
    }else{
        // to active
        var batchMessageTitle = 'Are you sure you want to Activate?';
        var batchMessageText = 'Please be advise the if you do this, the batch will be seen by the student registered to this batch';
        var batchBtnText = 'Yes, Activate it!';
    }
    
    Swal.fire({
        title: batchMessageTitle,
        text: batchMessageText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: batchBtnText
    }).then((result) => {
        if (result.isConfirmed) {
            changeBatchStatus(batchData);
        }
    })
    
    function changeBatchStatus(batchData) {
        $.ajax({
            url:`${base_url}/instructor/head/changeBatchStatus`,
            type:'post',
            dataType:'json',
            data:batchData,
            beforeSend: function() {
                $('#loadingState').show();
            },
            success:function(data){
                // if (!data.error) {
                //     var alertClass = `alert-success`;
                //     var alertMessege = `Batch has successfully <b>Created</b>`;
                // }else{
                //     var alertClass = `alert-warning`;
                //     var alertMessege = `Batch was not created`;
                // }
                // 
                // $('#alertMessege').html(`
                //     <div class="alert alert-dismissible fade show ${alertClass}" role="alert">
                //         <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                //             <span aria-hidden="true">×</span>
                //         </button>
                //         ${alertMessege}
                //     </div>`
                // );
                batchDataTable.ajax.reload();
                console.log(batchData);
                
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
    }
    
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