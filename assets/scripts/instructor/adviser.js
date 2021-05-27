$(document).ready(function(){
    if (sub_content == 'adviser/index') {
        var tableAssignedGroub = $('#table-assignedGroub').DataTable({
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 5 }
            ],
        });// end of the data table variable
    }

    if (sub_content == 'adviser/advisory') {
        var tableAssignedGroub = $('#table-advisory').DataTable({
            "responsive" : true,
            "columnDefs": [
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 4 }
            ],
        });// end of the data table variable
    }
});
