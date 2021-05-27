if (sub_content == 'home/index') {
    $(document).ready(function(){

        // this line of code is for the textarea design ang functionalities
        CKEDITOR.replace('description');
        CKEDITOR.replace(`limitations`);
        CKEDITOR.replace(`designDevelopmentPlan`);

        // initialize select2
        var groupMemberMultiSelect = $("#groupMember").select2({
            tags: "true",
            theme:"bootstrap4",
            placeholder: "Member's"
        });

        $(document).on('click', '#btnGroupSave', function(){

            var groupMemberId = $('#groupMember').val();

            if (groupMemberId == "") {
                console.log('empty');
            }else{
                $.ajax({
                    url:`${base_url}/student/home/addGroupMember`,
                    type:'post',
                    dataType:'json',
                    data:{groupMemberId:groupMemberId},
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success:function(data){
                        if (!data.error) {
                            var alertClass = `alert-success`;
                            var alertMessege = `Group member has successfully <b>Added</b>`;
                            groupMemberMultiSelect.val(null).trigger("change");
                        }else{
                            var alertClass = `alert-warning`;
                            var alertMessege = `Group member was not Added`;
                        }

                        $('#alertMessageModal').html(`
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
                        $('#alertMessageModal').html(`
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
                        batchDataTable.ajax.reload();
                    }
                })
            }
        });


        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        async function demo() {
            console.log('Taking a break...');
            await sleep(2000);

            //
            console.log('Two seconds later, showing sleep in a loop...');
        }

    });

    function countAvailableProposalLeft(){
        $.ajax({
            url:`${base_url}/student/home/countAvailableProposalLeft`,
            dataType:'json',
            success: function(data){
                var count = data.count;
                $('#countAvailableProposalLeft').html(count);
                $('#proposals').html(data.data);
            }
        });
    }
    countAvailableProposalLeft();

    // max limit of proposal
    var maxFields = 5;

    var x = parseInt($('#countAvailableProposalLeft').html());
    // add propose
    $(document).on('click','.addMoreProposal',function(e) {
        e.preventDefault();
        // count of proposal
        x = parseInt($('#countAvailableProposalLeft').html());
        console.log(x); // show response from the php script.
        if (x < maxFields) {
            x++;
            $('.modalContainer').append(`
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <div class="btn-actions-pane-right actions-icon-btn">
                            <button type="button" class="close removeProposal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="" class=""> PROJECT TITLE</label>
                                    <input name="title[]" id="" placeholder="" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="" class=""> SCOPE OF THE STUDY</label>
                                    <textarea rows="1" name="description[]" id="description${x}" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="" class=""> LIMITATIONS OF THE STUDY</label>
                                    <textarea rows="1" name="limitations[]" id="limitations${x}" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="" class=""> PROJECT DESIGN DEVELOPMENT PLAN</label>
                                    <textarea rows="1" name="designDevelopmentPlan[]" id="designDevelopmentPlan${x}" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `); //add input box
            CKEDITOR.replace(`description${x}`);
            CKEDITOR.replace(`limitations${x}`);
            CKEDITOR.replace(`designDevelopmentPlan${x}`);
        } else {
            alert('You Reached the limits')
        }
        $('#countAvailableProposalLeft').html(x);
    });

    $(document).on("click", ".removeProposal", function(e) {
        e.preventDefault();
        $(this).parents('.card').remove();
        x--;
        $('#countAvailableProposalLeft').html(x);
    });

    // submit proposal
    $(document).on("submit", "#proposeForm", function(e) {
        e.preventDefault();

        // get the CKEDITOR textarea value


        if ( parseInt($('#countAvailableProposalLeft').html()) >=5 ) {
            alert('You Reached Your Proposal Limit of 5');
            return;
        }

        // get the array inputs og titles
        var proposeTitles = $('input[name="title[]"]').map(function(){
            return this.value;
        }).get();

        var proposeDescription = $('textarea[name="description[]"]').map(function(){
            return this.value;
        }).get();

        var proposeLimitations = $('textarea[name="limitations[]"]').map(function(){
            return this.value;
        }).get();

        var proposeDesignDevelopmentPlan = $('textarea[name="designDevelopmentPlan[]"]').map(function(){
            return this.value;
        }).get();

        $.ajax({
            url:`${base_url}/student/home/addPropose`,
            type:'post',
            dataType:'json',
            data:{
                titles:proposeTitles,
                descriptions:proposeDescription,
                limitations:proposeLimitations,
                designDevelopmentPlan:proposeDesignDevelopmentPlan
            },
            beforeSend: function() {
                $('#loadingState').show();
            },
            success: function(data){
                console.log(data);
                $('#proposeForm')[0].reset();
            },
            complete: function(){
                $('#loadingState').hide();
                countAvailableProposalLeft();
            }
        });

    });

    $(document).on('click','.deletePropossal', function(){
        var thesisId = $(this).attr('thisesId');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`${base_url}/student/home/deletePropossal`,
                    type:'post',
                    dataType:'json',
                    data:{id:thesisId},
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success: function(data){
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    complete: function(){
                        $('#loadingState').hide();
                        countAvailableProposalLeft();
                    }
                });
            }
        })

    });


    //teacher view
    var batchDataTable = $('#dataTableGroupMembers').DataTable({
        "responsive" : true,
        "processing" : true,
        "serverSide" : true,
        "order": [[0,'asc']],
        "ajax" : {
          "url" : `${base_url}/student/home/getGroupMembers`,
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
            {"data": "id"},
            {
                "data": "first_name",
                "render": function(data, type, row, meta){
                    var fullName = `${row.first_name} ${row.middle_name} ${row.last_name}`;
                    return fullName;
                }
            },
            {"data": "email"},
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
            {"data": "role_name"},
            {
                "data": 'id',
                "render": function(data, type, row, meta){
                    var btnReturn = '';
                    btnReturn += `
                        <button class="border-0 btn-transition btn btn-outline-danger deleteGroupMember" user_id="${row.user_id}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    `;
                    return btnReturn;

                }
            }
        ]
    });// end of the data table variable

    $(document).on('click','.deleteGroupMember', function(){
        var user_id = $(this).attr('user_id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`${base_url}/student/home/deleteGroupMember`,
                    type:'post',
                    dataType:'json',
                    data:{user_id:user_id},
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success: function(data){
                        batchDataTable.ajax.reload();
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    complete: function(){
                        $('#loadingState').hide();
                        countAvailableProposalLeft();
                    }
                });
            }
        })

    });
}

