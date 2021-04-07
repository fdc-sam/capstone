$(document).ready(function(){
    $(document).on('click', '#btnUpdate', function(e){
        e.preventDefault();
        var firstName = $('#firstName').val();
        var middleName = $('#middleName').val();
        var lastName = $('#lastName').val();
        var email = $('#email').val();
        var gender = $('#gender').val();
        var errorFlag = 0;
        var message = '';
        
        if (firstName == "") {
            errorFlag ++;
            message += '<li><b>First Name</b> is Required</li>';
        }
        
        if (lastName == "") {
            errorFlag ++;
            message += '<li><b>Last Name</b> is Required</li>';
        }
        
        if (email == "") {
            errorFlag ++;
            message += '<li><b>E-mail</b> is Required</li>';
        }
        
        if (errorFlag > 0) {
            $('#message').html(`
                <div class="alert alert-dismissible fade show alert-danger" role="alert">
                    <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                        <span aria-hidden="true">×</span>
                    </button>
                    <ul>
                        ${message}
                    </ul>
                </div>`
            );
            return;
        }
        
        var data =  {
            'firstName':firstName,
            'middleName':middleName,
            'lastName':lastName,
            'email':email,
            'gender':gender
        }
        $.ajax({
            url:`${base_url}/student/home/updateMyProfile`,
            type:'post',
            dataType:'json',
            data:data,
            beforeSend: function() {
                $('#loadingState').show();
            },
            success:function(data){
                // if (!data.error) {
                //     var alertClass = `alert-success`;
                //     var alertMessege = `Group member has successfully <b>Added</b>`;
                //     groupMemberMultiSelect.val(null).trigger("change");
                // }else{
                //     var alertClass = `alert-warning`;
                //     var alertMessege = `Group member was not Added`;
                // }
                // 
                // $('#alertMessageModal').html(`
                //     <div class="alert alert-dismissible fade show ${alertClass}" role="alert">
                //         <button type="button" class="close" aria-label="Close" data-dismiss="alert">
                //             <span aria-hidden="true">×</span>
                //         </button>
                //         ${alertMessege}
                //     </div>`
                // );
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
    });
});
