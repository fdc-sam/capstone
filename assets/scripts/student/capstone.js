$(document).ready(function(){
    if (sub_content == 'capstone/index') {
        var tableAssignedGroub = $('#table-panelist').DataTable({
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

    if (sub_content == 'capstone/groupEvaluation') {
        var tableAssignedGroub = $('#table-groupEvaluation').DataTable({
            "responsive" : true,
            "ordering": false,
            "paging": false,
            "columnDefs": [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 5 },
                { responsivePriority: 1, targets: 6 }
            ],
        });// end of the data table variable
    }
});
