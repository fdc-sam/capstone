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

<!-- Large modal  add propose -->

<div class="modal fade bd-example-modal-lg" id="addProposeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="proposeForm" class="" action="index.html" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Propose </h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="modalContainer">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="" class=""> PROJECT TITLE</label>
                                            <input name="title[]"  placeholder="" type="text" class="form-control proposeTitle" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="" class=""> SCOPE OF THE STUDY</label>
                                            <textarea rows="1" name="description[]" id="description" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="" class=""> LIMITATIONS OF THE STUDY</label>
                                            <textarea rows="1" name="limitations[]" id="limitations" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="" class=""> PROJECT DESIGN DEVELOPMENT PLAN</label>
                                            <textarea rows="1" name="designDevelopmentPlan[]" id="designDevelopmentPlan" class="form-control autosize-input" style="max-height: 200px; height: 65px;" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     <span>
                         Remaining Proposal Left
                         <b>
                            <span id="countAvailableProposalLeft"> 0 </span>
                            /
                            <span>5</span>
                        </b>
                    </span>  |
                    <!-- <button type="button" class="btn btn-secondary "></button> -->
                    <button class="btn btn btn-outline-light addMoreProposal">Create Proposal</button>
                    <button type="submit" class="btn btn-primary btnPropose">Propose</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url('assets/scripts/jquery-3.6.0.js'); ?>" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>
<script src="<?php echo base_url('assets/scripts/sweetalert2.js'); ?>"></script>
<script type="text/javascript">
	// set variables
	var base_url = '<?php echo base_url()?>';
	var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>';
	var sub_content =  '<?php echo isset($subContent)? $subContent : null ?>';
</script>
<script src="<?php echo base_url('assets/scripts/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?php echo base_url('assets/scripts/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/scripts/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/scripts/student/home.js'); ?>"></script>

<?php if ($subContent == 'home/viewDocumentPDF'): ?>

    <!-- for pdf js -->
    <script type="text/javascript" src="https://unpkg.com/pdfobject@2.1.1/pdfobject.js"></script>
    <script type="text/javascript">
        var file_name = '<?php echo $thesisDocuments->file_name ?>';
        var options = {
            pdfOpenParams: {
                pagemode: "thumbs",
                navpanes: 1,
                toolbar: 1,
                statusbar: 1,
                view: "FitV"
            }
        };
        PDFObject.embed(`${base_url}uploads/${file_name}`, "#viewer", options);
    </script>
<?php endif; ?>

<?php if ($subContent == 'home/MyProfile'): ?>
	<script src="<?php echo base_url('assets/scripts/student/myProfile.js'); ?>"></script>
<?php endif; ?>

<?php if ($subContent == 'home/mySignature'): ?>

    <link type="text/css" href="<?php echo base_url('assets/signature/css/jquery-ui.css') ?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('assets/signature/css/jquery.signature.css') ?>" rel="stylesheet">

    <script src="<?php echo base_url('assets/signature/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/signature/js/jquery-ui.min.js') ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/signature/js/jquery.signature.min.js') ?>"></script>
    <script type="text/javascript">


    $.extend($.kbw.signature.options, {
        color: '#000000',
        background: "transparent"
    });

    var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
    var sig = $('#sig').signature();

    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
    </script>
<?php endif; ?>

<?php if ($mainContent == 'student/panel'): ?>
	<script src="<?php echo base_url('assets/scripts/student/panel.js'); ?>"></script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
	$('#loadingState').hide();
});
</script>
