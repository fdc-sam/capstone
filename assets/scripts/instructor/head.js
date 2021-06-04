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
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 4 }
        ],
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
        "searching": true,
        "responsive" : true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 7 }
        ],
        "processing" : true,
        "serverSide" : true,
        "ordering" : false,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getAllProposal`,
          "type" : "POST"
        },
        "columns" : [
            {"data": "id"},
            {
                "data": "thesis_group_name",
                "render": function(data, type, row, meta){
                    return  `
                        <a href="${base_url}instructor/panel/groupDetails/${row.thesisGroupId}">
                            ${data}
                        </a>
                    `;
                }
            },
            {"data": "groupPoposals"},
            {
                "data": "assignedFlag",
                "render": function(data, type, row, meta){
                    if (data) {
                        return  `
                            <a href="${base_url}instructor/head/titleHearingDetails/${row.thesisGroupId}" class="badge badge-success mb-2 mr-2 btn  btn-sm">
                                Pannelist Assigned
                            </a>
                            `;
                    }else {
                        return  `<div class="mb-2 mr-2 badge badge-danger">No Pannelist Assigne</div>`;
                    }
                }
            },
            {"data": "chairman"},
            {"data": "scoreStatus"},
            {"data": "proposalCreated"},
            {"data": "proposalModified"},
            {
                "data": 'id',
                "render": function(data, type, row, meta){
                    var btnReturn = '';

                    if (row.assigned_panelist_flag == 1) {
                        // start bell button
                        btnReturn += `
                            <a href="${base_url}instructor/head/teamProposal/${row.thesisGroupId}"
                                class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-secondary"
                                activation="Deactivated"
                                data-toggle="tooltip" data-placement="top" title="View Panelist Status">
                                <i class="lnr lnr-alarm btn-icon-wrapper"> </i>
                        `;
                        if (row.countPanelistRejectTheGroup >= 1) {
                            btnReturn += `<span class="badge badge-pill badge-danger">${row.countPanelistRejectTheGroup}</span>`;
                        }

                        btnReturn += `
                            </a>
                        `;
                        // end bell button

                        btnReturn += `
                            <a href="${base_url}instructor/head/titleHearingEdit/${row.thesisGroupId}"
                                class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                activation="Deactivated"
                                data-toggle="tooltip" data-placement="top" title="Add Panelist">
                                <i class="lnr-users btn-icon-wrapper"> </i>
                            </a>
                        `;
                    }else{
                        btnReturn += `
                            <a href="${base_url}instructor/head/titleHearingEdit/${row.thesisGroupId}"
                                class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                activation="Deactivated"
                                data-toggle="tooltip" data-placement="top" title="Add Panelist">
                                <i class="lnr-users btn-icon-wrapper"> </i>
                            </a>
                        `;
                    }

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

if (sub_content == 'head/assignPanelist') {

    // initialize select2
    var panelist = $("#panelist").select2({
        tags: "true",
        theme:"bootstrap4",
        placeholder: "Panelist here..."
    });

    $('#assignPanelist').on('click', function(e){
        e.preventDefault();
        var instructorIds = $("#panelist").val();
        var thesisGroupId = $("#thesisGroupId").val();

        $.ajax({
            url:`${base_url}instructor/head/assignPanelistToGroup`,
            type:'post',
            dataType:'json',
            data:{
                instructorIds:instructorIds,
                thesisGroupId:thesisGroupId
            },
            beforeSend: function() {
                $('#loadingState').show();
            },
            success:function(data){
                if (!data.error) {
                    var alertClass = `alert-success`;
                    var alertMessege = `Group member has successfully <b>Added</b>`;
                    panelist.val(null).trigger("change");
                }else if(data.error && data.messsage == "panelist lessthan 3"){
                    var alertClass = `alert-warning`;
                    var alertMessege = `Panelist must have 3 or more`;
                }else {
                    var alertClass = `alert-warning`;
                    var alertMessege = `Group member was not Added`;
                }

                $('#message').html(`
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
                $('#message').html(`
                    <div class="alert alert-dismissible fade show alert-danger" role="alert">
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                        Member was not Added
                    </div>`
                );
            },
            complete: function(){
                $('#loadingState').hide();
            }
        })
    });
}

if (sub_content == 'head/proposalDetails') {

    $(document).on('click','.btn-rejectProsalByHead', function(e){
        e.preventDefault();
        var thesisId = $(this).attr('thesisId');
        var groupid = $(this).attr('groupid');
        window.location.replace(`${base_url}instructor/head/rejectProsalByHead/${thesisId}/${groupid}`);
    })
}

