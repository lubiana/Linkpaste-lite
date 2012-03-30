<?php

/****************************
 * Configuration:			*	
 ***************************/
$urlfile = "urls";
$title = "Linkpaste Lite";
$limit = 15;



if($_GET['sub'] == 'OK'){
		$url = $_GET['link'];
		$beschreibung = $_GET['beschreibung'];
		writeUrlFile();
		writeIndex();
		unset($_GET);
		header('location: index.html');
	}


/* Functions */
function writeUrlFile(){
	global  $url, $beschreibung, $urlfile;
	if(!empty($url)&&!empty($beschreibung)) {		
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
	return("
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
	\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">

<head>
	<title> $title </title>
	<meta http-equiv=\"content-type\" content=\"text/html;charset=utf-8\" />
	<meta name=\"generator\" content=\"Linkpaste\" />
	<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">
</head>

<body>
	<form action=\"post.php\" method=\"GET\">
		<ul id=\"form\">
			<li>
				<label>
					<span>Url: </span>
					<input type=\"text\" name=\"link\">
				</label>
			</li>
			<li>
				<label>
					<span>Beschreibung: </span>
					<input type=\"text\" name=\"beschreibung\">
				</label>
			</li>
			<li>
				<input type=\"submit\" name=\"sub\" value=\"OK\">
			</li>
		</ul>
	</form>
	<ul id=\"wrapper\">
		$links
	</ul>
</body>

</html>	
	");
}

function getUrls(){
	global $urlfile, $limit;
	$return = array();
	$file = $urlfile;
	$lesen = fopen($urlfile, 'rb');
	if($limit <= 0)
		$return = nl2br(fread($lesen, filesize($file)));
	else {
		$data = file($file,	FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if(count($data) > $limit)
			$data = array_slice($data, count($data) - $limit);
		foreach($data as $value)
			$return[] = explode("\";\"", trim($value, "\""), 3);
	}	
	fclose($lesen);
	return $return;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

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
