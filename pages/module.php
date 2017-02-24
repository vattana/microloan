<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" href="../css/schedule.css" media="all">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<?php
mysql_query('SET NAMES UTF8');
/////////user logs
function write_mysql_log($message, $db)
{
  // Check database connection
  if( ($db instanceof MySQLi) == false) {
    return array(status => false, message => 'MySQL connection is invalid');
  }
 
  // Check message
  if($message == '') {
    return array(status => false, message => 'Message is empty');
  }
 
  // Get IP address
  if( ($remote_addr = $_SERVER['REMOTE_ADDR']) == '') {
    $remote_addr = "REMOTE_ADDR_UNKNOWN";
  }
 
  // Get requested script
  if( ($request_uri = $_SERVER['REQUEST_URI']) == '') {
    $request_uri = "REQUEST_URI_UNKNOWN";
  }
 
  // Escape values
  $message     = $db->escape_string($message);
  $remote_addr = $db->escape_string($remote_addr);
  $request_uri = $db->escape_string($request_uri);
 
  // Construct query
  $sql = "INSERT INTO user_log (remote_addr, request_uri, message) VALUES('$remote_addr', '$request_uri','$message')";
 
  // Execute query and save data
  $result = $db->query($sql);
 
  if($result) {
    return array(status => true);  
  }
  else {
    return array(status => false, message => 'Unable to write to the database');
  }
}
//////////

function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    return $number;
} 
/////////////////
function get_rows ($table) {
        $temp = mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM $table LIMIT 1");
        $result = mysql_query("SELECT FOUND_ROWS()");
        $total = mysql_fetch_row($result);
        return $total[0];
}
//////////////////////
function DropDownlist($Table,$Fname,$dname,$Cname,$Fcon,$con,$event)
	{
		$sql="Select $Fname,$dname From $Table";
		if($Fcon!='')
		{
			$sql=$sql." Where $Fcon='".$con."' Group By $Fname";
		}
		if ($event!='')
		{
			echo "<select name=$Cname style='text-shadow: CCCCCC' onchange='".$event."' class='text_kh'><option value=no>..សូមជ្រើសរើស..</option>";
		}
		else
		{
			echo "<select name=$Cname style='text-shadow: CCCCCC' class='text_kh'><option value=no>..សូមជ្រើសរើស..</option>";
		}
		$sql=mysql_query($sql) or die (mysql_error());
		//echo "<option value=no>..ជ្រើសរើស..</option>";
		while ($row=mysql_fetch_array($sql))
		{	
			echo "<option value=\"$row[$Fname]\">$row[$dname]</option>";
		}
		echo "</select>";
	}
//////////////////////////
function ConvertDateTime($datestamp, $format)
{
        if($datestamp != 0)
        {
                // Splits the date in multiple variables
                list($date, $time) = split(" ", $datestamp);
                list($year, $month, $day) = split("-", $date);
                list($hour, $minute, $second) = split(":", $time);
                // Gets the unix time by passing the variables we just initialized
                $stampeddate = mktime($hour,$minute,$second,$month,$day,$year);
                // Creates the new date and formats it according to the formatting strings
                $datestamp = date($format,$stampeddate);
                // Returns the formatted date
                return $datestamp;
        }

}

//////////////////////////////
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) ."លាន"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : "") . 
            convert_number($kn) ."ពាន់"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : "") . 
            convert_number($Hn) ."រយ"; 
    } 

    $ones = array("", "មួយ", "ពីរ", "បី", "បួន", "ប្រាំ", "ប្រាំមួយ", 
        "ប្រាំពីរ", "ប្រាំបី", "ប្រាំបួន", "ដប់", "ដប់មួយ", "ដប់ពីរ", "ដប់បី", 
        "ដប់បួន", "ដប់ប្រាំ", "ដប់ប្រាំមួយ", "ដប់ប្រាំពីរ", "ដប់ប្រាំបី", 
        "ដប់ប្រាំបួន"); 
    $tens = array("", "", "ម្ភៃ", "សាមសិប", "សែសិប", "ហាសិប", "ហុកសិប", 
        "ចិតសិប", "ប៉ែតសិប", "កៅសិប"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "សួន្យ"; 
    } 

    return $res; 
} 
///
function convert_number_to_words($number) {
   
    $hyphen      = '';
    $conjunction = '';
    $separator   = '';
    $negative    = 'negative ';
    $decimal     = ' និង ';
    /*$dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
	*/
	$dictionary  = array(
        0                   => 'សូន្យ',
        1                   => 'មួយ',
        2                   => 'ពីរ',
        3                   => 'បី',
        4                   => 'បួន',
        5                   => 'ប្រាំ',
        6                   => 'ប្រាំមួយ',
        7                   => 'ប្រាំពីរ',
        8                   => 'ប្រាំបី',
        9                   => 'ប្រាំបួន',
        10                  => 'ដប់',
        11                  => 'ដប់មួយ',
        12                  => 'ដប់ពីរ',
        13                  => 'ដប់បី',
        14                  => 'ដប់បួន',
        15                  => 'ដប់ប្រាំ',
        16                  => 'ដប់ប្រាំមួយ',
        17                  => 'ដប់ប្រាំពីរ',
        18                  => 'ដប់ប្រាំបី',
        19                  => 'ដប់ប្រាំបួន',
        20                  => 'ម្ភៃ',
        30                  => 'សាមសិប',
        40                  => 'សែសិប',
        50                  => 'ហាសិប',
        60                  => 'ហុកសិប',
        70                  => 'ចិតសិប',
        80                  => 'ប៉ែតសិប',
        90                  => 'កៅសិប',
        100                 => 'រយ',
        1000                => 'ពាន់',
        1000000             => 'លាន',
        1000000000          => 'កោដ',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
   
    if (!is_numeric($number)) {
        return false;
    }
   
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }
   
    $string = $fraction = null;
   
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
   
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . '' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . '' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }
   
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
   
    return $string;
}

