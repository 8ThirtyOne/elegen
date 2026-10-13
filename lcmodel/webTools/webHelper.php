<?php
namespace lcmodel\webTools;
use lcmodel\webTools\PageHelper;
use lcmodel\webTools\RowHelper;

class WebHelper{
    private $SECURITY_KEY =  "cshbi90:securitykey:commonmodule"; //do not modify this value
    private $LoginMinute = 60; //if you want login time change that you can change this value. 60 means 1 hr.

    //ADD HOME DIRECTORY THAT POINTS TO /public_html eg. /home/elegenbio.com/public_html/files
    private $UploadPath = "/var/www/8romans.com/elegen/public_html/files"; 

    //ToDo : ADD DOMAIN URL NAME HERE
    public $Domain = "elegen.8romans.com";  //=> "elegen.8romans.com"
    public $HomeURL = "/";            //==> "/"

    public $invCaptchaPublic = "6LcozOQiAAAAAAZGqgfz5_Fk5e0YYzGV4K4eDH_w";
    public $invCaptchaPrivate = "6LcozOQiAAAAAAnt5s6C51XABbhihs7BUi35s5sr";

    private $_ip;

    public function getPaging($RecordCount, $RequestPage, $PageSize)
    {
        $j = 0; $k; $start;
        $pagehelper = new PageHelper();

        try{
            $pagehelper->RecordCount = $RecordCount;
            $pagehelper->PageCount = (int)($pagehelper->RecordCount / $PageSize);
            if( ($pagehelper->RecordCount % $PageSize) != 0 )
                $pagehelper->PageCount++;

            if($pagehelper->RecordCount > 0 )
            {
                if ($RequestPage <= $pagehelper->PageCount)
                {
                    $start = (int)(($RequestPage - 1) / 10) * 10 + 1;

                    if ($start > 10)
                        $pagehelper->PreTen = $start - 10;
                    else
                        $pagehelper->PreTen = 0;

                    if($RequestPage > 1)
                        $pagehelper->prev = $RequestPage - 1;
                    else
                        $pagehelper->prev = 1;


                    for ($k = $start, $j = 0; $k <= $pagehelper->PageCount; $k++)
                    {
                        $j++;
                        $pagehelper->PageRtn[$j] = $k;
                        if ($j >= 10) break;
                    }

                    if( $RequestPage > $pagehelper->PageCount)
                        $pagehelper->next = $RequestPage + 1;
                    else
                        $pagehelper->next = $pagehelper->PageCount;

                    if ($pagehelper->PageCount - $start >= 10)
                        $pagehelper->NextTen = $start + 10;
                    else
                        $pagehelper->NextTen = 0;
                }
            }

            return $pagehelper;
        } catch (Exception $ex) {
            throw new Exception( 'PageHelper Error : '.$ex->getMessage() );
        }
    }

    function SqlInjection($str)
    {
        $str = str_replace("--","­­",$str);
        $str = str_replace(" or "," ｏr ",$str);
        $str = str_replace(" and "," ａnd ",$str);
        $str = str_replace("select","ｓelect",$str);
        $str = str_replace("union","ｕnion",$str);
        $str = str_replace("insert","ｉnsert",$str);
        $str = str_replace("update","ｕpdate",$str);
        $str = str_replace("delete","ｄelete",$str);
        $str = str_replace("create","ｃreate",$str);
        $str = str_replace("alter","ａlter",$str);
        $str = str_replace("drop","ｄrop",$str);
        $str = str_replace("exec","ｅxec",$str);

        return $str;
    }

    function XSS($str)
    {
        $str = str_ireplace ("script","ｓcript",$str);
        $str = str_ireplace ("javascript","javaｓcript",$str);
        $str = str_ireplace ("vbscript","vbｓcript",$str);
        $str = str_ireplace ("onload","onlａod",$str);
        $str = str_ireplace ("onclick","onｃlick",$str);
        $str = str_ireplace ("onsubmit","onｓubmit",$str);
        $str = str_ireplace ("onmouseover","onmouｓeover",$str);
        $str = str_ireplace ("mocha","mocha",$str);
        $str = str_ireplace ("behaviour","behaviour",$str);
        $str = str_ireplace ("binding","bｉnding",$str);
        $str = str_ireplace ("expression","expreｓsion",$str);
        $str = str_ireplace ("document","ｄocument",$str);


        return $str;
    }

