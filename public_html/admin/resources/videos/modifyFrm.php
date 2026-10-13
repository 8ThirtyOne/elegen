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
          $PageUrl = "/admin/resources/videos/modifyFrm";
          $PageCode = "000000";
          $bodyid = "resources";
          $FirstPageCode = substr($PageCode, 0, 2);
          $SecodeCode = substr($PageCode, 2, 2);
          $ThirdCode = substr($PageCode, 4, 2);
          if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
           $pkid = $webhelper->RequestFilter('pkid', 0, false);   
           $exists = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid); 
           if($exists > 0){
            $page = $webhelper->RequestFilter("page", 0, false);
            $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
            $order = $webhelper->RequestFilter("order", 0, false);
            $Parameter = "&searchKey=$searchKey&order=$order";
            $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT pkid, title, youtube_url, body, slugurl, thumbnail, status, DATE_FORMAT(updated,'%b %d, %Y') AS updated FROM videos WHERE pkid = $pkid ");
           }else{
            header('Location: /admin/resources/videos/list');
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
<title>Edit Video | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT VIDEO</h2>

            <form method="post" name="modifyForm" action="/admin/resources/videos/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="pkids[]"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldthumbnail" value="<?php echo $ViewData["thumbnail"]; ?>" />

            <fieldset>
                <label for="Title"><span>*</span>Title</label>
                <input type="text" name="title" value="<?php echo $ViewData['title']; ?>" class="get-value" id="title" placeholder="<?php echo $ViewData['title']; ?>" maxlength="255" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="YouTube"><span>*</span>YouTube Url</label>
                <input type="text" name="youtubeurl" id="youtube-url" value="<?php echo $ViewData['youtube_url']; ?>" class="get-value" placeholder="<?php echo $ViewData['youtube_url']; ?>" maxlength="255" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Slug Url"><span>*</span>Slug Url</label>
                <input type="text" name="slugurl" id="slug-url" value="<?php echo $ViewData['slugurl']; ?>" class="get-value" placeholder="<?php echo $ViewData['slugurl']; ?>" maxlength="255" tabindex="3" />
            </fieldset>

            <fieldset>
                 <label for="Description"><span>*</span>Description</label>
                   <textarea name="description" id="description" rows="1" cols="1" minlength="10" maxlength="800" tabindex="4"><?php if($ViewData['body'] != 'none') echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Thumbnail File"><span>*</span>THUMBNAIL FILE</label>
            <input type="file" name="thumbnail" tabindex="5" />
            <?php 
             if(!empty($ViewData["thumbnail"])){
                 echo "<div>";
                 echo "<img src=\"/files/videos/" . $ViewData["thumbnail"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="6" />
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
});
</script>