/*$cheque_amt = 8747484 ; 
try
    {
    echo convert_number($cheque_amt);
    }
catch(Exception $e)
    {
    echo $e->getMessage();
    }
	*/
/////////////////////////////
function encrypt_string_64($inputValue, $key) 
{ 
  $encryptedString = ''; 
  for($i=0; $i<strlen($inputValue); $i++) { 
    $char = substr($inputValue, $i, 1); 
    $keychar = substr($key, ($i % strlen($key))-1, 1); 
    $char = chr(ord($char)+ord($keychar)); 
    $encryptedString.=$char; 
  } 

  return base64_encode($encryptedString); 
}  

////////////
function decrypt_string_64($encoded64Input, $key)
{ 
  $decryptedString = ''; 
  $encoded64Input = base64_decode($encoded64Input); 
  
  for($i=0; $i<strlen($encoded64Input); $i++) { 
    $char = substr($encoded64Input, $i, 1); 
    $keychar = substr($key, ($i % strlen($key))-1, 1); 
    $char = chr(ord($char)-ord($keychar)); 
    $decryptedString.=$char; 
  } 

  return $decryptedString; 
}  
//////////

function encryptDecrypt($Str_Message)
    {

    $Len_Str_Message=strlen($Str_Message);
    $Str_Encrypted_Message="";
    for ($Position = 0;$Position<$Len_Str_Message;$Position++){
        $Key_To_Use = (($Len_Str_Message+$Position)+1); 
        $Key_To_Use = (255+$Key_To_Use) % 255;
        $Byte_To_Be_Encrypted = substr($Str_Message, $Position, 1);
        $Ascii_Num_Byte_To_Encrypt = ord($Byte_To_Be_Encrypted);
        //uses xor operator
        $Xored_Byte = $Ascii_Num_Byte_To_Encrypt ^ $Key_To_Use;  
        $Encrypted_Byte = chr($Xored_Byte);
        $Str_Encrypted_Message .= $Encrypted_Byte;

    }
 
    return $Str_Encrypted_Message; 
	   
    } 
/////////////////////////

function get_dir_size($dir_name){
        $dir_size =0;
           if (is_dir($dir_name)) {
               if ($dh = opendir($dir_name)) {
                  while (($file = readdir($dh)) !== false) {
                        if($file !="." && $file != ".."){
                              if(is_file($dir_name."/".$file)){
                                   $dir_size += filesize($dir_name."/".$file);
                             }
                             /* check for any new directory inside this directory */
                             if(is_dir($dir_name."/".$file)){
                                $dir_size +=  get_dir_size($dir_name."/".$file);
                              }
                           }
                     }
             }
       }
closedir($dh);
return $dir_size;
}

//$dir_name = "C:\AppServ";
/* 1048576 bytes == 1MB */
//$total_size= round((get_dir_size($dir_name) / 1048576),2) ;
//print " Directory $dir_name size : $total_size MB";
//////////////////////

function ConvertBytes($number)
{
    $len = strlen($number);
    if($len < 4)
    {
        return sprintf("%d b", $number);
    }
    if($len >= 4 && $len <=6)
    {
        return sprintf("%0.2f Kb", $number/1024);
    }
    if($len >= 7 && $len <=9)
    {
        return sprintf("%0.2f Mb", $number/1024/1024);
    }
    return sprintf("%0.2f Gb", $number/1024/1024/1024);
                           
}
//////////////////////////////////
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
////////////////////
function time_left($integer)
 { 
     $seconds=$integer; 
     if ($seconds/60 >=1) 
     { 
     $minutes=floor($seconds/60); 
     if ($minutes/60 >= 1) 
     { # Hours 
     $hours=floor($minutes/60); 
     if ($hours/24 >= 1) 
     { #days 
     $days=floor($hours/24); 
     if ($days/7 >=1) 
     { #weeks 
     $weeks=floor($days/7); 
     if ($weeks>=2) $return="$weeks Weeks"; 
     else $return="$weeks Week"; 
     } #end of weeks 
     $days=$days-(floor($days/7))*7; 
     if ($weeks>=1 && $days >=1) $return="$return, "; 
     if ($days >=2) $return="$return $days days";
     if ($days ==1) $return="$return $days day";
     } #end of days
     $hours=$hours-(floor($hours/24))*24; 
     if ($days>=1 && $hours >=1) $return="$return, "; 
     if ($hours >=2) $return="$return $hours hours";
     if ($hours ==1) $return="$return $hours hour";
     } #end of Hours
     $minutes=$minutes-(floor($minutes/60))*60; 
     if ($hours>=1 && $minutes >=1) $return="$return, "; 
     if ($minutes >=2) $return="$return $minutes minutes";
     if ($minutes ==1) $return="$return $minutes minute";
     } #end of minutes 
     $seconds=$integer-(floor($integer/60))*60; 
     if ($minutes>=1 && $seconds >=1) $return="$return, "; 
     if ($seconds >=2) $return="$return $seconds seconds";
     if ($seconds ==1) $return="$return $seconds second";
     $return="$return."; 
     return $return; 
 } 
 //////////
function dateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);
}
//////////
function full_copy( $source, $target ) {
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
 
		$d->close();
	}else {
		copy( $source, $target );
	}
}
/////
function roundkhr($value,$set){
			$splitAmt=substr($value,-2,2);
			if($splitAmt<$set){
				$value=intval($value-$splitAmt);
				}
			else{
				$splitAmt = 100 - $splitAmt;
				$value = intval($value + $splitAmt);
			}
			return $value;
	}
?>