 public function RequestChecker($InputString, $valid, $isHTML)
    {
        $retVal;

        $retVal = $InputString;

        try
        {
            if ($InputString != "" && $InputString != null)
            {
                switch ($valid)
                {
                    case 0:
                        if( !is_numeric($InputString) )
                        $this->AlertMessageAndHistoryBack("Not a Number Error.");
                        $retVal = $InputString;
                        break;
                    case -1:
                        //$InputString = $this->SqlInjection($InputString);
                        //$InputString = $this->XSS($InputString);
                        $notallowed = "(`|\\\\)";
                        if(preg_match($notallowed, $InputString)) $this->AlertMessageAndHistoryBack("There are some input characters which are not alowed.");
                        $InputString = str_ireplace("'", "\'", $InputString);
                        if (!$isHTML)
                        {
                            //$InputString = str_ireplace("\\", "&quot;", $InputString);
                            $InputString = str_ireplace("<", "&lt;", $InputString);
                            $InputString = str_ireplace(">", "&gt;", $InputString);
                            //$InputString = str_ireplace(" ", "&nbsp;", $InputString);
                        }

                        $retVal = $InputString;
                        break;
                    default:
                        if (strlen($InputString) > $valid)
                        {
                            //throw new Exception( 'WebHelper Error: input length is too long' );
                            $this->AlertMessageAndHistoryBack("Your Message is too long.");
                        }
                        else
                        {
                            //$InputString = $this->SqlInjection($InputString);
                            //$InputString = $this->XSS($InputString);
                            $InputString = str_ireplace("'", "\'", $InputString);

                            if (!$isHTML)
                            {
                                //$InputString = str_ireplace("\\", "&quot;", $InputString);
                                $InputString = str_ireplace("<", "&lt;", $InputString);
                                $InputString = str_ireplace(">", "&gt;", $InputString);
                                //$InputString = str_ireplace(" ", "&nbsp;", $InputString);
                            }

                            $retVal = $InputString;
                        }
                        break;
                }
            }

            return $retVal;
        }
        catch (Exception $e)
        {
                throw new Exception( 'WebHelper Error' );
        }
    }

    public function RequestFilter($name, $size, $isHTML)
    {
        $retVal;

        if (isset($_POST[$name]))
        {
            $retVal = $_POST[$name];
        }else
        {
            if(!isset($_GET[$name]))
                $retVal = '';
            else
                $retVal = $_GET[$name];
        }

        if(isset($_SESSION[$name])){
            $retVal = $_SESSION[$name];
        }

        if ($retVal != null && $retVal != '')
        {
            $retVal = $this->RequestChecker($retVal, $size, $isHTML);
        }

        return $retVal;
    }
    
    public function RequestFilterMulti($name, $size, $isHTML)
    {
        $retVal=array();

        if( $_SERVER['REQUEST_METHOD'] == "GET" )
        {
            $retVal = null;
        }else
        {
            if(!isset($_POST[$name]))
            {
                $retVal = null;
            }else
            {
                $retVal = $_POST[$name];
                for( $i=0; $i<count($retVal); $i++)
                {
                    $retVal[$i] = $this->RequestChecker($retVal[$i], $size, $isHTML);
                }
            }
        }
        return $retVal;
    }

    private function utf8_length($str)
    {
        $len = strlen($str);
        for ($i = $length = 0; $i < $len; $length++)
        {
            $high = ord($str[$i]);
            if ($high < 0x80)
                $i += 1;
            else if ($high < 0xE0)
                $i += 2;
            else if ($high < 0xF0)
                $i += 3;
            else
                $i += 4;
        }
        return $length;
   }

   public function CurRightString($InputString, $MaxLen, $AddString = '...')
   {
        if ($this->utf8_length($InputString) <= $MaxLen)
            $AddString = '';
        else
            $MaxLen -= $this->utf8_length($AddString);

        $len = strlen($InputString);
        for ($i = $adapted = 0; $i < $len; $adapted = $i)
        {
            $high = ord($InputString[$i]);
            if ($high < 0x80)
                $i += 1;
            else if ($high < 0xE0)
                $i += 2;
            else if ($high < 0xF0)
                $i += 3;
            else
                $i += 4;

            if (--$MaxLen < 0)
                break;
        }

        return trim(substr($InputString, 0, $adapted)) . $AddString;
   }

