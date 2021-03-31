if (sub_content == 'home/index') {
    $(document).ready(function(){
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
}
