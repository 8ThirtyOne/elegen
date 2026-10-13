 <?php if($detect->isMobile()){ ?>
 <script type='text/javascript' src="<?php echo cdn; ?>/scripts/globalMobile.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/scripts/globalMobile.js'); ?>"></script>
 <?php }else{ ?>
 <script type='text/javascript' src="<?php echo cdn; ?>/scripts/global.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/scripts/global.js'); ?>"></script>
<?php } ?>
 <script async src="https://js.sitesearch360.com/plugin/bundle/9194.js"></script>
<script>
const searchDiv = document.getElementById('global-search');
const socialNav = document.getElementById('connect-social');
if(searchDiv) searchDiv.style.display = 'block';
if(socialNav) socialNav.style.display = 'block';
</script>