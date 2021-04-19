
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
                            <a href="<?php echo base_url('student/home/capstoneDetails/'.$thesisDocuments->thesis_id) ?>">Capstone Details</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Document PDF</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="" id="alertMessege"></div>        
        <div class="tabs-animation">
            <div class="row">
                <div class="col-md-12 col-lg-12 parent">
                    <div  id='viewer' style='width: 100%; height: 100%; margin: 0 auto;'></div>
                </div>
            </div>
        </div>
    </div>
</div>
