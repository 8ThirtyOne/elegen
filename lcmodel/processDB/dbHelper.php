<?php
namespace lcmodel\processDB;

class dbHelper extends keys{
    protected $OK = false;

    public function RunSQLReturnRows($sql){
        $rowList = array();
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
                $this->throwException($sql);
            }
            $rowcnt = 0;
            while($row = $result->fetch_assoc()){
                $rowList[$rowcnt++] = $row;
            }
            $result->free();
        } catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
        return $rowList;
    }

    public function RunSQLReturnOneRow($query){
        try{
            $select = $this->_conn->query($query);
            if(!$select){
              header('Location: /500');
              exit;
            }
            $rowList = null;
            $rowList = $select->fetch_assoc();
            $select->free();
            return $rowList;
        }catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
    }

     public function RunSQL($sql){
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
                $this->throwException($sql);
            }
        }catch(Exception $ex){
            header('Location: /500');
            exit;
        }
    }

    public function RunSQLReturnRowsSub($sql, $RequestPage, $PageSize, &$TotalCount){
        $limit = ($RequestPage-1) * $PageSize;
        $sql = preg_replace('/select/i', 'select SQL_CALC_FOUND_ROWS ', $sql, 1);
        $sql = $sql." limit ".$limit.", ".$PageSize;
        $rowList = array();
        try{
            $result = mysqli_query($this->_conn, $sql);
            if (!$result){
                $this->throwException($sql);
            }
            $rowcnt = 0;
            while ($row = $result->fetch_assoc()){
                $rowList[$rowcnt++] = $row;
            }
            $result->free();
            //Get Total Record Count
            $countList = mysqli_query($this->_conn, "select FOUND_ROWS() as cnt;");
            $countRow = $countList->fetch_assoc();
            $TotalCount = $countRow["cnt"];
            $countList->free();
        } catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
        return $rowList;
    }
    
    public function RunSQLReturnID($sql){
        $rowList = null;
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
               $this->throwException($sql);
            } 
            $sql = "select LAST_INSERT_ID() as pkid";
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
               $this->throwException($sql);
            }
            $rowList = $result->fetch_assoc();
            $result->free();
        } catch (Exception $ex){
            header('Location: /500');
            exit;
        }
        return $rowList["pkid"];
    }
    
    //INSERT DATA WHEN SAFE
    public function insertAll($query){
        $OK = $this->_conn->query($query);         
        return $OK;   
    } 
    //check if any rows exist when input is safe
    public function safeRows($sql){              
       $seek = $this->_conn->query($sql);
       $num = $seek->num_rows;
       return $num;
    }
    
    //check if any rows exist when input is not safe
     public function numOfRows($sql, $type, $input){
        $stmt = $this->_conn->stmt_init();
        if($stmt->prepare($sql)){
          $stmt->bind_param($type, $input);
          $OK = $stmt->execute();
          $stmt->store_result();
          $result = $stmt->num_rows;
         }
        return $result; 
     }
     
    public function RunAndReturnEventId($sql){
        $rowList = null;
        
        try{
            $result = mysqli_query($this->_conn, $sql);
            if(!$result){
              $this->throwException($sql);
            }
            $sql = "select LAST_INSERT_ID() as eid";
            $result = mysqli_query($this->dbCon, $sql);
            if(!$result){
               $this->throwException($sql);
            }
            $rowList = $result->fetch_assoc();
            $result->free();
        }catch (Exception $ex) {
            header('Location: /500');
            exit;
        }
        return $rowList["eid"];
     }

      public function selectAll($query){
           try{
             $select = $this->_conn->query($query);
             if(!$select){
                header('Location: /500');
                exit;
               }
             $data = array();
             while($row = $select->fetch_assoc()){
                   $data[] = $row;
                  }
             return $data;
           }
           catch (Exception $ex) {
              header("Location: /500");
              exit;
           }
         }
    
     public function selectOne($query, $type, $input){
       if($type == '' && $input == ''){
         return $this->noInput($query);
        }
       else{
         return $this->withInput($query, $type, $input);
        }
      }
      
     private function noInput($query){
        $stmt = $this->_conn->stmt_init();
        if($stmt->prepare($query)){
          $stmt->bind_result($result);
          $OK = $stmt->execute();
          $stmt->fetch();
          $stmt->free_result();
         }
        return $result;
       }
   
     private function withInput($query, $type, $input){
        $stmt = $this->_conn->stmt_init();
        if($stmt->prepare($query)){
          $stmt->bind_param($type, $input);
          $stmt->bind_result($result);
          $OK = $stmt->execute();
          $stmt->fetch();
          $stmt->free_result();
         }
        return $result;
       }

     public function updateOne($query, $type, $value, $input){ 
       $stmt = $this->_conn->stmt_init(); 
       if($stmt->prepare($query)){
         $stmt->bind_param($type, $value, $input);
         $OK = $stmt->execute();
         $stmt->free_result();
        }
       return $OK;
      }
           
      public function updateAll($query){ 
       $OK = $this->_conn->query($query);  
       return $OK;
      }

      
      public function deleteOne($query, $type, $input){ 
        $stmt = $this->_conn->stmt_init();           
        if($stmt->prepare($query))
          {   
           $stmt->bind_param($type, $input);
           $OK = $stmt->execute();
          }
         return $OK;
      }

      public function deleteAll($query){ 
       $OK = $this->_conn->query($query);  
       return $OK;
      }

    //CUSTOM QUERIES
    public function insertHero($desktop, $orgfilename, $mobile, $page){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO hero_images(status, desktop, orgfilename, mobile, page_name, created) 
                    VALUES (0,?,?,?,?, NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssss', $desktop, $orgfilename, $mobile, $page);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    public function updateHero($desktop, $orgfilename, $mobile, $page, $pkid){
        $stmt = $this->_conn->stmt_init(); 
        $update = "UPDATE hero_images SET desktop = ?, orgfilename = ?, mobile = ?, page_name = ?, updatedate = NOW() WHERE pkid = ?";
        if($stmt->prepare($update)){
           $stmt->bind_param('ssssi', $desktop, $orgfilename, $mobile, $page, $pkid);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    public function webSubscriber($first, $last, $email, $status){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO web_subscribers (firstname, lastname, email, status, updated, created) VALUES (?,?,?,?, NOW(), NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('sssi', $first, $last, $email, $status);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    
     public function userIn($id, $pass, $salt, $email){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO member (id, pass, salt, email, status, isAuthenticated, isReader, isAdministrator, isSystemAdmin, isContentAdmin, isEditor, isContentContributor, isNotify) 
                   VALUES (?, ?, ?, ?, '0', '0', '0', '0', '0', '0', '0', '0', '0')";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssis', $id, $pass, $salt, $email);
           $OK = $stmt->execute();
          }
         return $OK;
    }
    
    public function userAdminIn($id, $pass, $salt, $email, $first, $last, $company, $country, $state, $city, $zip, $phone, $isAdmin, $isEditor, $isHR, $status){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO admin (id, pass, salt, email, firstname, lastname, company, country, providence, city, postcode, phone, isAdministrator, isEditor, isHR, status, updated, regdate, logindate)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), NOW())";
        if($stmt->prepare($insert)){
           $stmt->bind_param('ssisssssssssiiii', $id, $pass, $salt, $email, $first, $last, $company, $country, $state, $city, $zip, $phone, $isAdmin, $isEditor, $isHR, $status);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function visitorRequest($first, $last, $email, $company, $country, $zip, $phone, $inquiry, $news, $refpage){
        $stmt = $this->_conn->stmt_init(); 
        $insert = "INSERT INTO visitor (firstname, lastname, email, company, country, zip, phone, inquiry, newsletter, updated, created, status, referrer) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(),NOW(),'0',?)";
        if($stmt->prepare($insert)){
           $stmt->bind_param('sssssissis', $first, $last, $email, $company, $country, $zip, $phone, $inquiry, $news, $refpage);
           $OK = $stmt->execute();
          }
         return $OK;
    }

    public function documentIn($data, $thumbnail, $filename, $orgfilename, $permission){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO literatures (type, title, slugurl, body, keywords, month, day, year, thumbnail, filename, orgfilename, permission, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('issssssssssi', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $thumbnail, $filename, $orgfilename, $permission);
          $OK = $stmt->execute();
        }  
        return $OK;
    }
    public function newsIn($data, $thumbnail, $filename, $orgfilename, $isSlide, $isBanner){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO articles (month, day, year, source, url, title, subtitle, slugurl, body, thumbnail, filename, orgfilename, type, status, updatedate, created, permission, isSlide, isBanner) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW(), '1', ?, ?)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssssssssssssiii', $data[7], $data[8], $data[9], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $thumbnail, $filename, $orgfilename, $data[0], $isSlide, $isBanner);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function eventIn($data, $thumbnail, $filename, $orgfilename){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO events (type, startmonth, startday, year, endmonth, endday, title, subtitle, address, location1, url, booth, eventurl, body, thumbnail, filename, orgfilename, status, updatedate, created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW())";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssssssssssssssssi', $data[0], $data[9], $data[10], $data[11], $data[12], $data[13], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $thumbnail, $filename, $orgfilename);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

   public function pressIn($data, $thumbnail, $filename, $orgfilename){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO press (month, day, year, source, url, title, subtitle, slugurl, body, thumbnail, filename, orgfilename, type, status, updatedate, created, permission) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '0', NOW(), NOW(), '1')";
        if($stmt->prepare($insert)){
          $stmt->bind_param('ssssssssssssi', $data[7], $data[8], $data[9], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $thumbnail, $filename, $orgfilename, $data[0]);
          $OK = $stmt->execute();
        }  
        return $OK;
    }
    public function teamIn($data, $headshotImg, $hobbyImg, $slugUrl){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO employee_profile (first, last, job_title, quote, body, hobby, headshot, hobby_thumb, slugurl, updated, created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 0)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('sssssssss', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $headshotImg, $hobbyImg, $slugUrl);
          $OK = $stmt->execute();
        }  
        return $OK;
    }

    public function videoIn($data, $thumbnail){
        $stmt = $this->_conn->stmt_init();
        $insert = "INSERT INTO videos (title, youtube_url, slugurl, body, thumbnail, updated, created, status) VALUES (?,?,?,?,?,NOW(),NOW(),0)";
        if($stmt->prepare($insert)){
          $stmt->bind_param('sssss', $data[0], $data[1], $data[2], $data[3], $thumbnail);
          $OK = $stmt->execute();
        }  
        return $OK;
    }
}
?>