   public function DateTimeFormat($Date, $Pattern)
   {
        $retVal;
        $Year;
        $Month;
        $MonthName;
        $Day;
        $Hour;
        $Min;
        $Sec;

        try
        {
            $date = date_create($Date);
            $Year = $date->format("Y");
            $Month = $date->format("m");
            $MonthName = $date->format("M");
            $Day = $date->format("d");

            $Hour = $date->format("H");
            $Min = $date->format("i");
            $Sec = $date->format("s");

            $retVal = $Pattern;
            $retVal = str_ireplace("yyyy", $Year, $retVal);

            $retVal = str_ireplace("mm", $Month, $retVal);
            $retVal = str_ireplace("M", $MonthName, $retVal);
            $retVal = str_ireplace("dd", $Day, $retVal);
            $retVal = str_ireplace("hh", $Hour, $retVal);
            $retVal = str_ireplace("ii", $Min, $retVal);
            $retVal = str_ireplace("ss", $Sec, $retVal);

            return $retVal;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error DateTimeFormat' );
        }
    }

    public function ReplaceNLtoBR($InputString)
    {
        $retVal;

        try
        {
            $retVal = str_ireplace("\n", "<br/>", $InputString);
            return $retVal;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error' );
        }
    }

    public function ReplaceBRtoNL($InputString)
    {
        $retVal;

        try
        {
            $retVal = str_ireplace("<br/>", "\n", $InputString);

            return retVal;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error' );
        }
    }

    private function FileExe($FileName)
    {
        $Temp = array();
        $retVal;

        try
        {
            $Temp = explode(".", $FileName);

            if (count($Temp) <= 1)
            {
                $retVal = "";
            }
            else
            {
                $retVal = $Temp[count($Temp)-1];
            }

            return $retVal;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error FileExe' );
        }
    }

    public function FileUpCheck($FileName)
    {
        $Prohibit = array();
        $FileExt;

        $Prohibit = explode(",", "exe,bat,com,reg,dll,cgi,asp,aspx,cs,php,jsp,java,sql,swf,vbs,htm,html,css,js,xml,xsd,xsl,htc,class,cer");

        try
        {
            $FileName = strtolower($FileName);

            $FileExt = $this->FileExe($FileName);

            for ($i = 0; $i < count($Prohibit); $i++)
            {
                if ($FileExt == $Prohibit[$i])
                {
                    return FALSE;
                }
            }

            return TRUE;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error FileUpCheck' );
        }
    }

    public function ImageFileUpCheck($FileName)
    {
        $ImageFile = array();
        $FileExt;

        $ImageFile = explode(",", "jpg,png,bmp,gif");

        try
        {
            $FileName = strtolower($FileName);

            $FileExt = $this->FileExe($FileName);

            for ($i = 0; $i < count($ImageFile); $i++)
            {
                if ($FileExt == $ImageFile[$i])
                {
                    return TRUE;
                }
            }

            return FALSE;
        }
        catch (Exception $ex)
        {
            throw new Exception( 'WebHelper Error ImageFileUpCheck' );
        }
    }

