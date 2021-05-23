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
});
