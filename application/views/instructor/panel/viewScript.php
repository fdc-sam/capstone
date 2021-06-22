
<div class="app-main__outer">
    <div class="app-main__inner">
        <div>
            <div class="page-title-subheading opacity-10">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:history.go(-1)">
                                <i aria-hidden="true" class="fa fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Document PDF</a>
                        </li>
                    </ol>

                </nav>
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
                    <?php if (isset($files) && $files): ?>
                        <object id="pdf" data="<?php echo base_url('uploads/'.$files->file_name); ?>" type="application/pdf" width="100%">
                                <p>Your web browser doesn't have a PDF plugin.
                                Instead you can <a href="<?php echo base_url('uploads/'.$files->file_name); ?>" download>click here to
                                download the PDF file.</a></p>
                        </object>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
