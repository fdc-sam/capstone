</body>
</html>
<script src="<?php echo base_url('assets/scripts/jquery-3.6.0.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/scripts/main.d810cf0ae7f39f28f336.js'); ?>"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url()?>';
var main_content = '<?php echo isset($mainContent)? $mainContent : null ?>'; 
$(document).ready(function(){
    $('#loadingState').hide();
    
    if (main_content == 'landingPage/login') {
        $('#alertMessage').hide();
        $('#formLogin').on('submit',function(e){
            e.preventDefault();
            // alert("asd");
            $.ajax({
                url: base_url+'auth/login', // contrller/function
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                processData:false,
                // dataType: 'json',
                beforeSend: function() {
                    $('#loadingState').show();
                },
                success:function(result){
                    $('#loadingState').hide();
                    // $('#message').html(result);
                    // $('#message').css("display","block");
                    // $('#regForm')[0].reset();
                    console.log(result);
                    if(result == 'admin'){
                        console.log(result);
                        window.location.replace(`${base_url}admin/home/`);
                    }else if(result == 'student'){
                        window.location.replace(`${base_url}student/home`);
                        console.log(result);
                    }else if(result == 'IT head'){
                        console.log(result);
                        window.location.replace(`${base_url}instructor/head`);
                    }else if(result == 'instructor'){
                        console.log(result);
                        window.location.replace(`${base_url}instructor/panel`);
                    }else{
                        var temp = JSON.parse(result);
                        console.log(temp);
                        $('#content').removeClass('hidden');
                        $('#infoMessage').html(temp.message);
                        $('#alertMessage').show();
                    }
                    // console.log(jQuery.parseJSON(result));
                },
                complete:function(){
                    
                }
            });
        });
    } // end landingPage/login
    
    if (main_content == 'landingPage/register') {
        $('#formRegister').on('submit',function(e){
            $('#loadingState').show();
        });
    }// end landingPage/register
    
});
</script>
