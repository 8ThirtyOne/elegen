<?php
include_once('../../../lcmodel/loadPage.inc.php');
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
        $PageUrl = "/admin/products/";
        $PageCode = "040000";
        $bodyid = "products";
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        if($webhelper->isNull($page)) $page = 1;
        if($webhelper->isNull($searchKey)) $searchKey = "";
        if($webhelper->isNull($order)) $order = 0;
        $Parameter = "&searchKey=$searchKey&order=$order";
        $FirstPageCode = substr($PageCode, 0, 2);
        $SecodeCode = substr($PageCode, 2, 2);
        $ThirdCode = substr($PageCode, 4, 2);
        $insert = false;
        $update = false;
        $error = array();
        $hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'products'");
        if(array_key_exists('heroSubmit', $_POST)){
           $filename = $_FILES['desktop']['name'];
           $ext = pathinfo($filename, PATHINFO_EXTENSION);
           if(empty($hero['desktop']) && empty($hero['mobile'])){
              if(!empty($_FILES['desktop']['name']) && !empty($_FILES['mobile']['name'])){ 
                 if($ext == 'mp4'){
                   $desktop = $webhelper->UploadFile("desktop", "/hero/");
                   $orgfilename = $desktop['orgfilename'];
                 }else{
                   $desktop = $webhelper->UploadFile("desktop", "/hero/", true);
                   $orgfilename = '';
                 }
                 $mobile = $webhelper->UploadFile("mobile", "/hero/", true);
                 $insert = $dbhelper->insertHero($desktop['filename'], $orgfilename, $mobile['filename'], 'products');
                 if($insert){
                    header('Location: /admin/products/?page='.$page.$Parameter);
                    exit;
                 }else{
                    $error[] = "Upload did not go through, Try Again.";
                 }
               }else{
                 $error[] = "Both images are required";
               }
              }else{
                  if($ext == 'mp4'){
                    $desktop = $webhelper->UploadFile("desktop", "/hero/");
                    $oldOrgFilename = $hero["orgfilename"];
                  }else{
                    $desktop = $webhelper->UploadFile("desktop", "/hero/", true);
                    $oldOrgFilename = '';
                  }
                  $olddesktop = $hero["desktop"];
                  if($desktop != null){
                    if(!empty($olddesktop))
                       $webhelper->DeleteFile("/hero/", $olddesktop);
                       $newDesktopFileName = $desktop["filename"];
                       $newOrgFileName = $ext == 'mp4' ? $desktop["orgfilename"] : '';
                  }else{
                      $newDesktopFileName = $olddesktop;
                      $newOrgFileName = $oldOrgFilename;
                  }
                  $mobile = $webhelper->UploadFile("mobile", "/hero/", true);
                  $oldmobile = $hero["mobile"];
                  if($mobile != null){
                    if(!empty($oldmobile))
                      $webhelper->DeleteFile("/hero/", $oldmobile);
                      $newMobileFileName = $mobile["filename"];
                  }else{
                      $newMobileFileName = $oldmobile;
                  }
                  $update = $dbhelper->updateHero($newDesktopFileName, $newOrgFileName, $newMobileFileName, 'products', $hero['pkid']);
                  if($update){
                    header('Location: /admin/products/?page='.$page.$Parameter);
                    exit;
                  }else{
                    $error[] = "Upload did not go through, Try Again.";
                  }
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
<title>ADMIN PRODUCTS | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php'); ?> 
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

         <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <div id="search-data">

            <h2>HIGH FIDELITY PAGE</h2>

            <?php
                if(isset($_POST['heroSubmit'])){
                echo '<ul id="upload-warning">';
                 if(isset($error)){
                   foreach ($error as $e){
                     echo "<strong><li class='warn'>$e</li></strong>";
                     }
                   }
                echo '</ul>';
              }  
             ?> 

            <form method="post" name="heroFrm" id="hero-form" enctype="multipart/form-data">
                <fieldset class="upload-field">
                    <label for="Thumbnail File"><span>*</span>DESKTOP HERO</label>
                    <?php
                      if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
                      if(!empty($hero["orgfilename"])){
                         echo "<div>";
                         echo $hero["orgfilename"];
                         echo "</div>";
                       }
                       if(!empty($hero["desktop"]) && $ext != 'mp4'){
                        echo "<div>";
                         echo "<img src=\"/files/hero/" . $hero["desktop"] . "\">";
                         echo "</div>";
                       }
                    ?>
                    <input type="file" name="desktop">
                </fieldset>

                <fieldset class="upload-field">
                    <label for="Upload File"><span>*</span>MOBILE HERO</label>
                    <?php
                      if(!empty($hero["mobile"])){
                         echo "<div>";
                         echo "<img src=\"/files/hero/" . $hero["mobile"] . "\">";
                         echo "</div>";
                       }
                    ?>
                    <input type="file" name="mobile">
                </fieldset>
                <fieldset id="hero-submit">
                <input type="submit" name="heroSubmit" value="UPLOAD" class="global-btn green-btn smooth-hover" />
            </fieldset>

            </form>

        </div>

     </div>

  </div>

</section>

</main>
<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>

</body>
</html>