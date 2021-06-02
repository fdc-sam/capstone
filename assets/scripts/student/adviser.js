$(document).ready(function(){
    if (sub_content == 'adviser/index') {
        var tableAssignedGroub = $('#table-adviser').DataTable({
            "responsive" : true,
            "ordering": false,
            "paging": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 3 }
            ],
        });// end of the data table variable
    }
});
