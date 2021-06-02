
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
                                        ?><div class="badge badge-warning ml-2">Pending</div><?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="border: 2px solid black;">
                            <style>
                                * {
                                    font-family: Arial;
                                    font-size: 11pt;
                                }

                                a.NoteRef {
                                    text-decoration: none;
                                }

                                hr {
                                    height: 1px;
                                    padding: 0;
                                    margin: 1em 0;
                                    border: 0;
                                    border-top: .000001em solid #CCC;
                                }

                                table {
                                    /* border: .011em solid black; */
                                    border-spacing: 0px;
                                    width: 100%;
                                }

                                td {
                                    border: .000001em solid black;
                                }
                                td p {
                                    margin-left: 5px !important;
                                    margin-right: 5px !important;
                                    margin-bottom: 0 !important;
                                }
                                .Normal {
                                    margin-bottom: 8pt;
                                }

                                .No Spacing {
                                    margin-bottom: 0pt;
                                }

                            </style>
                            <div class="" >
                                <img style="width: 350px; height: 78px;" src="<?php echo base_url('assets/images/evsu-logo-with-words.png') ?>" alt="evsu logo">
                            </div>

                            <p style="text-align: center; margin-top: 0; margin-bottom: 0;">
                                <span style="font-family: 'Arial Narrow'; font-size: 14pt; font-weight: bold;">CAPSTONE PROJECT TEAM ASSIGNMENTS</span>
                            </p>
                            <p>&nbsp;</p>
                            <table class="TableGrid">
                                <tr>
                                    <td style="width: 15%;">
                                        <p>
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">TEAM NAME</span>
                                        </p>
                                    </td>
                                    <td style="width: 75%;">
                                        <p>
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $getCapstoneDetails[0]->thesis_group_name; ?></span>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <p>&nbsp;</p>
                            <table class="TableGrid">
                                <tr>
                                    <td style="width: 30%;">
                                        <p style="text-align: center; ">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">NAME</span>
                                        </p>
                                    </td>
                                    <td style="width: 40%;">
                                        <p style="text-align: center;">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">ROLE</span>
                                        </p>
                                    </td>
                                    <td style="width: 25%;">
                                        <p style="text-align: center;">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">SIGNATURE</span>
                                        </p>
                                    </td>
                                </tr>

                                <!--  get the group members -->
                                <?php foreach ($getCapstoneDetails as $key => $value): ?>
                                    <?php
                                        $first_name = $value->first_name.' '.$value->middle_name.' '.$value->last_name;
                                    ?>
                                    <tr style="line-height: 25px !important;">
                                        <td>
                                            <p style="text-align: center;">
                                                <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $first_name; ?></span>
                                            </p>
                                        </td>
                                        <td>
                                            <?php if ($value->role_name): ?>
                                                <p style="text-align: center;">
                                                    <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $value->role_name; ?></span>
                                                </p>
                                            <?php else: ?>
                                                <p style="text-align: center;">
                                                    <span style="font-family: 'Arial Narrow'; font-size: 12pt;">Not Decided</span>
                                                </p>
                                            <?php endif; ?>
                                        </td>
                                        <td style="height: 25px !important;">
                                            <?php if ($value->signatures): ?>
                                                <img src="data:image/png;base64, <?php echo $value->signatures ?>" alt="Signature"
                                                    style=" overflow: visible;  width:200px; position: absolute; margin-top: -25px;"
                                                />
                                            <?php else: ?>
                                                <p style="text-align: center; margin-top: 0; margin-bottom: 0;">
                                                    <span style="font-family: 'Arial Narrow'; font-size: 12pt;">No SIGNATURE</span>
                                                </p>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>
                            <p>&nbsp;</p>
                            <p style="text-align: center; margin-top: 0; margin-bottom: 0;"><span style="font-family: 'Arial Narrow'; font-size: 14pt; font-weight: bold;">PRE-PROPOSAL STATEMENTS</span></p>
                            <p>&nbsp;</p>
                            <table class="TableGrid">
                                <tr>
                                    <td>
                                        <p style="margin: 5px;"><span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">PROJECT TITLE : </span></p>
                                        <p style="margin: 5px;">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $getCapstoneDetails[0]->title; ?></span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 5px;"><span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">SCOPE OF THE STUDY : </span></p>
                                        <?php echo $getCapstoneDetails[0]->discreption; ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 5px;">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">LIMITATIONS OF THE STUDY : </span>
                                        </p>
                                        <?php echo $getCapstoneDetails[0]->limitations_of_the_studies; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="margin: 5px;">
                                            <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">PROJECT DESIGN DEVELOPMENT PLAN : </span>
                                        </p>
                                        <?php echo $getCapstoneDetails[0]->limitations_of_the_studies; ?>
                                    </td>
                                </tr>
                            </table>
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

                    <?php if ($getCapstoneDetails[0]->status == 1): ?>
                        <!-- presentation materials -->
                        <div class="main-card mb-3 card">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                    Documents
                                </div>
                                <div class="btn-actions-pane-right text-capitalize">

                                        <form method='post' action='<?php echo base_url('upload/uploadMultiFiles'); ?>' enctype='multipart/form-data'>
                                            <input type="text" name="proposalId" value="<?php echo $proposalId; ?>" hidden>
                                            <input id="addMultiFiles" type='file' name='files[]' accept="image/*" multiple hidden>

                                            <button class="mb-2 mr-2 btn-icon btn-shadow btn-sm btn-outline-2x btn btn-outline-primary btnSaveMultiFiles">
                                                <i class="fa fa-fw" aria-hidden="true" title="Copy to use check"></i>
                                                Save
                                            </button>
                                            <button class="mb-2 mr-2 btn-icon btn-shadow btn-sm btn-outline-2x btn btn-outline-primary btnAddMultiFiles">
                                                <i class="lnr lnr-file-add btn-icon-wrapper"> </i>
                                                File
                                            </button>
                                            <button class="mb-2 mr-2 btn-icon btn-shadow btn-sm btn-outline-2x btn btn-outline-danger btnCancelFiles">
                                                <i class="fa fa-fw" aria-hidden="true" title="Copy to use close"></i>
                                                Cancel
                                            </button>
                                        </form>

                                </div>
                            </div>
                            <div class="files-box">
                                <ul class="list-group list-group-flush selectedFiles">
                                </ul>

                                <ul class="list-group list-group-flush">
                                    
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
