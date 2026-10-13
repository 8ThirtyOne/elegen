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
      $PageUrl = "/admin/news-events/news/modifyFrm";
      $PageCode = "000000";
      $bodyid = "news";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT title FROM articles WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM articles WHERE pkid = $pkid ");
       }else{
        header('Location: /admin/news-events/news/list');
        exit;
       }
      }
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
<title>Edit News | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT NEWS</h2>

            <form method="post" name="modifyForm" action="/admin/news-events/news/modify" id="enter-data" enctype="multipart/form-data">
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
                        $currentChoice = 'News';
                        $currentType = '1';
                        $secondChoice = 'Podcast';
                        $secondType = '2';
                        break;
                    case 2:
                        $currentChoice = 'Podcast';
                        $currentType = '2';
                        $secondChoice = 'News';
                        $secondType = '1';
                        break;
                } ?>
                <input type="hidden" name="type" id="type" value="<?php echo strtolower($currentType); ?>" />
                <div id="select-type">

                 <div class="select-box" id="filter">
                  <ul>
                   <li class="current"><a href="#<?php echo $currentType; ?>"><?php echo $currentChoice; ?><i class="fa fa-chevron-circle-down"></i></a></a></li>
                    <li class="choice"><a href="#<?php echo $secondType; ?>"><?php echo $secondChoice; ?></a></li>
                  </ul>
                 </div>

                </div>

                <div class="request-checkboxes">
                    <?php  
                      $isSlide = $ViewData["isSlide"] == 1 ? "checked='checked'" : ''; 
                      $isBanner = $ViewData["isBanner"] == 1 ? "checked='checked'" : '';
                    ?>
                    <div>
                    <input type="checkbox" name="sb[0]" value="1" <?php echo $isSlide; ?> tabindex="1" /><label for="Homepage Slider">Homepage Slider</label>
                    </div>
                    <div>
                    <input type="checkbox" name="sb[1]" id="news-banner" value="1" <?php echo $isBanner; ?> tabindex="2" /><label for="Homepage Banner">Homepage Banner</label>
                    </div>

                </div>

            </fieldset>

             <fieldset>
                <label for="Date">Date<span>*</span></label>
            <input type="text" name="fulldate" id="fulldate" value="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['month'].'-'.$ViewData['day'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Source">Source<span>*</span></label>
                <input type="text" name="source" value="<?php echo $ViewData['source']; ?>" class="get-value" id="source" placeholder="<?php echo $ViewData['source']; ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Url">Url<span>*</span></label>
                <input type="text" name="url" value="<?php echo $ViewData['url']; ?>" class="get-value" id="url" placeholder="<?php echo $ViewData['url']; ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Main Title">Main Title<span>*</span></label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="main-title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Subitle">Subtitle<span>*</span></label>
                <input type="text" name="subtitle" value="<?php echo stripcslashes($ViewData['subtitle']); ?>" class="get-value" id="subtitle" placeholder="<?php echo stripcslashes($ViewData['subtitle']); ?>" maxlength="500" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Slug Url">Slug Url<span>*</span></label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="500" tabindex="6" />
            </fieldset>

            <fieldset>
                 <label for="Description">Description</label>
                   <textarea name="description" id="description" rows="1" cols="1" minlength="10" maxlength="800" aria-required="true" class="get-value" tabindex="9"><?php echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE</label>
            <input type="file" name="thumbnail" tabindex="11" />
            <?php 
             if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/news/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File"><span>*</span>UPLOAD FILE</label>
            <input type="file" name="up_file" id="up_file" tabindex="12" />
            <?php
              if(!empty($ViewData["filename"]) && $ViewData["filename"] != 'none'){
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
 
 document.querySelector('#field-one .request-checkboxes').style.display = 'block';
 <?php if($ViewData['type'] == 2){ ?> 
    document.getElementById('news-banner').disabled = true;
 <?php } ?>

 $( "#fulldate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });

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
      if(filter == 1){
       document.getElementById('news-banner').disabled = false;
      }
      if(filter == 2){
       document.getElementById('news-banner').disabled = true;
      }
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

