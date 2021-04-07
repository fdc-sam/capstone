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
                                    <label for="exampleEmail11" class=""> Title</label>
                                    <input name="title[]" id="exampleEmail11" placeholder="" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="exampleEmail11" class=""> Description</label>
                                    <textarea rows="1" name="description[]" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `); //add input box
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
    
    $(document).on("submit", "#proposeForm", function(e) {
        e.preventDefault();
    
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
        
        
        $.ajax({
            url:`${base_url}/student/home/addPropose`,
            type:'post',
            dataType:'json',
            data:{
                titles:proposeTitles,
                descriptions:proposeDescription
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
    
}
