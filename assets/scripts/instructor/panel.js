$(document).ready(function(){
    if (sub_content == 'panel/index') {
        var batchDataTable = $('#getAllAssignedCapstone').DataTable({
            'responsive': true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 4 }
            ],
            "processing" : true,
            "serverSide" : true,
            "order": [[0,'asc']],
            "ajax" : {
                "url" : `${base_url}/instructor/panel/getAllAssignedCapstone`,
                "type" : "POST"
            },
            "columns" : [
                {"data": "id"},
                {
                    "data": "groupName",
                    "render": function(data, type, row, meta){
                        return `<a  href="${base_url}instructor/panel/groupDetails/${row.group_id}">${data}</a>`
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta){
                        if (row.approvedFlag == 1) {
                            return `<div class="badge badge-primary ml-2">Title Already Approved</div>`;
                        }
                        if (data == 0) {
                            return `<div class="badge badge-warning ml-2">Pending</div>`;
                        }else if(data == 1){
                            return `<div class="badge badge-success ml-2">Accept</div>`;
                        }else{
                            return `<div class="badge badge-danger ml-2">Reject</div>`;
                        }
                    }
                },
                {"data": "hearing_date"},
                {
                    "data": 'id',
                    "render": function(data, type, row, meta){
                        var btnReturn = '';
                        if (row.status == 0 ) {
                            // pending buttons
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                            btnReturn +=  `
                                <a href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 1){
                            // reject button
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;

                            btnReturn +=  `
                                <a  href="${base_url}instructor/panel/viewProposal/${row.panelist_id}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr lnr-eye btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 2){
                            // accept button
                            btnReturn +=  `
                                <a  href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }

                        if (row.approvedFlag == 1) {
                            btnReturn =  `
                                <a  href="${base_url}instructor/panel/viewProposal/${row.panelist_id}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr lnr-eye btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }
                        return btnReturn;

                    }
                }
            ]
        });// end of the data table variable
    }




    if (sub_content == 'panel/projectTitleHearing') {
        var getProjectDetailsDatatable = $('#getProjectDetailsDatatable').DataTable({
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "order": [[0,'asc']],
            "ajax" : {
                "url" : `${base_url}/instructor/panel/getAllAssignedCapstone`,
                "type" : "POST"
            },
            "columns" : [
                {"data": "id"},
                {"data": "groupName"},
                {
                    "data": "status",
                    "render": function(data, type, row, meta){
                        if (data == 0) {
                            return `<div class="badge badge-warning ml-2">Pending</div>`;
                        }else if(data == 1){
                            return `<div class="badge badge-success ml-2">Accept</div>`;
                        }else{
                            return `<div class="badge badge-danger ml-2">Reject</div>`;
                        }
                    }
                },
                {"data": "hearing_date"},
                {
                    "data": 'id',
                    "render": function(data, type, row, meta){
                        var btnReturn = '';
                        if (row.status == 0 ) {
                            // pending buttons
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                            btnReturn +=  `
                                <a href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 1){
                            // reject button
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 2){
                            // accept button
                            btnReturn +=  `
                                <a  href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }
                        // btnReturn +=  `
                        //     <a href="${base_url}instructor/head/viewStudent/${row.code}" class="btn-view btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-secondary"  data-toggle="tooltip" data-placement="top" title="View">
                        //         <i class="lnr-eye btn-icon-wrapper"> </i>
                        //     </a>
                        // `;
                        return btnReturn;

                    }
                }
            ]
        });// end of the data table variable
    }

    if (sub_content == 'panel/viewProposal') {
        var getProposalDetailDatatable = $('#getProposalDetailDatatable').DataTable({
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "order": [[0,'asc']],
            "ajax" : {
                "url" : `${base_url}/instructor/panel/getProposalDetails`,
                "data" : {
                    groupId: groupId,
                    panelistId: panelistId
                },
                "type" : "POST"
            },
            "columns" : [
                {"data": "title"},
                {"data": "discreption"},
                {"data": "modified"},
                {
                    "data": "status",
                    "render": function(data, type, row, meta){
                        if (data == 0) {
                            return `<div class="badge badge-warning ml-2">Pending</div>`;
                        }else if(data == 1){
                            return `<div class="badge badge-success ml-2">Accept</div>`;
                        }else if(data == 2){
                            return `<div class="badge badge-danger ml-2">Reject</div>`;
                        }else{
                            return `<div class="badge badge-danger ml-2">Error</div>`;
                        }
                    }
                },
                {
                    "data": 'id',
                    "render": function(data, type, row, meta){
                        var btnReturn = '';
                        if (row.status == 0 ) {
                            // pending buttons
                            // reject button
                            btnReturn += `
                                <button href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.thesis_group_id}"
                                    class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    changeStatusFlag="2"
                                    thesisId="${row.thises_id}"
                                    thesisGroupId="${row.thesis_group_id}"
                                    title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </button>
                            `;

                            //  approved button
                            btnReturn +=  `
                                <button href="${base_url}instructor/panel/approvedTitle/${data}/${row.thesis_group_id}"
                                    class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    changeStatusFlag="1"
                                    thesisId="${row.thises_id}"
                                    thesisGroupId="${row.thesis_group_id}"
                                    title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </button>
                            `;
                        }else if(row.status == 1){
                            // reject button
                            btnReturn += `
                                <button href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.thesis_group_id}"
                                    class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    changeStatusFlag="2"
                                    thesisId="${row.thises_id}"
                                    thesisGroupId="${row.thesis_group_id}"
                                    title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </button>
                            `;
                        }else if(row.status == 2){
                            // approved button
                            btnReturn +=  `
                                <button  href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.thesis_group_id}"
                                    class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    changeStatusFlag="1"
                                    thesisId="${row.thises_id}"
                                    thesisGroupId="${row.thesis_group_id}"
                                    title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </button>
                            `;
                        }
                        return btnReturn;

                    }
                }
            ]
        });// end of the data table variable

        // chagneStat
        $(document).on('click', '.btn-changeStatus ', function(e){
            e.preventDefault();
            var changeStatusFlag = $(this).attr('changeStatusFlag');
            var thesisGroupId = $(this).attr('thesisGroupId');
            var thesisId = $(this).attr('thesisId');
            console.log(changeStatusFlag);
            $.ajax({
                url:`${base_url}/instructor/panel/thesisChangeStatus`,
                type:'post',
                dataType:'json',
                data:{
                    changeStatusFlag:changeStatusFlag,
                    thesisGroupId:thesisGroupId,
                    thesisId:thesisId,
                },
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success: function(data){
                    console.log(data);
                    if (!data.error) {
                        Swal.fire(
                            'INFO!',
                            'Updated',
                            'success'
                        )
                    }else{
                        Swal.fire(
                            'Error! ',
                            'Something went wrong',
                            'error'
                        )
                    }

                },
                complete: function(){
                    $('#loadingState').hide();
                    getProposalDetailDatatable.ajax.reload();
                }
            });
        })
    }


    if (sub_content == 'panel/projectTitleHearing') {
        var getProjectDetailsDatatable = $('#getProjectDetailsDatatable').DataTable({
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "order": [[0,'asc']],
            "ajax" : {
                "url" : `${base_url}/instructor/panel/getAllAssignedCapstone`,
                "type" : "POST"
            },
            "columns" : [
                {"data": "id"},
                {"data": "groupName"},
                {
                    "data": "status",
                    "render": function(data, type, row, meta){
                        if (data == 0) {
                            return `<div class="badge badge-warning ml-2">Pending</div>`;
                        }else if(data == 1){
                            return `<div class="badge badge-success ml-2">Accept</div>`;
                        }else{
                            return `<div class="badge badge-danger ml-2">Reject</div>`;
                        }
                    }
                },
                {"data": "hearing_date"},
                {
                    "data": 'id',
                    "render": function(data, type, row, meta){
                        var btnReturn = '';
                        if (row.status == 0 ) {
                            // pending buttons
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                            btnReturn +=  `
                                <a href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 1){
                            // reject button
                            btnReturn += `
                                <a href="${base_url}instructor/panel/assignedGroupReject/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Reject">
                                    <i class="lnr-cross-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }else if(row.status == 2){
                            // accept button
                            btnReturn +=  `
                                <a  href="${base_url}instructor/panel/assignedGroupAccept/${data}/${row.group_id}" class="btn-changeStatus btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary" data-toggle="tooltip" data-placement="top" title="Accept">
                                    <i class="lnr-checkmark-circle btn-icon-wrapper"> </i>
                                </a>
                            `;
                        }
                        // btnReturn +=  `
                        //     <a href="${base_url}instructor/head/viewStudent/${row.code}" class="btn-view btn-sm mb-2 mr-2 btn-icon btn-icon-only btn-shadow btn-outline-2x btn btn-outline-secondary"  data-toggle="tooltip" data-placement="top" title="View">
                        //         <i class="lnr-eye btn-icon-wrapper"> </i>
                        //     </a>
                        // `;
                        return btnReturn;

                    }
                }
            ]
        });// end of the data table variable
    }

    if (sub_content == 'panel/projectTitleHearingResult') {
        var projectTitleHearing = $('#projectTitleHearing').DataTable({
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 7 }
            ],
        });// end of the data table variable
    }

    if (sub_content == 'panel/assignAdviser') {

        // initialize select2
        var panelist = $("#selec2-assignAdviser").select2({
            createTag: function () {
                // Disable tagging
                return null;
            },
            tags: "true",
            theme:"bootstrap4",
            placeholder: "Adviser here..."
        });
    }

    if (sub_content == 'panel/groupDetails') {
        var tableGroupDetails = $('#table-groupDetails').DataTable({
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 2 }
            ],
        });// end of the data table variable
    }

    if (sub_content == 'panel/capstone1') {
        var tableGroupDetails = $('#table-capstone1').DataTable({
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 4 }
            ],
        });// end of the data table variable
    }


    if (sub_content == 'panel/groupEvaluation') {
        var tableGroupDetails = $('#table-groupEvaluation').DataTable({
            "responsive" : true,
            "ordering": false,
            "paging": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 4 }
            ],
        });// end of the data table variable
    }
});