    public function GetPageHtml($PageList, $CurrentPage, $PageUrl, $Parameter, $PageSize)
    {
        $ret = "";

        if (count($PageList->PageRtn) != 0)
        {
            $ret = "<div class=\"pagination\">\n";
            
            if($CurrentPage > 1)
            {
                if($PageList->PageCount > 10) $ret .= "<a href=\"$PageUrl?page=1$Parameter\" class=\"first\">first</a>\n";
                $ret .= "<a href=\"$PageUrl?page=" . ($CurrentPage - 1) . "$Parameter\" class=\"prev\"><i class='fa fa-chevron-left'></i></a>\n";
            }else
            {
                if($PageSize < $PageList->RecordCount) $ret .= "<p class=\"prev\"><i class='fa fa-chevron-left'></i></p>\n";
            }

            $ret = $ret . "<div class='numbers'>";

            for ($i = 1; $i <= count($PageList->PageRtn); $i++)
            {
                if ($PageList->PageRtn[$i] == $CurrentPage)
                {
                    if($PageSize < $PageList->RecordCount) $ret = $ret . "<p class='is-active'>" . $PageList->PageRtn[$i] . "</p>";
                }
                else
                {
                    $ret = $ret . "<a href=\"" . $PageUrl . "?page=" . $PageList->PageRtn[$i] . $Parameter . "\">" . $PageList->PageRtn[$i] . "</a>";
                }
            }
            $ret = $ret . "</div>\n";

            if($CurrentPage < $PageList->PageCount)
            {
                $ret .= "<a href=\"$PageUrl?page=" . ($CurrentPage + 1) . "$Parameter\" class=\"next\"><i class='fa fa-chevron-right'></i></a>\n";
                if($PageList->PageCount > 10) $ret .= "<a href=\"$PageUrl?page=$PageList->PageCount$Parameter\" class=\"last\">last</a>\n";
            }else
            {
                
            }

            $ret = $ret . "</div>\n";
        }

        return $ret;
    }

    public function GetAdminPageHtml($PageList, $CurrentPage, $PageUrl, $Parameter, $PageSize)
    {
        $ret = "";

        if (count($PageList->PageRtn) != 0)
        {
            $ret = "<div class=\"pagination\">\n";

            if($CurrentPage != 1)
            {
                $ret .= "<a href=\"$PageUrl?page=1$Parameter\">&lt;&lt; first</a>\n";
                $ret .= "<a href=\"$PageUrl?page=" . ($CurrentPage - 1) . "$Parameter\">&lt; prev</a>\n";
            }

            for ($i = 1; $i <= count($PageList->PageRtn); $i++)
            {
                if ($PageList->PageRtn[$i] == $CurrentPage)
                {
                    $ret = $ret . "<a href=\"" . $PageUrl . "?page=" . $PageList->PageRtn[$i] . $Parameter . "\" class=\"is-active\">" . $PageList->PageRtn[$i] . "</a>";
                }
                else
                {
                    $ret = $ret . "<a href=\"" . $PageUrl . "?page=" . $PageList->PageRtn[$i] . $Parameter . "\">" . $PageList->PageRtn[$i] . "</a>";
                }
            }

            if($CurrentPage != $PageList->PageCount)
            {
                $ret .= "<a href=\"$PageUrl?page=" . ($CurrentPage + 1) . "$Parameter\">next &gt;</a>\n";
                $ret .= "<a href=\"$PageUrl?page=$PageList->PageCount$Parameter\">last &gt;&gt;</a>\n";
            }

            $ret = $ret . "</div>\n";
        }

        return $ret;
    }

    public function MakeOption($InputArray, $ColumNameValue, $ColumNameTitle, $SelectedValue)
    {
        $retVal = "";

        foreach($InputArray as $row)
        {
            if( $row->GetValue($ColumNameValue) == $SelectedValue )
                $retVal = $retVal . "<option value='" . $row->GetValue($ColumNameValue) . "' selected='selected'>" . $row->GetValue($ColumNameTitle) . "</option>";
            else
                $retVal = $retVal . "<option value='" . $row->GetValue($ColumNameValue) . "'>" . $row->GetValue($ColumNameTitle) . "</option>";
        }

        return $retVal;
    }

    public function MakeOptionArray($InputArray, $SelectedValue)
    {
        $retVal = "";

                foreach($InputArray as $key=>$value)
                {
                        if( $key == $SelectedValue )
                $retVal = $retVal . "<option value='" . $key . "' selected='selected'>" . $value . "</option>";
            else
                $retVal = $retVal . "<option value='" . $key . "'>" . $value . "</option>";
                }

        return $retVal;
    }

    public function MakeLinkString($inputArray)
    {
        $retVal = "";

        if(is_array($inputArray))
        {
            for( $i=0; $i<count($inputArray); $i++)
            {
                if( $i == count($inputArray)-1)
                    $retVal = $retVal . $inputArray[$i];
                else
                    $retVal = $retVal . $inputArray[$i] . "|";
            }
        }

        return $retVal;
    }

