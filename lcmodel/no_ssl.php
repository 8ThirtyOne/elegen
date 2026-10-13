<?php
define('SSL_ON', 'no');

if(SSL_ON == 'no' && getenv('HTTPS') == 'on')
  {
   header('Location: http://'.getenv('SERVER_NAME').getenv('REQUEST_URI'));
   exit();
  }