
<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('student/home'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Capstone Details</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="" id="alertMessege"></div>        
        <div class="tabs-animation">
            <div class="row">
                
                <div class="col-md-12 col-lg-8">
                    <div class="main-card mb-3 card">
                        <div class="card-header">
                            <div class="btn-actions-pane-right actions-icon-btn">
                                <div role="group" class="btn-group-sm nav btn-group">
                                    <?php  
                                    if ($getCapstoneDetails[0]->status == 1) {
                                        // Approved
                                        ?><div class="badge badge-success ml-2">Approved</div><?php
                                    }elseif ($getCapstoneDetails[0]->status == 2) {
                                        // Rejected
                                        ?><div class="badge badge-danger ml-2">Rejected</div><?php
                                    }else {
                                        // Pending
                                        ?><div class="badge badge-warning ml-2">Approved</div><?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $getCapstoneDetails[0]->title; ?></h5>
                            <div class="scroll-area-md">
                                <div class="scrollbar-container ps--active-y">
                                    <p><?php echo $getCapstoneDetails[0]->discreption; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="col-md-12 col-lg-4">
                    <div class="main-card mb-3 card">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                Documents
                            </div>
                            <div class="btn-actions-pane-right text-capitalize">
                                <?php  
                                if ($getCapstoneDetails[0]->status == 1) {
                                    // Approved
                                    ?>
                                    <form class="form-document" action="<?php echo base_url('upload/fileUpload/'.$proposalId); ?>" method="post" enctype='multipart/form-data'>
                                        <input type="file" id="selectedFile" name="selectedFile" hidden > <!--accept=".pdf, .docx, .doc"-->
                                        <input type="submit" name="button" class="updloadFile" value="upload" hidden>
                                    </form>
                                    <button class="mb-2 mr-2 btn-icon btn-shadow btn-sm btn-outline-2x btn btn-outline-primary btnAddFiles">
                                        <i class="lnr lnr-file-add btn-icon-wrapper"> </i>
                                        File
                                    </button>
                                    <?php
                                }
                                ?>
                                
                            </div>
                        </div>
                        <div class="files-box">
                            <ul class="list-group list-group-flush selectedFiles">
                            </ul>
                            
                            <ul class="list-group list-group-flush">
                                <?php if (isset($thesisDocuments) && $thesisDocuments): ?>
                                    <?php foreach ($thesisDocuments as $key => $thesisDocument): ?>
                                        <?php if ($thesisDocument->file_extention == ".pdf"): ?>
                                            <li class="pt-2 pb-2 pr-2 list-group-item li-selectedFile<?php echo $thesisDocument->id; ?>">
                                                <a href="<?php echo base_url('student/home/viewDocumentPDF/'.$thesisDocument->id); ?>" class="hrefDocument">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left opacity-6 fsize-2 mr-3 text-danger center-elem">
                                                                <i class="fa fa-file-pdf"></i>
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading font-weight-normal"><?php echo $thesisDocument->display_file_name; ?></div>
                                                            </div>
                                                            <div class="widget-content-right widget-content-actions">
                                                                <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary btnViewDocument">
                                                                    <i class="lnr-eye btn-icon-wrapper"> </i>
                                                                </button>
                                                                <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger btnDeleteDocument" documentId="<?php echo  $thesisDocument->id ?>">
                                                                    <i class="lnr-trash btn-icon-wrapper"> </i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php elseif ($thesisDocument->file_extention == ".docx"):?>
                                            <li class="pt-2 pb-2 pr-2 list-group-item">
                                                <a href="#" class="hrefDocument">
                                                    <div class="widget-content p-0">
                                                        <div class="widget-content-wrapper">
                                                            <div class="widget-content-left opacity-6 fsize-2 mr-3 text-primary center-elem">
                                                                <i class="fa fa-file-alt"></i>
                                                            </div>
                                                            <div class="widget-content-left">
                                                                <div class="widget-heading font-weight-normal"><?php echo $thesisDocument->display_file_name; ?></div>
                                                            </div>
                                                            <div class="widget-content-right widget-content-actions">
                                                                <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-primary btnViewDocument">
                                                                    <i class="lnr-eye btn-icon-wrapper"> </i>
                                                                </button>
                                                                <button class="mb-2 mr-2 btn-icon btn-sm btn-icon-only btn-shadow btn-outline-2x btn btn-outline-danger btnDeleteDocument" documentId="<?php echo  $thesisDocument->id ?>">
                                                                    <i class="lnr-trash btn-icon-wrapper"> </i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



