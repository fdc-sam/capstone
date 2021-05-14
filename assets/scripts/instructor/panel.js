$(document).ready(function(){
    if (sub_content == 'panel/index') {
        var batchDataTable = $('#getAllAssignedCapstone').DataTable({
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
                            return `<div class="badge badge-success ml-2">Reject</div>`;
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
                        return btnReturn;

                    }
                }
            ]
        });// end of the data table variable
    }
});
