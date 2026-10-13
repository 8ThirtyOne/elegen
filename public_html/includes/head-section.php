  <meta charset="utf-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
     <meta name="robots" content="noindex,nofollow">
  <meta name="AdsBot-Google" content="noindex,nofollow">
  <meta name="format-detection" content="telephone=no" />
  <link rel="icon" type="image/png" href="/img/common/icon-elegen-64.png">
  <link rel="shortcut icon" href="/img/common/icon-elegen-64.ico">
  <link rel="icon" type="image/png" href="">
  <link rel="shortcut icon" href="">
  <link rel="apple-touch-icon" href="/img/common/elegen-icon.png">
  <link rel="dns-prefetch" href="">
  <link rel="preconnect" href="https://www.google-analytics.com">
  <link rel="dns-prefetch" href="https://www.google-analytics.com">
  <link rel="preconnect" href="https://ssl.geoplugin.net">
  <link rel="dns-prefetch" href="https://ssl.geoplugin.net">
  <link rel="preconnect" href="https://connect.facebook.net">
  <link rel="dns-prefetch" href="https://connect.facebook.net">
 <link rel="stylesheet" href="https://use.typekit.net/pip4jih.css">
<script src="https://kit.fontawesome.com/ade4d12ab4.js" crossorigin="anonymous"></script>
  <link rel="preload" href="<?php echo cdn ?>/scripts/main.min.js?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/scripts/main.min.js'); ?>" as="script">
  <?php $ip = $webhelper->catchIP(); 
  $min = ''; // .min
  if($ip == '99.45.170.117' || $ip == '99.24.229.203'){ ?>
      <link rel="preload" href="/styles/global<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/global'.$min.'.css'); ?>" as="style">
      <link rel="stylesheet" type="text/css" href="/styles/global<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/global'.$min.'.css'); ?>" />
      <?php
      if($FirstPageCode == "00"){ 
      ?>
         <link rel="preload" href="/styles/home<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/home'.$min.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/home<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/home'.$min.'.css'); ?>" />
      <?php 
      }else if($FirstPageCode == "01"){ 
      ?> 
         <link rel="stylesheet" type="text/css" href="/styles/applications.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/applications.css'); ?>" />
      <?php
      }else if($FirstPageCode == "02"){ 
      ?>
         <link rel="preload" href="/styles/products<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/products'.$min.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/products<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/products'.$min.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "03"){
      ?>
         <link rel="preload" href="/styles/news<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/news'.$min.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/news<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/news'.$min.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "04"){
      ?>
         <link rel="preload" href="/styles/resources<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/resources'.$min.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/resources<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/resources'.$min.'.css'); ?>" />
      <?php
      }else if($FirstPageCode == "05"){ 
      ?> 
         <link rel="preload" href="/styles/support<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/support'.$min.'.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/support<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/support'.$min.'.css'); ?>" />
       <?php 
      }else if($FirstPageCode == "06"){ 
      ?>
          <link rel="preload" href="/styles/company<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/company'.$min.'.css'); ?>" as="style">
          <link rel="stylesheet" type="text/css" href="/styles/company<?php echo $min ?>.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/company'.$min.'.css'); ?>" />
      <?php
      }
  }else{ ?>
      <link rel="preload" href="<?php echo cdn ?>/styles/global.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/global.min.css'); ?>" as="style">
      <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/global.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/global.min.css'); ?>" />
      <?php
      if($FirstPageCode == "00"){
      ?>
         <link rel="preload" href="/styles/main.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/main.min.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/home.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/home.min.css'); ?>" />
      <?php 
      }else if($FirstPageCode == "01"){ 
      ?> 
         <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/applications.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/applications.css'); ?>" />
      <?php
      }else if($FirstPageCode == "02"){ 
      ?>
         <link rel="preload" href="<?php echo cdn ?>/styles/products.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/products.min.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/products.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/products.min.css'); ?>" />
      <?php
      }else if($FirstPageCode == "03"){
      ?>
         <link rel="preload" href="/styles/news.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/news.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/news.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/news.css'); ?>" />
      <?php
      }else if($FirstPageCode == "04"){
      ?>
          <link rel="preload" href="/styles/resources.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/resources.min.css'); ?>" as="style">
         <link rel="stylesheet" type="text/css" href="/styles/resources.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/resources.min.css'); ?>" />
      <?php
      }else if($FirstPageCode == "05"){
      ?> 
        <link rel="preload" href="<?php echo cdn ?>/styles/support.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/support.min.css'); ?>" as="style">
        <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/support.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/support.min.css'); ?>" />
       <?php 
      }else if($FirstPageCode == "06"){
      ?>
       <link rel="preload" href="<?php echo cdn ?>/styles/company.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/company.min.css'); ?>" as="style">
       <link rel="stylesheet" type="text/css" href="<?php echo cdn ?>/styles/company.min.css?v=<?php echo @ filemtime($_SERVER['DOCUMENT_ROOT'].'/styles/company.min.css'); ?>" />
      <?php
      }
    }
  ?>