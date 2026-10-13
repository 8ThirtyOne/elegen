 var form ='';
 $('form').submit(function(){
     form = this.id;
     var isValid = true;
     var regField = [];
     $.each($('#'+form+' .get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       //grecaptcha.execute();
      formSubmit();
     }else{
      //grecaptcha.reset();
     }
    return false;
 });

//function formSubmit(response){
function formSubmit(){
  if(form == 'home-form'){
    var formReq = $('#home-form h4');
    var regBtn = $('#register-btn');
    regBtn.prop('disabled', true);
    regBtn.val('Please Wait').css('background','#7d868c');
    var f = $('form[name="askDnaFrm"]');
    var query = f.serializeArray();
    $('#error-box').remove();
    var errorBox = $(document.createElement('ul'));
    var errorText = $(document.createElement('li'));
    $.ajax({
       type:'POST',
       url:'/support/process-request', 
       data:query,
       success:function(data){
         if(data == 0){
            grecaptcha.reset();
            regBtn.prop('disabled', false);
            regBtn.val('Submit').css('background','#0e3455');
            errorBox.attr('id','error-box').insertBefore(formReq);
            errorText.text('Something went wrong. Please try again.').appendTo(errorBox);
         }
         else if(data == 2){
            errorBox.attr('id','error-box').insertBefore(formReq);
            errorText.text('Email is required').appendTo(errorBox);
            grecaptcha.reset();
            regBtn.prop('disabled', false);
            regBtn.val('Submit').css('background','#0e3455');
         }
         /*else if(data == 3){
           errorBox.attr('id','error-box').insertBefore(formReq);
           errorText.text("The reCAPTCHA wasn't entered correctly. Please try again.").appendTo(errorBox);
           grecaptcha.reset();
           regBtn.prop('disabled', false);
           regBtn.val('Submit').css('background','#0e3455');
         }/*/
         else{
           document.location.href = "/support/thank-you";
         }
       },
       error:function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
       }
    });
  }else{
    var formReq = $('#subscribe-form p');
    var regBtn = $('#subscribe-btn');
    regBtn.prop('disabled', true);
    regBtn.val('Please Wait').css('background','#7d868c');
    var f = $('form[name="subscribeFrm"]');
    var query = f.serializeArray();
    $('#error-box').remove();
    var errorBox = $(document.createElement('ul'));
    var errorText = $(document.createElement('li'));
    $.ajax({
       type:'POST',
       url:'/support/process-footer-form', 
       data:query,
       success:function(data){
         if(data == 0){
            grecaptcha.reset();
            regBtn.prop('disabled', false);
            regBtn.val('Submit').css('background','#0e3455');
            errorBox.attr('id','error-box').insertAfter(formReq);
            errorText.text('Something went wrong. Please try again.').appendTo(errorBox);
         }
         else if(data == 2){
            errorBox.attr('id','error-box').insertAfter(formReq);
            errorText.text('Email is required').appendTo(errorBox);
            grecaptcha.reset();
            regBtn.prop('disabled', false);
            regBtn.val('Submit').css('background','#0e3455');
         }
          else if(data == 3){
            errorBox.attr('id','error-box').insertAfter(formReq);
            errorText.text('Email already exists.').appendTo(errorBox);
            grecaptcha.reset();
            regBtn.prop('disabled', false);
            regBtn.val('Submit').css('background','#0e3455');
         }
         else{
             $('#subscriber-thanks').fadeIn(function(){
               $('#subscriber-thanks').fadeOut(8000, function(){
                regBtn.val('Submit').css('background','#1B1C1D');
               });
             });
         }
       },
       error:function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
       }
    });
  }
}