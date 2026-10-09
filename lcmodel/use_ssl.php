<?php
define('SSL_ON', 'yes');

if(SSL_ON == 'yes' && getenv('HTTPS') != 'on')
  {
   header('Location: https://'.getenv('SERVER_NAME').getenv('REQUEST_URI'));
   exit();
  }