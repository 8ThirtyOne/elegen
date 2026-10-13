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
      $PageUrl = "/admin/news-events/events/modifyFrm";
      $PageCode = "000000";
      $bodyid = "news";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT title FROM events WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM events WHERE pkid = $pkid ");
       }else{
        header('Location: /admin/news-events/events/list');
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

            <form method="post" name="modifyForm" action="/admin/news-events/events/modify" id="enter-data" enctype="multipart/form-data">
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
                        $currentChoice = 'Event';
                        $currentType = '1';
                        break;
                } ?>
                <input type="hidden" name="type" id="type" value="<?php echo strtolower($currentType); ?>" />
                <div id="select-type">

                 <div class="select-box" id="filter">
                  <ul>
                   <li class="current"><a href="#<?php echo $currentType; ?>"><?php echo $currentChoice; ?><i class="fa fa-chevron-circle-down"></i></a></a></li>
                  </ul>
                 </div>

                </div>

            </fieldset>

             <fieldset>
                <label for="Start Date"><span>*</span>Start Date</label>
                <input type="text" name="startdate" id="startdate" value="<?php echo $ViewData['startmonth'].'-'.$ViewData['startday'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['startmonth'].'-'.$ViewData['startday'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="End Date"><span>*</span>End Date</label>
                <input type="text" name="enddate" id="enddate" value="<?php echo $ViewData['endmonth'].'-'.$ViewData['endday'].'-'.$ViewData['year']; ?>" class="date-field get-value" placeholder="<?php echo $ViewData['endmonth'].'-'.$ViewData['endday'].'-'.$ViewData['year']; ?>" maxlength="4" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Main Title"><span>*</span>Main Title</label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="main-title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="500" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Subitle"><span>*</span>Subtitle</label>
                <input type="text" name="subtitle" value="<?php echo $ViewData['subtitle']; ?>" class="get-value" id="subtitle" placeholder="<?php echo $ViewData['subtitle']; ?>" maxlength="500" tabindex="4" />
            </fieldset>

            <fieldset>
                <label for="Address"><span>*</span>Address</label>
                <input type="text" name="address" value="<?php echo $ViewData['address']; ?>" class="get-value" id="source" placeholder="<?php echo $ViewData['address']; ?>" maxlength="255" tabindex="5" />
            </fieldset>

            <fieldset>
                <label for="Location"><span>*</span>Location</label>
                <input type="text" name="locationone" value="<?php echo $ViewData['location1']; ?>" id="location-one" class="get-value" placeholder="<?php echo $ViewData['location1']; ?>" maxlength="250" tabindex="6" />
            </fieldset>

            <fieldset>
                <label for="Conference Url"><span>*</span>Conference Url</label>
                <input type="text" name="url" value="<?php echo $ViewData['url']; ?>" class="get-value" id="url" placeholder="<?php echo $ViewData['url']; ?>" maxlength="500" tabindex="7" />
            </fieldset>

            <fieldset>
                <label for="Booth"><span>*</span>Booth</label>
                <input type="text" name="booth" value="<?php echo $ViewData['booth']; ?>" class="get-value" id="booth" placeholder="<?php echo $ViewData['booth']; ?>" maxlength="60" tabindex="8" />
            </fieldset>

            <fieldset>
                <label for="Slug Url"><span>*</span>Slug Url</label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['eventurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['eventurl']; ?>" maxlength="500" tabindex="9" />
            </fieldset>

            <fieldset>
                 <label for="Description"><span>*</span>Description</label>
                   <textarea name="description" id="description" rows="1" cols="1" minlength="10" maxlength="800" aria-required="true" class="get-value" tabindex="10"><?php echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE</label>
            <input type="file" name="thumbnail" tabindex="11" />
            <?php 
             if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/events/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset class="upload-field">
            <label for="Upload File">UPLOAD FILE</label>
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
 $( "#startdate" ).datepicker({
    dateFormat: 'mm-dd-yy'
 });
 $( "#enddate" ).datepicker({
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
