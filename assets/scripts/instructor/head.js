if (sub_content == 'head/batch') {
    // this line of code is for the textarea design ang functionalities
    CKEDITOR.replace('batch_description');
    // insert batch data
    $('#batch_form').on('submit', function(e){
        e.preventDefault();
        // get the CKEDITOR textarea value
        for ( batch_description in CKEDITOR.instances )
        var batch_description = CKEDITOR.instances[batch_description].getData();
        // CKEDITOR.instances[batch_description].updateElement();
        console.log(batch_description);
        return;
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
                        return `<div class="badge badge-primary ml-2">Active</div>`;
                    }else{
                        return `<div class="badge badge-danger ml-2">Deactivate</div>`;
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
                        <a href="${base_url}instructor/head/viewStudent/${row.code}" class="btn-view btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-secondary"  batchId="${data}" data-toggle="tooltip" data-placement="top" title="View">
                            <i class="lnr-eye btn-icon-wrapper"> </i>
                        </a>
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
}


if (sub_content == 'head/viewStudent') {
    
    var viewStudentBatchDataTable = $('#viewStudentBatchDataTable').DataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
            "url" : `${base_url}/instructor/head/getBatchStudent`,
            "type" : "POST",
            "data": {batchCode:batchCode}
        },
        "columns" : [
            {
                "data": "id",
                "render": function(data, type, row, meta){
                    return `${row.first_name} ${row.middle_name} ${row.last_name}`;
                }
            },
            {"data": "email"}, 
            {
                "data": "gender",
                "render": function(data, type, row, meta){
                    if (data) {
                        return `Male`;
                    }else{
                        return `Female`;
                    }
                }
            },
            {
                "data": "activation_selector",
                "render": function(data, type, row, meta){
                    if (data == null) {
                        return `<div class="badge badge-danger ml-2">Deactivated</div>`;
                    }else if(data == 'Activated'){
                        return `<div class="badge badge-primary ml-2">Active</div>`;
                    }
                }
            },
        ]
    });// end of the data table variable
}


if (sub_content == 'head/index') {
    
    var instaructorDataTable = $('#getAllInstructor').DataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getAllInstructor`,
          "type" : "POST"
        },
        "columns" : [
            {
                "data": "id",
                "render": function(data, type, row, meta){
                    return `${row.first_name} ${row.middle_name} ${row.last_name}`;
                }
            }, 
            {
                "data": "gender",
                "render": function(data, type, row, meta){
                    if (data == 1) {
                        return `Male`;
                    }else{
                        return `Female`;
                    }
                }
            },
            {"data": "email"},
            {
                "data": "activation_selector",
                "render": function(data, type, row, meta){
                    if (data == null) {
                        return `Required Activation`;
                    }else if(data == 'Activated'){
                        return `Activated`;
                    }else if(data == 'Deactivated'){
                        return `Deactivated`;
                    }
                }
            },
            {
                "data": 'id',
                "render": function(data, type, row, meta){
                    var btnReturn = '';
                    if (row.activation_selector == 'Activated' ) {
                        // batch status to deactivate
                        btnReturn += `
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" activation="Deactivated"  userId="${data}" data-toggle="tooltip" data-placement="top" title="Deactivate">
                                <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                            </button>
                        `;
                    }else{
                        // batch status to active
                        btnReturn +=  `
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" activation="Activated"  userId="${data}" data-toggle="tooltip" data-placement="top" title="Activate">
                                <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                            </button>
                        `;
                    }
                    return btnReturn;
                                        
                }
            }
        ]
    });// end of the data table variable
    
    
    $(document).on('click','.btn-changeStatus', function(){
        var activation = $(this).attr('activation');
        var userId = $(this).attr('userId');
        Swal.fire({
            title: 'Are you sure?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`${base_url}/instructor/head/changeStatus`,
                    type:'post',
                    dataType:'json',
                    data:{activation:activation,userId:userId},
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success: function(data){
                        console.log(data);
                        Swal.fire(
                            'INFO!',
                            'User data has been Updated',
                            'success'
                        )
                    },
                    complete: function(){
                        $('#loadingState').hide();
                        instaructorDataTable.ajax.reload();
                    }
                });
            }
        })
    });
}

if (sub_content == 'head/proposal') {
    var instaructorDataTable = $('#getAllProposal').DataTable({
        "searching": false,
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getAllProposal`,
          "type" : "POST"
        },
        "columns" : [
            {"data": "id"}, 
            {"data": "thesis_group_name"},
            {"data": "groupPoposals"},
            {"data": "groupMembers"},
            {"data": "proposalCreated"},
            {"data": "proposalModified"},
            {
                "data": 'id',
                "render": function(data, type, row, meta){
                    var btnReturn = '';
                    // btnReturn += `
                    //     <a href="${base_url}/instructor/head/teamProposal/${row.thesisGroupId}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" activation="Deactivated" data-toggle="tooltip" data-placement="top" title="View Proposal(s)">
                    //         <i class="lnr-eye btn-icon-wrapper"> </i>
                    //     </a>
                    // `;
                    btnReturn += `
                        <a href="${base_url}instructor/head/proposalDetails/${row.thesisGroupId}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" activation="Deactivated" data-toggle="tooltip" data-placement="top" title="View Proposal(s)">
                            <i class="lnr-eye btn-icon-wrapper"> </i>
                        </a>
                    `;
                    return btnReturn;
                                        
                }
            }
        ]
    });// end of the data table variable
}