if (sub_content == 'head/teamProposal') {
    var getProposalDetails = $('#getProposalDetails').DataTable({
        "searching": false,
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/instructor/head/getGroupPanelist`,
          "data":{thesisGroupId:thesisGroupId},
          "type" : "POST"
        },
        "columns" : [
            {"data": "id"},
            {"data": "panelistFullName"},
            {
                "data": 'status',
                "render": function(data, type, row, meta){
                    var badge = '';
                    if (row.approvedFlag && data == 1) {
                        badge = `<div class="badge badge-success ml-2">Approved</div>`;
                    }else  {
                        if (row.approvedFlag) {
                            badge = `<a href="asdasd"><div class="badge badge-danger ml-2">Rejected</div></a>`;
                        }else{
                            if (data == 0) {
                                badge = `<div class="badge badge-warning ml-2">Pending</div>`;
                            }else if (data == 1) {
                                badge = `<div class="badge badge-success ml-2">Confirmed</div>`;
                            }else if (data == 2) {
                                badge = `<a href="${base_url}instructor/head/panelistReject/${row.id}" class="badge badge-danger ml-2 btn-shadow btn-danger btn-sm">
                                        Rejected
                                    </a>`;
                            }
                        }
                    }
                    return badge;
                }
            },
            {
                "data": "id",
                "render": function(data, type, row, meta){
                    return `
                        <a href="${base_url}instructor/head/viewPanelEvaluationRubric/${thesisGroupId}/${row.panelist_id}" class="mb-2 mr-2 btn-shadow btn-icon btn btn-sm btn-primary">
                            <i class="fa fa-eye btn-icon-wrapper"> </i>
                            View Evaluation
                        </a>
                    `;
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

if (sub_content == 'head/assignPanel') {
    $(document).ready(function(){
        // get all instructor
        $('.select2-panelist').select2({
            tags: "true",
            theme:"bootstrap4",
            placeholder: 'Select an item',
            ajax: {
                url: `${base_url}instructor/head/getAllInstructorSelect2`,
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                },
                cache: true
            }
        });

        // get all Groups
        $('.select2-group').select2({
            createTag: function () {
                // Disable tagging
                return null;
            },
            tags: "true",
            theme:"bootstrap4",
            placeholder: 'Select Group',
            ajax: {
                url: `${base_url}instructor/head/getAllGroupsSelect2`,
                dataType: 'json',
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    console.log(response);
                    return {
                        results:response
                    };

                },
                cache: true
            }
        });

        //
        $('.select2-group').on('change', function(){
            var groupId = $('.select2-group').val();
            // console.log(`groupID: ${data}`);
            $.ajax({
                url:`${base_url}/instructor/head/getThisesProposal`,
                type:'post',
                dataType:'json',
                data:{groupId:groupId},
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success:function(data){
                    if (!data.error_flag) {
                        // console.log(data);
                        $('.proposalTitles').html(data.messsage);
                    }
                },
                error: function(xhr, status, error){
                },
                complete: function(){
                    $('#loadingState').hide();
                }
            });
        });

        // max limit of proposal
        var maxFields = 5;
        var x = 1;
        // add propose
        $(document).on('click','.addMoreProjectHearing',function(e) {
            e.preventDefault();
            // count of proposal

            var panelist = $('#panelist').val();
            var proposalTitles = $('#proposalTitles').html();
            var groupName = $('#groupName').val();
            var hearingDateTime = $('#hearingDateTime').val();
            var parsedDate = moment(hearingDateTime,"YYYY-MM-DD H m s");


            // foreach the id
            var panelistObj = new Object();
            panelist.forEach(myFunction);
            function myFunction(item, index) {
                panelistObj[index] = item;
            }
            var panelistPost = JSON.stringify(panelistObj);


            if ( panelist.length == 0 || !proposalTitles || !groupName || !hearingDateTime) {
                alert('Please Fill all Fields');
                return;
            }

            // font end
            var groupNameFont = $(".select2-group option:selected").text();
            var panelistNames = '';
            $("#panelist option:selected").each(function () {
                var $this = $(this);

                if ($this.length == 0) {
                    alert('Please Fill all Fields');
                    return;
                }
                if ($this.length) {
                    panelistNames += `<span style="font-family: 'Arial'; font-size: 12pt; font-weight: bold;">${$this.text()},</span>`;
                }
            });

            var fontEndHearingDateTime = parsedDate.format("MMMM DD, YYYY  (hh:mm A)");
            console.log(fontEndHearingDateTime);
            $('#hearingDateTimeDis').html(fontEndHearingDateTime);
            $('#hearingDateTimePost').val(parsedDate.format("YYYY-MM-DD HH:MM:SS"));

            // var date = new Date(`${hearingTime}`).toLocaleString('en-us',{month:'long', year:'numeric', day:'numeric'});
            // console.log(date);
            // return;
            if (x < maxFields) {
                var output = `<div class="table-wrapper">
                    <button class="btn btn-danger removeProjectHearing" style="float: right;">Remove</button>
                    <table class="TableGrid">
                        <tr>
                            <td style="width: 15%;">
                                <p style="text-align: center;">
                                    <span style="font-family: 'Arial'; font-size: 12pt; font-weight: bold;">TEAM </span>
                                </p>
                            </td>
                            <td>
                                <p style="text-align: center;">
                                    <span style="font-family: 'Arial'; font-size: 12pt; font-weight: bold;">PROPOSED TITLES </span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align: center;">
                                    <span style="font-family: 'Arial'; font-size: 12pt;"> ${groupNameFont}</span>
                                    <input type="hidden" name="groupNamePost[]" value="${groupName}">
                                </p>
                            </td>
                            <td>
                                <ul>
                                    ${proposalTitles}
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="text-align: right;">
                                    <span style="font-family: 'Arial'; font-size: 12pt; font-weight: bold;">Panel: </span>
                                </p>
                            </td>
                            <td>
                                <p>
                                    ${panelistNames}
                                    <textarea hidden name="panelistPost[]">${panelistPost}</textarea>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <p>&nbsp;</p>
                </div>`;

                if (x == 1) {
                    $('.tableContainer').html(`${output}`); //add input box
                }else{
                    $('.tableContainer').append(`${output}`); //add input box
                }
                x++;
            } else {
                alert('You Reached the limits')
            }

            // $('#countAvailableProposalLeft').html(x);
        });

        $(document).on("click", ".removeProjectHearing", function(e) {
            e.preventDefault();
            $(this).parents('.table-wrapper').remove();
            x--;
            if (x == 1) {
                $('.tableContainer').html(`
                    <div style="text-align:center;">
                        <h4>Please Add Project Hearing</h4>
                    </div>`
                );
            }
            // $('#countAvailableProposalLeft').html(x);
        });


        $('.btn-submit').on('click', function(){

            // hearing date
            var hearingDateTimePost = $('#hearingDateTimePost').val();

            // groupid
            var groupNamePost = $('input[name="groupNamePost[]"]').map(function(){
                return this.value;
            }).get();

            // panelist json form
            var panelistPost = $('textarea[name="panelistPost[]"]').map(function(){
                return this.value;
            }).get();

            if (panelistPost.length == 0) {
                $('#message').html(`
                    <div class="alert alert-dismissible fade show alert-warning" role="alert">
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                        Please Add  Project
                    </div>
                `);
            }

            $.ajax({
                url:`${base_url}/instructor/head/addProjectHearingSched`,
                type:'post',
                dataType:'json',
                data:{
                    groupId:groupNamePost,
                    panelistId:panelistPost,
                    hearingDateTime:hearingDateTimePost,
                    editFlag:1
                },
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success: function(data){
                    $('#loadingState').hide();
                    if (!data.errorFlag && data.message != "panelist lessthan 3") {
                        var alertClass = `alert-success`;
                        var alertMessege = `Data successfully <b>Saved</b>`;
                    }else if(data.errorFlag && data.message == "panelist lessthan 3"){
                        var alertClass = `alert-warning`;
                        var alertMessege = `Panelist must have 3 or more`;
                    }else{
                        var alertClass = `alert-warning`;
                        var alertMessege = `Error Data not save`;
                    }
                    console.log(data);
                    $('#message').html(`
                        <div class="alert alert-dismissible fade show ${alertClass}" role="alert">
                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                <span aria-hidden="true">×</span>
                            </button>
                            ${alertMessege}
                        </div>`
                    );
                },
                complete: function(){
                    $('#loadingState').hide();
                }
            });
        });
    }); // doncument ready end

}


if (sub_content == 'head/titleHearingEdit') {
    $(document).ready(function(){
        // get all instructor

        $('.select2-panelist').select2({
            tags: true,
            theme:"bootstrap4",
            placeholder: 'Select an item',
            multiple: true,
            ajax: {
                url: `${base_url}instructor/head/getAllInstructorSelect2`,
                dataType: 'json',
                delay: 250,
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results:response
                    };
                }
            }
        });

        // / Fetch the preselected item, and add to the control
        var panelistSelect = $('.select2-panelist');
        $.ajax({
            type: 'GET',
            url: `${base_url}instructor/head/titleHearingEdit/${groupId}`,
        }).then(function (data) {
            // create the option and append to Select2
            data1 = JSON.parse(data);
            data1.forEach(myFunction);
            function myFunction(item, index) {
                var option = new Option(item.text, item.id, true, true);
                panelistSelect.append(option).trigger('change');
                // manually trigger the `select2:select` event
                panelistSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            }
        });



        // get all Groups
        $('.select2-group').select2({
            createTag: function () {
                // Disable tagging
                return null;
            },
            tags: "true",
            theme:"bootstrap4",
            placeholder: 'Select Group',
            ajax: {
                url: `${base_url}instructor/head/getAllGroupsSelect2`,
                dataType: 'json',
                data: function (data) {
                    return {
                        searchTerm: data.term // search term
                    };
                },
                processResults: function (response) {
                    console.log(response);
                    return {
                        results:response
                    };

                },
                cache: true
            }
        });

        //
        $('.select2-group').on('change', function(){
            var groupId = $('.select2-group').val();
            // console.log(`groupID: ${data}`);
            $.ajax({
                url:`${base_url}/instructor/head/getThisesProposal`,
                type:'post',
                dataType:'json',
                data:{groupId:groupId},
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success:function(data){
                    if (!data.error_flag) {
                        // console.log(data);
                        $('.proposalTitles').html(data.messsage);
                    }
                },
                error: function(xhr, status, error){
                },
                complete: function(){
                    $('#loadingState').hide();
                }
            });
        });

        $('#hearingDateTime').on('change',function(){
            var hearingDateTime = $('#hearingDateTime').val();
            console.log(hearingDateTime);
        });

        $('#updatePanelist').on('click', function(){
            console.log();
            console.log();

            // for date
            var hearingDateTime = $('#hearingDateTime').val();
            var parsedDate = moment(hearingDateTime,"YYYY-MM-DD H m s");


            var groupNamePost = $('#groupName').val();
            var panelistPost = $('#panelist').val();
            var hearingDateTimePost = parsedDate.format("YYYY-MM-DD HH:MM:SS");

            if (panelistPost.length == 0) {
                $('#message').html(`
                    <div class="alert alert-dismissible fade show alert-warning" role="alert">
                        <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                        Please Add  Project
                    </div>
                `);
            }

            $.ajax({
                url:`${base_url}/instructor/head/addProjectHearingSched`,
                type:'post',
                dataType:'json',
                data:{
                    groupId:groupNamePost,
                    panelistId:panelistPost,
                    hearingDateTime:hearingDateTimePost,
                    editFlag:1
                },
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success: function(data){
                    $('#loadingState').hide();
                    if (!data.errorFlag) {
                        var alertClass = `alert-success`;
                        var alertMessege = `Data successfully <b>Saved</b>`;
                    }else if(data.errorFlag && data.message == "panelist lessthan 3"){
                        var alertClass = `alert-warning`;
                        var alertMessege = `Panelist must have 3 or more`;
                    }else{
                        var alertClass = `alert-warning`;
                        var alertMessege = `Error Data not save`;
                    }
                    $('#message').html(`
                        <div class="alert alert-dismissible fade show ${alertClass}" role="alert">
                            <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                                <span aria-hidden="true">×</span>
                            </button>
                            ${alertMessege}
                        </div>`
                    );
                },
                complete: function(){
                    $('#loadingState').hide();
                }
            });

            console.log("here"+groupNamePost);
        });
    }); // doncument ready end
}

if (sub_content == 'head/viewEvaluationRubric') {
    var tableGroupDetails = $('#table-viewEvaluationRubric').DataTable({
        "responsive" : true,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 6 }
        ],
    });// end of the data table variable
}

if (sub_content == 'head/viewPanelEvaluationRubric') {
    var tableGroupDetails = $('#table-viewPanelEvaluationRubric').DataTable({
        "responsive" : true,
        "ordering": false,
        "paging": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 6 }
        ],
    });// end of the data table variable
}

if (sub_content == 'head/student') {
    var tableGroupDetails = $('#table-student').DataTable({
        "responsive" : true,
        "searching": false,
        "ordering": false,
        // "paging": false,
        "columnDefs": [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 1, targets: 1 }
        ],
    });// end of the data table variable

    $(document).on('change', '#searchDate', function(){
        var searctDate = $('#searchDate').val();
        window.location.replace(`${base_url}instructor/head/student?searctDate=${searctDate}`);
    });
}