    public function MakeSelectedValue( $source, $target, $str = "selected")
    {
        if( $source == $target)
            return $str;
        else
            return "";
    }
    
    public function MakeSelectedValueWithRowHelper( $source, $target, $fieldname, $str = "selected")
    {
        $retVal = "";
        
        if($target != null)
        {
            foreach ($target as $row)
            {
                if( $source == $row[$fieldname])
                {
                    $retVal = $str;
                }
            }
        }
        
        return $retVal;
    }

	public function MakeSelectedValueWithArray( $source, $target, $str = "selected")
    {
        $retVal = "";
        
        if($target != null)
        {
			for($i=0; $i<count($target); $i++)
			{
				if( $source == $target[$i])
                {
                    $retVal = $str;
                }

			}
        }
        
        return $retVal;
    }
    
    public function isNull($inputVal)
    {
        if($inputVal == null || $inputVal == "")
        {
            return true;
        }else
        {
            return false;
        }
    }
    
    function HumanTiming ($inputstr, $granularity = 2){
        $retval = "";

        $date = strtotime($inputstr);
        $difference = time() - $date;
        
        $periods = array('decade' => 315360000,  'year' => 31536000, 'month' => 2628000, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60, 'second' => 1);
        
        if ($difference < 5)
        { // less than 5 seconds ago, let's say "just now"
            $retval = "just now";
            return $retval;
        } else
        {                            
            foreach ($periods as $key => $value)
            {
                if ($difference >= $value)
                {
                    $time = floor($difference/$value);
                    $difference %= $value;
                    $retval .= ($retval ? ' ' : '').$time.' ';
                    $retval .= (($time > 1) ? $key.'s' : $key);
                    $granularity--;
                }
                
                if ($granularity == '0') { break; }
            }
            
            return $retval.' ago';      
        }
    }

    public function GetMonthName($month){
        $retValue = "";

        switch ($month){
            case "01" :
                $retValue = "January";
                break;
            case "02" :
                $retValue = "February";
                break;
            case "03" :
                $retValue = "March";
                break;
            case "04" :
                $retValue = "April";
                break;
            case "05" :
                $retValue = "May";
                break;
            case "06" :
                $retValue = "June";
                break;
            case "07" :
                $retValue = "July";
                break;
            case "08" :
                $retValue = "August";
                break;
            case "09" :
                $retValue = "September";
                break;
            case "10" :
                $retValue = "October";
                break;
            case "11" :
                $retValue = "November";
                break;
            case "12" :
                $retValue = "December";
                break;
        }

        return $retValue;
    }

    public function GetMonthShortName($month){
        $retValue = "";

        switch ($month){
            case "01" :
                $retValue = "JAN";
                break;
            case "02" :
                $retValue = "FEB";
                break;
            case "03" :
                $retValue = "MAR";
                break;
            case "04" :
                $retValue = "APR";
                break;
            case "05" :
                $retValue = "MAY";
                break;
            case "06" :
                $retValue = "JUN";
                break;
            case "07" :
                $retValue = "JUL";
                break;
            case "08" :
                $retValue = "AUG";
                break;
            case "09" :
                $retValue = "SEP";
                break;
            case "10" :
                $retValue = "OCT";
                break;
            case "11" :
                $retValue = "NOV";
                break;
            case "12" :
                $retValue = "DEC";
                break;
        }

        return $retValue;
    }
    
    public function GetWeekName($date)
    {
        $days = array('Sun.', 'Mon.', 'Tue.', 'Wed.','Thu.','Fri.', 'Sat.');
        $retVal = "";

        $dayofweek = date('w', strtotime($date));
        $retVal = $days[$dayofweek];
        
        return $retVal;
    }

	public function GetFullWeekName($date)
    {
        $days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
        $retVal = "";

        $dayofweek = date('w', strtotime($date));
        $retVal = $days[$dayofweek];
        
        return $retVal;
    }

