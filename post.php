<?php

  /****************************
   * Configuration:           *
   ****************************/
  $urlfile = "urls";          // file to store the urls
  $title = "Linkpaste Lite";  // Title of the HTML document
  $limit = 15;                // number of links to show ( 0 = no limit )



  if($_GET['sub'] == 'OK'){
      $url = $_GET['link'];
      $beschreibung = $_GET['beschreibung'];
      writeUrlFile();
      writeIndex();
      unset($_GET);
      header('location: index.html');
    }


  /* Functions */

  function writeUrlFile() {
    global  $url, $beschreibung, $urlfile;
    if(!empty($url) && !empty($beschreibung)) {
      $file = fopen($urlfile, 'a+');
      $urleins = 'http://';
      if(!eregi('^http:\/\/',$url)){
        $urleins .= $url;
      }
      else {
        $urleins = $url;
      }
    fwrite($file,"\"$urleins\";\"$beschreibung\"\n");
    fclose($file);
    }
  }

  function writeIndex(){
    $file = fopen("index.html", "w+");
    fwrite($file, createIndex());
    fclose($file);
  }

  function createIndex() {
    $links = "";
    foreach(getUrls() as $value){
      $links .= "<li class=\"links\">\n\t\t\t<a href=\"". $value[0] ."\">". $value[1]. "</a><br /> " .$value[0]."\n\t\t</li>\n\t\t"; 
    }
    global $title;

    ob_start();

    require_once 'template.php';
    $output = ob_get_contents();

    ob_end_clean();

    return $output;
  }

  function getUrls(){
    global $urlfile, $limit;
    $return = array();
    $data = file($urlfile,  FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if(count($data) > $limit && $limit > 0)
      $data = array_slice($data, count($data) - $limit);
    foreach($data as $value) {
      $return[] = explode("\";\"", trim($value, "\""), 3);
    }
    return $return;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> <?= $title ?> </title>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <meta name="generator" content="Linkpaste" />
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
  <h1> Fehlerhafte Eingabe </h1>
  <p>Nochmal <a href="index.html">versuchen?</a><p>
</body>
</html>
