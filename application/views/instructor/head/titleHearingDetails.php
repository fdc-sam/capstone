
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
    
<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/head'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/head/proposal'); ?>">Proposal</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Details</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="" id="message"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-hover-shadow-2x mb-3 card">
                    <div class="card-body" style="border: 2px solid black;">
                        <form class="" id="formProjectHearing" action="index.html" method="post">
                            <div class="" >
                                <img style="width: 350px; height: 78px;" src="<?php echo base_url('assets/images/evsu-logo-with-words.png') ?>" alt="evsu logo">
                            </div>
                            
                            <p style="text-align: center; margin-top: 0; margin-bottom: 0;">
                                <span style="font-family: 'Arial'; font-size: 14pt; font-weight: bold;">CAPSTONE PROJECT TITLE HEARING </span>
                            </p>
                            <!-- <p style="text-align: center; margin-top: 0; margin-bottom: 0;">
                                <span style="font-family: 'Arial'; font-size: 12pt;">February 7 – 8, 2020 </span>
                            </p> -->
                            <p style="text-align: center; margin-top: 0; margin-bottom: 0;">
                                <span style="font-family: 'Arial'; font-size: 12pt;">IT Room1 </span>
                            </p>
                            <p style="margin-bottom: 0pt;">
                                <span style="font-family: 'Arial'; font-size: 12pt; font-weight: bold;" id="hearingDateTimeDis"></span>
                                <input type="hidden" name="hearingDateTimePost" value="" id="hearingDateTimePost">
                            </p>
                            <p style="margin-bottom: 0pt;">
                                <span style="font-family: 'Arial'; font-size: 12pt;"> </span>
                            </p>
                            <p>&nbsp;</p>
                            <div class="tableContainer">
                                <?php echo $display; ?>
                                <div style="text-align:center;">
                                    <h4>Please Add Project Hearing</h4>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="d-block text-right card-footer">
                        <a href="<?php echo base_url('instructor/head/proposal'); ?>" class="mr-2 btn btn-outline-danger btn-sm">Cancel</a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
    