    public function AlertMessageAndHistoryBack($msg)
    {
        $ret;

        $ret = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        $ret = $ret . "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
        $ret = $ret . "<head>\n";
        $ret = $ret . "   <title></title>\n";
        $ret = $ret . "   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
        $ret = $ret . "</head>\n";
        $ret = $ret . "<body>\n";
        $ret = $ret . "<script type=\"text/javascript\">\n";

        if ($msg != "")
        {
            $ret = $ret . "   alert('" . $msg . "');\n";
        }

        $ret = $ret . "   history.back();\n";

        $ret = $ret . "</script>\n";
        $ret = $ret . "</body>\n";
        $ret = $ret . "</html>";

        echo $ret;
        exit();
    }

    public function UploadFile($elementName, $path, $imageOnly = false)
    {
        $retVal = null;

        if((!empty($_FILES[$elementName])) && ($_FILES[$elementName]["error"] == 0))
        {
            $filename = basename($_FILES[$elementName]["name"]);
            $ext = substr($filename, strrpos($filename, ".") + 1);

            if ($this->FileUpCheck($filename))
            {
                if($imageOnly)
                {
                    if(!$this->ImageFileUpCheck($filename))
                        $this->AlertMessageAndHistoryBack("File upload fail. Unrecognized image type.");
                }
                chmod($this->UploadPath.$path, 0755);
                $newfilename = date("YmdHis"). uniqid() . "." . $ext;
                $newfilepath = $this->UploadPath . $path . $newfilename;

                if ((move_uploaded_file($_FILES[$elementName]["tmp_name"], $newfilepath)))
                {
                   $retVal = new RowHelper();
                   $retVal["filename"] = $newfilename;
                   $retVal["orgfilename"] = $filename;
                   $retVal["filetype"] = strtoupper($ext);
                   $retVal["filesize"] = $_FILES[$elementName]["size"];
                }
            }else
            {
                $this->AlertMessageAndHistoryBack("File upload fail. Please check file type and size.");
            }
        }else
        {
            if($_FILES[$elementName]["error"] == 1)
                $this->AlertMessageAndHistoryBack("File upload fail. File size limited to 20 MB.");
        }

        return $retVal;
    }

    public function DeleteFile($path, $filename)
    {
        $filepath = $this->UploadPath . $path . $filename;

        if (file_exists($filepath))
        {
            chmod($this->UploadPath, 0755);
            unlink($filepath);
        }
    }

	public function CopyFile($path, $filename)
    {
        $ext = substr($filename, strrpos($filename, ".") + 1);
		$newfilename = date("YmdHis"). uniqid() . "." . $ext;

        $filepath = $this->UploadPath . $path . $filename;
		$newfilepath = $this->UploadPath . $path . $newfilename;

        copy($filepath, $newfilepath);

		return $newfilename;
    }

    public function DownloadFile( $path, $filename, $orgfilename )
    {
        $downloadPath = $this->UploadPath . $path . $filename;

        header("Pragma: public");
        header("Expires: 0");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $orgfilename . "\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($downloadPath));

        ob_clean();
        flush();

        readfile($downloadPath);
    }

