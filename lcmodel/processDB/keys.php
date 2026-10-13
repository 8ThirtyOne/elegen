<?php
/*--------------------------------------------------------------------------------------------------
This class extends database connection class and keeps credidentails separate from db classes.
*/
namespace lcmodel\processDB;

include('db_keys.inc.php');
abstract class keys extends opendb{
 public function __construct($DB){
   if($DB == 'user'){
      parent::__construct(HOST, USER, PASS, DBNAME);
     }
  }
}