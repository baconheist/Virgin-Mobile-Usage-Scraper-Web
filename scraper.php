<?php
include ("crawler.php");

$crawler = new Secure_Crawler();
 

$crawler->login($_POST["username"], $_POST["password"]);

  
$content = $crawler->get('http://www.virginmobile.com.au/selfcare/dispatch/LogoutLogin');

//echo $content;

$content = $crawler->get('https://www.virginmobile.com.au/selfcare/dispatch/DataUsageRequest');

//echo $content;

$string=$content;

//echo "#";
//echo $string;
//echo "#";

if($string != "")
{
$start="USAGE:";

$end="MB";


    $string = " ".$string; 
    $ini = strpos($string,$start); 
    if ($ini == 0) return ""; 
    $ini += strlen($start); 
    $len = strpos($string,$end,$ini) - $ini; 
  
 
echo "USAGE:";
    echo substr($string,$ini,$len); 
echo "MB";



$string=$content;

$start="(";

$end=")";


    $string = " ".$string; 
    $ini = strpos($string,$start); 
    if ($ini == 0) return ""; 
    $ini += strlen($start); 
    $len = strpos($string,$end,$ini) - $ini; 
echo " - ";
    echo substr($string,$ini,$len); 


}
  if($string==""||$string==" "||$string=="  ")
    {
     echo "The Virgin my Account page is either down or slow at the moment...";
     }
      