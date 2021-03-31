<!-- add group member Modal -->

<style media="screen">
    .select2-search__field{
        width: 100% !important;
    }
</style>

<div class="modal fade" id="addGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="card-title">Select Group Member's</h5>
                <div class="" id="alertMessageModal"></div>       
                <select id="groupMember" class="form-control" multiple="multiple">
                    <?php foreach ($studentInfo as $key => $value): ?>
                        <?php $fullName = $value->first_name." ".$value->middle_name." ".$value->last_name; ?>
                        <option value="<?php echo $value->id ?>"><?php echo $fullName; ?></option>
                    <?php endforeach; ?>
                </select>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="btnGroupSave" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>