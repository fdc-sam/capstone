
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

<?php foreach ($getCapstoneDetails as $key => $getCapstoneDetail): ?>
    
    <div class="col-md-12">
        <div class="card-hover-shadow-2x mb-3 card">
            <div class="card-body" style="border: 2px solid black;">
                
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
                                <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $getCapstoneDetail->thesis_group_name; ?></span>
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
                    <?php foreach ($getCapstoneDetail->users as $key => $value): ?>
                        <?php  
                            $fullName = $value->first_name.' '.$value->middle_name.' '.$value->last_name;
                        ?>
                        <tr style="line-height: 25px !important;">
                            <td>
                                <p style="text-align: center;">
                                    <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $fullName; ?></span>
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
                                <span style="font-family: 'Arial Narrow'; font-size: 12pt;"><?php echo $getCapstoneDetail->title; ?></span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 5px;"><span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">SCOPE OF THE STUDY : </span></p>
                            <?php echo $getCapstoneDetail->discreption; ?>
            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 5px;">
                                <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">LIMITATIONS OF THE STUDY : </span>
                            </p>
                            <?php echo $getCapstoneDetail->limitations_of_the_studies; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="margin: 5px;">
                                <span style="font-family: 'Arial Narrow'; font-size: 12pt; font-weight: bold;">PROJECT DESIGN DEVELOPMENT PLAN : </span>
                            </p>
                            <?php echo $getCapstoneDetail->limitations_of_the_studies; ?>
                        </td>
                    </tr>
                </table>
    
            </div>
            <!-- <div class="d-block text-right card-footer">
                <button class="mr-2 btn btn-link btn-sm">Cancel</button>
                <button class="btn-shadow-primary btn btn-primary btn-lg">Submit</button>
            </div> -->
        </div>
    </div>
<?php endforeach; ?>



