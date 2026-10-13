<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    $PageUrl = "/admin/news-events/events/registerFrm";
    $PageCode = "000000";
    $bodyid = "news";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
    }else{
        header('Location: /admin/');
        exit;
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Add Event | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEWS</h2>

            <form method="post" name="regFrm" action="/admin/news-events/events/register" id="enter-data" enctype="multipart/form-data">

            <fieldset id="field-one">
                <input type="hidden" name="type" id="type" value="" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#0">*Select Type<i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#1">Event</a></li>
                  </ul>
                </div>

              </div>

            </fieldset>

            <fieldset>
                <label for="Start Date">Start Date<span>*</span></label>
                <input type="text" name="startdate" id="startdate" class="date-field get-value" placeholder="*Start Date" maxlength="4" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="End Date">End Date<span>*</span></label>
                <input type="text" name="enddate" id="enddate" class="date-field get-value" placeholder="*End Date" maxlength="4" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Main Title">Main Title<span>*</span></label>
                <input type="text" name="title" class="get-value" id="main-title" placeholder="*Main Title" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Subtitle">Subtitle<span>*</span></label>
                <input type="text" name="subtitle" class="get-value" id="subtitle" placeholder="*Subtitle" maxlength="255" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Address">Address<span>*</span></label>
                <input type="text" name="address" class="get-value" id="source" placeholder="*Address" maxlength="255" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Location"><span>*</span>Location</label>
                <input type="text" name="locationone" id="location-one" class="get-value" placeholder="*Location 1" maxlength="250" tabindex="6" />
            </fieldset>

            <fieldset>
                <label for="Conference Url">Url<span>*</span>Conference Url</label>
                <input type="text" name="url" class="get-value" id="url" placeholder="*Conference Url" maxlength="255" tabindex="7" />
            </fieldset>

            <fieldset>
                <label for="Booth">Booth<span>*</span></label>
                <input type="text" name="booth" class="get-value" id="booth" placeholder="*Booth" maxlength="60" tabindex="8" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="eventurl" id="slug-url" class="get-value" placeholder="*Slug Url (eg. main-title-url)" maxlength="500" tabindex="9" />
            </fieldset>

            <fieldset>
                <label for="Description">Description</label>
                <textarea name="description" id="description" placeholder="*Description" rows="1" cols="1" minlength="11" maxlength="800" aria-required="true" class="get-value" tabindex="10"></textarea>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE</label>
            <input type="file" name="thumbnail" tabindex="11" />
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File">UPLOAD FILE</label>
            <input type="file" name="up_file" id="up_file" tabindex="12" />
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="14" />
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
<script>
$(function(){
 $( "#startdate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
 $( "#enddate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     $('#error-box').remove();
     var errorBox = $(document.createElement('fieldset'));
     var errorText = $(document.createElement('li'));
     var isType = $('#filter a').attr('href').split("#").pop();
     if(isType == 0){
       errorBox.attr('id','error-box').insertBefore($('#field-one'));
       errorText.text('Please select Event Type.').appendTo(errorBox);
       isValid = false;
     }
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       $('#submit-btn').prop('disabled', true);
       $('#submit-btn').val('Please Wait').css('background','#7d868c');
       var f = document.regFrm;
       f.submit();
     }
 });

 var selectBox = $('.select-box');
 $('.select-box .current').click(function(e){
    selectChoice($(this));
    //stop propagation cause of window click
    e.preventDefault();
 });

 $(window).click(function(e) {
      var link = $('.select-box li');
      selectBox.each(function(index){
        var box = this.id;
        //if clicked anywhere on window but dropbox link
        if(!link.is(e.target)){
           if($('#'+box).height() > 40){
            $('#'+box).animate({
               height: "40px"
              }, {
              duration: 200,
              specialEasing:{
              width: 'linear'
              }
            });
           }
        }
      });
 });

 $('.select-box .choice').click(function(e){
      e.preventDefault();
      var icon = $(document.createElement('i'));
      icon.attr('class','fa fa-chevron-circle-down');
      var choice = $(this).find('a').attr('href');
      var filter = choice.split("#").pop();
      $('#type').val(filter);
      $('.select-box .current').find('i').remove();
      $('.select-box .current')
       .removeClass('current')
       .addClass('choice')
       .insertAfter($(this));
       $(this).removeClass('choice').addClass('current');
       icon.appendTo('.current a');
       $('.select-box ul').prepend($(this));
       $('.select-box .current').click(function(event){
         selectChoice($(this));
         event.preventDefault();
       });
  });

 function selectChoice(elem){
        var $this = elem;
        var opened = $this.closest('div').find('.select-open').attr('id');
        if(opened){
          $('#'+opened).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
          $('#'+opened).removeClass('select-open');
        }
        var id = $this.closest('div').attr('id');
        var dropdownH = $('#'+id)[0].scrollHeight;

        if($('#'+id).height() > 40){
          $('#'+id).animate({
             height: "40px"
            }, {
            duration: 200,
            specialEasing:{
            width: 'linear'
            }
          });
        }else{
          $('#'+id).animate({
             height: dropdownH+'px'
            }, {
            duration: 200,
            specialEasing:{
            width:'linear'
            }
          });
          $('#'+id).addClass('select-open');
        }
   }
});
</script>
</body>
</html>
