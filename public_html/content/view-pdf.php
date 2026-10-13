<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_GET['dept']) && isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
  $urlName = trim($_GET['name']);
  $dept = trim($_GET['dept']);
  $id = $dbhelper->selectOne("SELECT pkid FROM $dept WHERE slugurl = ?", 's', $urlName);
  if($id == 0){
    header('Location: /'); 
    exit;
  }else{
    $PageUrl = "/content/view-pdf";
    $PageCode = "040102";
    $bodyid = "resources";

    $ViewData = $dbhelper->selectAll("SELECT title, filename, orgfilename, permission 
                                        FROM $dept WHERE pkid = $id AND status = 1");

    if($ViewData != null && count($ViewData) > 0){
       foreach ($ViewData as $row){
        $title = $row['title'];
        $filename = $row['filename'];
        $orgfilename = $row['orgfilename'];
        $permission = $row['permission'];
       }

       if($permission == 2){
        if($webhelper->isNull($webhelper->GetRegisterInfo())){
         //header('Location: /resources/?pkid='.$id);
         exit;
        }
       }

      if($dept == 'articles'){
       $bodyid = "company";
       $dept = "news";
      } 

       if(array_key_exists('download', $_POST)){
        $webhelper->DownloadFile("/".$dept."/", $filename, $orgfilename);
       }

       $FirstPageCode = substr($PageCode, 0, 2);
       $SecodeCode = substr($PageCode, 2, 2);
       $ThirdCode = substr($PageCode, 4, 2);
     }else{
       header('Location: /500');
       exit;
     }
  }
}else{
  header('Location: /');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title; ?> | ELEGEN</title>
<meta name="description" content="<?php echo $title; ?>" />
<?php
  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php');
?>
<style>
body{background:#414447}
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main" id="pdf-main">

    <section class="wide-section" id="pdf-header">

      <div id="pdf-header-inner">

        <div id="pdf-buttons">
          <button id="pdf-zoom-in" class="page-btn"><svg viewBox="0 0 480 480"><title>zoom out</title><path d="M220 400l40 0 0-140 140 0 0-40-140 0 0-140-40 0 0 140-140 0 0 40 140 0 0 140z" /></svg></button>
          <button id="pdf-zoom-out" class="page-btn"><svg viewBox="0 0 480 480"><title>zoom out</title><path d="M80 260l320 0 0-40-320 0 0 40z" /></svg></button>
        </div>

        <p id="page-count" class="fade-out"></p>
        <form method="POST" action="">
           <input type="submit" name="download" value="DOWNLOAD FILE" class="green-btn smooth-hover" id="pdf-download" />
        </form>

      </div>

    </section>

    <section class="wide-section" id="pdf-page">

          <div class="page-inner narrow-section">

              <section class="left-paragraph" id="pdf-wrap">

                   <div id="pdf-viewer"></div>
                   <div id="loader"></div> 
                  
              </section>


          </div>
        
     </section>

</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf_viewer.js"></script>
<script>
var url = "<?php echo cdn; ?>/files/<?php echo $dept; ?>/<?php echo $filename; ?>";
var pdfjsLib = window['pdfjs-dist/build/pdf'];
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.480/pdf.worker.min.js';
var loadingTask = pdfjsLib.getDocument(url);
var pdfDoc = null,
    pageNum = 1,
    pageRendering = false,
    pageNumPending = null,
    scale = 4,
    cntIn = 0;
function renderPage(num){
  pageRendering = true;
  pdfDoc.getPage(num).then(function(page){
    var viewport = page.getViewport(scale);
    var canvasId = 'pdf-viewer-' + num;
    var viewer = document.getElementById('pdf-viewer');
    var elem = document.createElement('canvas');
    elem.setAttribute('id',canvasId);
    viewer.append(elem);
    var canvas = document.getElementById(canvasId);
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    document.querySelectorAll('#pdf-viewer canvas').forEach( canvasDiv => { 
      canvasDiv.setAttribute('style', `float:left; width:100%`);
    });
    ctx = canvas.getContext('2d');
    var renderContext = {
      canvasContext: ctx,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function(){
      pageRendering = false;
      document.querySelectorAll('#loader').forEach(l => { 
        l.remove();
      });
      if(pageNumPending !== null){
        renderPage(pageNumPending);
        pageNumPending = null;
      }
    });
  });
}

pdfjsLib.getDocument(url).then(function(pdfDoc_){
  pdfDoc = pdfDoc_;
  renderPage(1);
  for(var i = 2; i <= pdfDoc.numPages; i++){
    renderPage(i);
    if(i > 1){
      const headerPara = document.getElementById('page-count');
      headerPara.classList.replace('fade-out','fade-in');
      headerPara.textContent = pdfDoc.numPages+' PAGES';
    }
  }
});

var zoomLevel = 1;
var updateZoom = function(zoom){
   zoomLevel += zoom;
   document.querySelector('#pdf-page .page-inner').setAttribute('style', `transform:scale(`+ zoomLevel + `,` + zoomLevel + `)`);
}

var news = 0;
var ie = 0;
var oldDiff = 0;
var currNewsTop = 0;

document.getElementById('pdf-zoom-in').addEventListener('click', function(e){
    e.preventDefault();
    var newsTop = 0;
    ie = ie - 50;
    if(cntIn < 2){
    document.querySelector('#pdf-zoom-out svg').setAttribute('style', `fill:#0e3455; cursor:pointer;`);
      updateZoom(0.1);
      cntIn++;
      if(cntIn == 2) this.childNodes[0].setAttribute('style', `fill:#bbb; cursor:default;`);
    }
});

var oldDiffOut = 0;
document.getElementById('pdf-zoom-out').addEventListener('click', function(e){
    e.preventDefault();
    if(cntIn > 0){
      document.querySelector('#pdf-zoom-in svg').setAttribute('style', `fill:#0e3455; cursor:pointer;`);
      ie = ie + 50;
      updateZoom(-0.1);
      cntIn--; 
    }
    if(cntIn == 0) this.childNodes[0].setAttribute('style', `fill:#bbb; cursor:default;`);
});
</script>
</body>
</html>