if (sub_content == 'home/capstoneDetails') {

    // add documentation files
    $(document).on('click','.btnAddFiles', function(e){
        e.preventDefault();

        // to activate the clicl function of 'selectedFile'
        var selectedFile = $('#selectedFile').click();

        const fileSelector = document.getElementById('selectedFile');
        fileSelector.addEventListener('change', (event) => {
            const fileList = event.target.files;
            console.log(fileList);
            for (var i = 0, f; f = fileList[i]; i++) {
                console.log(escape(f.name));
                var fileName = escape(f.name);
                var fileExtention = fileName.split('.').pop();;
                console.log(fileExtention);

                if (fileExtention == 'pdf') {
                    var files = `
                        <li class="pt-2 pb-2 pr-2 list-group-item li-selectedFile">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-danger center-elem">
                                        <i class="fa fa-file-pdf"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">${fileName}</div>
                                    </div>
                                    <div class="widget-content-right">
                                        <button class="btn-icon mb-2 mr-2 btn btn-primary btn-link btn-sm saveFile">
                                            Save
                                        </button>
                                        <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger btnRemoveDocument">
                                            <i class="lnr-cross btn-icon-wrapper"> </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                }else if (fileExtention == 'docx') {
                    var files = `
                        <li class="pt-2 pb-2 pr-2 list-group-item li-selectedFile">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left opacity-6 fsize-2 mr-3 text-primary center-elem">
                                        <i class="fa fa-file-alt"></i>
                                    </div>
                                    <div class="widget-content-left">
                                        <div class="widget-heading font-weight-normal">${fileName}</div>
                                    </div>
                                    <div class="widget-content-right widget-content-actions">
                                        <button class="btn-icon mb-2 mr-2 btn btn-primary btn-link btn-sm saveFile">
                                            Save
                                        </button>
                                        <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger btnRemoveDocument">
                                            <i class="lnr-cross btn-icon-wrapper"> </i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                }
                $('.selectedFiles').append(files);
            }
        });
    });

    $(document).on('click', '.saveFile', function(e){
        $('.updloadFile').click();
    });

    // remove the selected File
    $(document).on('click', '.btnRemoveDocument', function(e){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been removed.',
                    'success'
                )
                $('.li-selectedFile').fadeOut(500);
                $('.form-document')[0].reset();
            }
        })
    });

    // delete the File
    $(document).on('click', '.btnDeleteDocument', function(e){
        e.preventDefault();
        var documentId = $(this).attr('documentId');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:`${base_url}/student/home/deleteDocument`,
                    type:'post',
                    // dataType:'json',
                    data:{documentId:documentId},
                    beforeSend: function() {
                        $('#loadingState').show();
                    },
                    success: function(data){
                        console.log(data);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    },
                    complete: function(){
                        $('#loadingState').fadeOut(500);
                        $(`.li-selectedFile${documentId}`).fadeOut(500);
                    }
                });

            }
        })
    });
}

if (sub_content == 'home/viewDocumentPDF') {
    console.log(base_url);
}
