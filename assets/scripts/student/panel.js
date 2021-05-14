$(document).ready(function(){
	if (sub_content == 'panel/index') {
        var dataTablePanelist = $('#dataTablePanelist').DataTable({
            "responsive" : true,
            "processing" : true,
            "serverSide" : true,
            "order": [[0,'asc']],
            "ajax" : {
              "url" : `${base_url}student/panel/getAllPanelist`,
              "type" : "POST"
            },
            "columns" : [
                {"data": "id"},
                {
                    "data": "id",
                    "render": function(data, type, row, meta){
                        return `${row.first_name} ${row.middle_name} ${row.last_name} `;
                    }
                },
                {"data": "email"},
                {
                    "data": "gender",
                    "render": function(data, type, row, meta){
                        if (data == 1) {
                            // male
                            return `Male`;
                        }else if(data == 2){
                            // male
                            return `Female`;
                        }else{
                            // Others
                            return `Others`;
                        }
                    }
                },
                {
                    "data": "status",
                    "render": function(data, type, row, meta){
                        if (data == 0) {
                            return `<div class="badge badge-warning ml-2">Pending</div>`;
                        }else if(data == 1){
                            return `<div class="badge badge-primary ml-2">Confirmed</div>`;
                        }
                    }
                }
            ]
        });// end of the data table variable
    }
});
