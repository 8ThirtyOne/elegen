<?php
namespace lcmodel\processDB;

class opendb{
 protected $_conn;
 public function __construct($host, $user, $pass, $db){
  $this->_conn = mysqli_connect($host, $user, $pass, $db);
  if(mysqli_connect_errno()){
      header('Location: /500');
    }
 }

 public function __destruct(){
 $this->_conn->close();
 }
}