    public function FormatFileSize($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
    
    function GetFileType($filename)
    {
        $ext = substr($filename, strrpos($filename, ".") + 1);
        return strtoupper($ext);
    }
    
    function GetFileSize($file)
    {
        $bytes = filesize($this->UploadPath . $file);
        
        return $this->FormatFileSize($bytes);
    }
    
    function GetRelatedApplications($pkid, $target)
    {
        $retVal = "";
        $dbhelper = new dbHelper();
        
        $dbhelper->dbOpen();
        $sql = "select c.title from " . $target . "_detail d inner join commoncode c on d.fkcommon = c.pkid where d.type = 1 and fk$target = " . $pkid;
        $List = $dbhelper->RunSQLReturnRows($sql);
        $dbhelper->dbClose();
        
        if($List != null && count($List) > 0)
        {
            foreach ($List as $row)
            {
                $retVal .= $row["title"] . ",&nbsp;";
            }
        }
        
        return $retVal;        
    }
    
    function GetRelatedProducts($pkid, $target)
    {
        $retVal = "";
        $dbhelper = new dbHelper();
        
        $dbhelper->dbOpen();
        $sql = "select c.title from " . $target . "_detail d inner join commoncode c on d.fkcommon = c.pkid where d.type = 2 and fk$target = " . $pkid;
        $List = $dbhelper->RunSQLReturnRows($sql);
        $dbhelper->dbClose();
        
        if($List != null && count($List) > 0)
        {
            foreach ($List as $row)
            {
                $retVal .= $row["title"] . ",&nbsp;";
            }
        }
        
        return $retVal;        
    }


    
    function GetCategoryName($category)
    {
        $retVale = "";
        
        switch ($category)
        {
            case 0:
                $retVale = "";
                break;
            case 1:
                $retVale = "";
                break;
            case 2:
                $retVale = "";
                break;
            case 3:
                $retVale = "";
                break;
             case 4:
                $retVale = "";
                break;
        }
        
        return $retVale;
    }
    
    function GetCommonCodeTitle($list, $key)
    {
        $retVal = "All";
        
        if($list != null && count($list) > 0)
        {
            foreach ($list as $row)
            {
                if($row["pkid"] == $key)
                {
                    $retVal = $row["title"];
                }
            }
        }
        
        return $retVal;
    }
	
  //check date format for events
  public function getParts($date)
   {
    $_parts = preg_split('{[-/ :.]}', $date);
    return $_parts;
   }

  public function ValidDate($input)
   {
    $_valid = true;
	 $dateParts = preg_split('{[-/ :.]}', $input);
	 if(!is_array($dateParts) || count($dateParts) != 3) 
          {
	    $_valid = false;
	   }
	 if(!is_numeric($dateParts[0]) || !is_numeric($dateParts[1]) || !is_numeric($dateParts[2])) 
          {
	    $_valid = false;	
          }
	 if(!checkdate($dateParts[0], $dateParts[1], $dateParts[2] ))
          {
	    $_valid = false;
	   }
        if(strlen($dateParts[2]) < 4)
          {
           $_valid = false;
          }
    return $_valid;
   }
   
   public function checkColor($color) {
	return preg_match('/^#[0-9a-fA-F]{6}$/', $color) == 1;
   }
   
   public function encrypt_email($email) {
    $pieces = str_split(trim($email));
    $new_mail = '';
    foreach ($pieces as $val) {
        $new_mail .= '&#'.ord($val).';';
    }
    return $new_mail;
   }

   public function uniqueKey(){
     $data = time() . rand();      
     return sha1($data);
   }

   public function catchIP(){
       $_ip = false;
       if (!empty($_SERVER['HTTP_CLIENT_IP'])) $_ip = $_SERVER['HTTP_CLIENT_IP'];
       if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
         $ips = explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
         if ($_ip != false){
              array_unshift($ips,$_ip);
              $_ip = false;
           }
         $count = count($ips);
         // Exclude IP addresses that are reserved for LANs
         for ($i = 0; $i < $count; $i++){
              if (!preg_match("/^(10|172\.16|192\.168)\./i", $ips[$i])){
                  $_ip = $ips[$i];
                  break;
              }
           }
         }
        if (false == $_ip AND isset($_SERVER['REMOTE_ADDR'])) $_ip = $_SERVER['REMOTE_ADDR'];
        return $_ip;
   }
   
   public function validEmail($input){
          return preg_match("/^\w[-.\w]*@([-a-z0-9]+\.)+[a-z]{2,4}$/i", $input);
         }
         
   public function validUsername($input){
	  if(strlen($input) < 5 || strlen($input) > 50 || preg_match('/\s/', $input)){
		return 0;
	   }
	  elseif(preg_match('/[^a-z_\-0-9]/i', $input)){
		  return 0;
		}
	  else{
		return 1;
	   }        
	}
         
  public function validPwd($input){
	  if(strlen($input) < 8 || strlen($input) > 20 || preg_match('/\s/', $input)){
		return 0;
	   }
	  elseif(!preg_match("/[^0-9]/", $input) || !preg_match("/[^A-z|\.\s]/", $input)){
		return 0;
	   }
	  else{
		return 1;
	   }        
   }
   
     public function validPhone($input){
	  if(strlen($input) < 5 || strlen($input) > 30){
		return 0;
	   }
	  elseif(preg_match("/[^0-9\-\+\.\s\(\)]/", $input)){
		return 0;
	   }
	  else{
		return 1;
	   }        
   }

}
?>
