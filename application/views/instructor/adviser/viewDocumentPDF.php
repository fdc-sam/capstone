
<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('instructor/adviser/advisory'); ?>">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Document PDF</a>
                        </li>
                    </ol>

                </nav>
                <a href="<?php echo base_url('instructor/adviser/commentDocumentPDF/'.$documentsId.'/'.$groupId.'/'.$documentFileName); ?>" target="_blank" class="text-right">
                    <button class="mb-2 mr-2 btn btn-shadow btn-primary">
                        <i class="fa fa-fw" aria-hidden="true" title="Copy to use commenting"></i>
                        Comment
                    </button>
                </a>
            </div>
        </div>
        <div class="" id="alertMessege"></div>
        <style media="screen">
            #pdf{
                width: 100% ;
                height: 100vh;
                margin: 0 auto;
            }
        </style>
        <div class="tabs-animation">
            <div class="row">
                <div class="col-md-12 col-lg-12 parent">
                    <object id="pdf" data="<?php echo base_url('uploads/'.$documentFileName); ?>" type="application/pdf" width="100%">
                            <p>Your web browser doesn't have a PDF plugin.
                            Instead you can <a href="<?php echo base_url('uploads/'.$documentFileName); ?>">click here to
                            download the PDF file.</a></p>
                    </object>
                </div>
            </div>
        </div>
    </div>
</div>