// if (sub_content == 'head/proposalDetails') {
//     $.ajax({
//         url:`${base_url}instructor/head/getProposalDetails`,
//         type:'post',
//         dataType:'json',
//         data:{
//             thesisGroupId:thesisGroupId
//         },
//         beforeSend: function() {
//             $('#loadingState').show();
//         },
//         success: function(data){
//             console.log(data);
//             Swal.fire(
//                 'INFO!',
//                 'User data has been Updated',
//                 'success'
//             )
//         },
//         complete: function(){
//             $('#loadingState').hide();
//             getProposalDetails.ajax.reload();
//         }
//     });
// }

if (sub_content == 'head/teamProposal') {
    var getProposalDetails = $('#getProposalDetails').DataTable({
        "searching": false,
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getProposalDetails`,
          "data":{thesisGroupId:thesisGroupId},
          "type" : "POST"
        },
        "columns" : [
            {"data": "id"}, 
            {"data": "title"},
            {"data": "discreption"},
            {"data": "created"},
            {"data": "modified"},
            {
                "data": 'status',
                "render": function(data, type, row, meta){
                    var badge = '';
                    if (row.approvedFlag && data == 1) {
                        badge = `<div class="badge badge-success ml-2">Approved</div>`;
                    }else  {
                        if (row.approvedFlag) {
                            badge = `<div class="badge badge-danger ml-2">Rejected</div>`;
                        }else{
                            if (data == 0) {
                                badge = `<div class="badge badge-warning ml-2">Pending</div>`;
                            }else if (data == 1) {
                                badge = `<div class="badge badge-success ml-2">Approved</div>`;
                            }else if (data == 2) {
                                badge = `<div class="badge badge-danger ml-2">Rejected</div>`;
                            }
                        }
                        
                    }
                    
                    return badge;
                                        
                }
            },
            {
                "data": 'status',
                "render": function(data, type, row, meta){
                    var btnReturn = '';
                    if (data == 1) {
                        var chagneStat = `Reject`;
                        var btnStat = `btn-outline-danger`;
                    }else if (data == 2) {
                        var chagneStat = `Approve`;
                        var btnStat = `btn-outline-primary`;
                    }
                    
                    if (row.approvedFlag && data == 1) {
                        btnReturn = `
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" proposalId="${row.id}" activation="Reject" data-toggle="tooltip" data-placement="top" title="Reject">
                                <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                            </button>
                        `;
                    }else if(!row.approvedFlag && data == 0){
                        btnReturn = `
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" proposalId="${row.id}" activation="Approve" data-toggle="tooltip" data-placement="top" title="Approve">
                                <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                            </button>
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" proposalId="${row.id}" activation="Reject" data-toggle="tooltip" data-placement="top" title="Reject">
                                <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                            </button>
                        `;
                    }else if(!row.approvedFlag &&  data == 2){
                        btnReturn = `
                            <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" proposalId="${row.id}" activation="Approve" data-toggle="tooltip" data-placement="top" title="Approve">
                                <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                            </button>
                        `;
                    }
                    
                    btnReturn += `
                        <button class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" proposalId="${row.id}"  data-toggle="tooltip" data-placement="top" title="View">
                            <i class="lnr-eye btn-icon-wrapper"> </i>
                        </button>
                    `;
                    
                    return btnReturn;
                                        
                }
            }
        ]
    });// end of the data table variable
    
    $(document).on('click','.btn-changeStatus', function(){
        var activation = $(this).attr('activation');
        var proposalId = $(this).attr('proposalId');
        Swal.fire({
            title: 'Are you sure?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`${base_url}/instructor/head/thesisChangeStatus`,
                    type:'post',
                    dataType:'json',
                    data:{
                        activation:activation,
                        proposalId:proposalId
                    },
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success: function(data){
                        console.log(data);
                        Swal.fire(
                            'INFO!',
                            'User data has been Updated',
                            'success'
                        )
                    },
                    complete: function(){
                        $('#loadingState').hide();
                        getProposalDetails.ajax.reload();
                    }
                });
            }
        })
    });
}


if (sub_content == 'head/groups') {
    var instaructorDataTable = $('#getAllGroups').DataTable({
        "searching": true,
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        // "paging": false,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getAllGroups`,
          "type" : "POST"
        },
        "columns" : [
            {"data": "id"}, 
            {"data": "discreption"},
            {"data": "title"},
            {"data": "members"},
            {
                "data": 'id',
                "render": function(data, type, row, meta){
                    var btnReturn = '';
                    btnReturn += `
                        <button 
                            data-toggle="modal" data-target="#addAdviserModal"
                            class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" 
                            activation="Deactivated" data-toggle="tooltip" 
                            data-placement="top" 
                            title="Assign Adviser"
                        >
                            <i class="fa fa-audio-description" aria-hidden="true"></i>
                        </button>
                    `;
                    return btnReturn;
                                        
                }
            }
        ]
    });// end of the data table variable
}
