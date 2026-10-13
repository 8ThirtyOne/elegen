<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
       $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
       if(!empty($username)){
          $PageUrl = "/admin/resources/literatures/modifyFrm";
          $PageCode = "000000";
          $bodyid = "resources";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);
          if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
           $pkid = $webhelper->RequestFilter('pkid', 0, false);   
           $exists = $dbhelper->numOfRows('SELECT title FROM literatures WHERE pkid = ?', 'i', $pkid); 
           if($exists > 0){
            $page = $webhelper->RequestFilter("page", 0, false);
            $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
            $order = $webhelper->RequestFilter("order", 0, false);
            $Parameter = "&searchKey=$searchKey&order=$order";
            $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT pkid, title, status, year, month, day, slugurl, keywords, body, thumbnail, filename, orgfilename, permission, updatedate, type FROM literatures WHERE pkid = $pkid ");
           }else{
            header('Location: /admin/news/press/list');
            exit;
           }
          }
        }else{
            header('Location: /admin/');
            exit;
        }
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Edit Literature | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT LITERATURE</h2>

            <form method="post" name="modifyForm" action="/admin/resources/literatures/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="pkids[]"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />
                <input type="hidden" name="oldFile" value="<?php echo $ViewData["filename"]; ?>" />
                <input type="hidden" name="oldOrgFile" value="<?php echo $ViewData["orgfilename"]; ?>" />

            <fieldset id="field-one">
                <?php 
                switch($ViewData['type']){
                    case 1:
                        $currentChoice = 'Brochure';
                        $currentType = '1';
                        $secondChoice = 'Document';
                        $secondType = '2';
                        $thirdChoice = 'Publication';
                        $thirdType = '3';
                        break;
                   case 2:
                        $currentChoice = 'Document';
                        $currentType = '2';
                        $secondChoice = 'Brochure';
                        $secondType = '1';
                        $thirdChoice = 'Publication';
                        $thirdType = '3';
                        break;
                    case 3:
                        $currentChoice = 'Publication';
                        $currentType = '3';
                        $secondChoice = 'Brochure';
                        $secondType = '1';
                        $thirdChoice = 'Document';
                        $thirdType = '2';
                        break;
                } ?>
                <input type="hidden" name="type" id="type" value="<?php echo strtolower($currentType); ?>" />
                <div id="select-type">
                <div class="select-box" id="filter">
                  <ul>
                    <li class="current"><a href="#<?php echo $currentType; ?>"><?php echo $currentChoice; ?><i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#<?php echo $secondType; ?>"><?php echo $secondChoice; ?></a></li>
                    <li class="choice"><a href="#<?php echo $thirdType; ?>"><?php echo $thirdChoice; ?></a></li>
                  </ul>
                </div>

              </div>
            </fieldset>

             <fieldset>
                <label for="Date">Date<span>*</span></label>
            <input type="text" name="fulldate" id="fulldate" value="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Title">Title<span>*</span></label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="500" tabindex="6" />
            </fieldset>

            <fieldset class="request-checkboxes" id="permission-fileds">
                <?php $public = $ViewData["permission"] == 1 ? "checked='checked'" : ''; 
                      $notpublic = $ViewData["permission"] == 0 ? "checked='checked'" : ''; 
                ?>

                <div>
                <input type="radio" name="permission" value="1" <?php echo $public; ?> tabindex="7" /><label for="Public">Public</label>
                </div>
                <div>
                <input type="radio" name="permission" value="0" <?php echo $notpublic; ?> tabindex="8" /><label for="User Account">User Account</label>
                </div>
             
            </fieldset>

            <fieldset>
                 <label for="Description">Description</label>
                   <textarea name="description" id="description" rows="1" cols="1" minlength="10" maxlength="800" tabindex="9"><?php if($ViewData['body'] != 'none') echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset>
                <label for="Keywords">Keywords<span>*</span></label>
                <input type="text" name="keywords" id="keywords" value="<?php echo $ViewData['keywords']; ?>" class="get-value" placeholder="<?php echo $ViewData['keywords']; ?>" maxlength="500" tabindex="10" />
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE</label>
            <input type="file" name="thumbnail" tabindex="11" />
            <?php 
             if(!empty($ViewData["thumbnail"])){
                 echo "<div>";
                 echo "<img src=\"/files/literatures/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File"><span>*</span>UPLOAD FILE</label>
            <input type="file" name="up_file" id="up_file" tabindex="12" />
            <?php
              if(!empty($ViewData["filename"])){
                 echo "<div>";
                 echo $ViewData["orgfilename"];
                 echo "</div>";
               }
            ?>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="13" />
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
 $( "#fulldate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });

/*$( "form#enter-data" ).submit(function( event ) {
  console.log( $( this ).serializeArray() );
  event.preventDefault();
});*/

 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       var f = document.modifyForm;
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

