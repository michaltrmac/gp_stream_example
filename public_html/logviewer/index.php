<?php

/************
 ** CONFIG **
 ***********/
require_once(realpath(dirname(__FILE__).'/../configs/setup.php'));
$cfg = parse_ini_file(realpath(dirname(__FILE__).'/../../application/configs/settings.ini'));
$query_file = 'f';

// DIRECTORY TO LIST
$dir = (isset($cfg['Debugger.logDir'])) ? $cfg['Debugger.logDir'] : dirname(__FILE__);

// ADD SPECIFIC FILES YOU WANT TO IGNORE HERE
$ignore_file_list = array('.', '..', '.htaccess');

// ADD SPECIFIC FILE EXTENSIONS YOU WANT TO IGNORE HERE
$ignore_ext_list = array('php');

// SET BASE DIR
$base_dir = realpath($dir);

if (isset($_GET[$query_file]))
	$dir .= '/'.$_GET[$query_file];

$dir = realpath($dir);

if(strpos($dir, $base_dir) === false)
	die('Invalid Path');

if (is_file($dir))
{
	if (isset($_GET['del']))
	{
		unlink($dir);

		$url = './';
		if (str_replace(basename($dir), '', $_GET[$query_file]))
			$url .= '?'.$query_file.'='.str_replace(basename($dir), '', $_GET[$query_file]);

		header('Location: '.$url);
	}
	else
	{
		$finfo = new finfo(FILEINFO_MIME);
		$fcontent = file_get_contents($dir);
		$mime_type = $finfo->buffer($fcontent);
		header('Content-Type: '.$mime_type);
		echo file_get_contents($dir);
	}
	die;
}

$h1 = $title = cleanTitle(basename($base_dir));

if (str_replace($base_dir, '', $dir))
{
	$add = str_replace($base_dir, '', $dir);
	$title .= $add;

	$h1_url = '';
	$h1 = '<a href="./">'.$h1.' </a>';

	foreach (array_filter(explode('/', $add)) as $d)
	{
		$h1_url .= $d.'/';

		if (basename($add) == $d)
			$h1 .= ' / '.$d;
		else
			$h1 .= ' / <a href="?'.$query_file.'='.$h1_url.'">'.$d.'</a>';
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?= $title; ?></title>
	<style>
		body { font-family:sans-serif; padding: 0; margin: 0; background: #f5f5f5; }
		.wrap { width: 70%; margin: 4em auto; background: white; padding: 25px; border: solid 1px #ECE9E9; -moz-border-radius: 10px; -webkit-border-radius: 10px; }
		h1 { margin: 0 0 5px 0; font-size:120%; font-weight:normal; color: #666; }
		a { color: #399ae5; text-decoration: none; } a:hover { color: #206ba4; text-decoration: underline; }
		.note { padding:  0 5px 25px 0; font-size:80%; color: #666; line-height: 18px; }
		.media_block { clear: both;  min-height: 50px; padding: 10px 15px; border-top: solid 1px #ECE9E9; position: relative; }
		.media_block:hover { background-color: #f5f5f5; }
		.media_block_image { width: 50px; height: 50px; float: left; margin-right: 10px; }
		.media_block_image a { width: 50px; height: 50px; line-height: 75px; display: block; background: transparent url(./icons.png) no-repeat 0 0; } .media_block_image a:hover { text-decoration: none; }
		.media_block_date { margin-top: 4px; font-size: 70%; color: #666; }
		.media_block_remove { position: absolute; right: 0; top: 20px; }
		.media_block_remove a { background-color: #EE5951; border: 3px solid #EE5951; border-radius: 20px 20px 20px 20px; color: white; display: block; font-size: 14px; font-weight: bold; height: 20px; line-height: 25px; text-align: center; width: 20px; }
		.media_block_remove a:hover { text-decoration: none; }
		.jpg, .jpeg, .gif, .png { background-position: -50px 0 !important; }
		.pdf { background-position: -100px 0 !important; }
		.txt, .rtf { background-position: -150px 0 !important; }
		.xls, .xlsx { background-position: -200px 0 !important; }
		.ppt, .pptx { background-position: -250px 0 !important; }
		.doc, .docx { background-position: -300px 0 !important; }
		.zip, .rar, .tar, .gzip { background-position: -350px 0 !important; }
		.swf { background-position: -400px 0 !important; }
		.fla { background-position: -450px 0 !important; }
		.mp3 { background-position: -500px 0 !important; }
		.wav { background-position: -550px 0 !important; }
		.mp4 { background-position: -600px 0 !important; }
		.mov, .aiff, .m2v, .avi, .pict, .qif { background-position: -650px 0 !important; }
		.wmv, .avi, .mpg { background-position: -700px 0 !important; }
		.flv, .f2v { background-position: -750px 0 !important; }
		.psd { background-position: -800px 0 !important; }
		.ai { background-position: -850px 0 !important; }
		.html, .xhtml, .dhtml, .php, .asp, .css, .js, .inc { background-position: -900px 0 !important; }
		.dir { background-position: -950px 0 !important; }
	</style>
</head>
<body>
	<div class="wrap">
		<h1><?= $h1 ?></h1>
<?php

// GET FILES AND PUT INTO AN ARRAY
$files = $directories = array();
$handle = dir($dir);
while (($file = $handle->read()) !== false)
{
	if(in_array($file, $ignore_file_list))
		continue;

	$path = realpath($dir.'/'.$file);
	$f = str_replace($base_dir, '', $path);
	$files[$path] = $f;
}
$handle->close();

ksort($files);

// GET DIRECTORIES
foreach($files as $path => $file)
{
	if(!is_dir($path))
		continue;

	echo "<div class=\"media_block\">";
	echo "	<div class=\"media_block_image\"><a href=\"?$query_file=$file\" class=\"dir\">&nbsp;</a></div>";
	echo "	<div class=\"media_block_name\">\n";
	echo "		<div class=\"media_block_file\"><a href=\"?$query_file=$file\">".basename($file)."</a></div>\n";
	echo "		<div class=\"media_block_date\">Last modified: " .  date("D. F jS, Y - H:i", filemtime($path)) . "</div>\n";
	echo "	</div>\n";
	echo "</div>";

	unset($files[$path]);
}

// LOOP THE FILES
foreach($files as $path => $file)
{
	$fileExt = getFileExt($file);
	if(in_array($fileExt, $ignore_ext_list))
		continue;

	echo "<div class=\"media_block\">";
	echo "	<div class=\"media_block_image\"><a href=\"?$query_file=$file\" class=\"$fileExt\">&nbsp;</a></div>";
	echo "	<div class=\"media_block_name\">\n";
	echo "		<div class=\"media_block_file\"><a href=\"?$query_file=$file\">".basename($file)."</a></div>\n";
	echo "		<div class=\"media_block_date\">Size: " . format_size($path) . "<br />Last modified: " .  date("D. F jS, Y - H:i", filemtime($path)) . "</div>\n";
	echo "		<div class=\"media_block_remove\"><a href=\"?$query_file=$file&del=true\">X</a></div>";
	echo "	</div>\n";
	echo "</div>";
}

?>
	</div>
</body>
</html>

<?php

/***************
 ** FUNCTIONS **
 **************/
function cleanTitle($title)
{
	return (str_replace(array('-', '_'), array(' ', ' '), $title));
}

function getFileExt($filename)
{
	return pathinfo($filename, PATHINFO_EXTENSION);
}

function format_size($file)
{
	$bytes = filesize($file);
	if ($bytes < 1024) return $bytes.'b';
	elseif ($bytes < 1048576) return round($bytes / 1024, 2).'kb';
	elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).'mb';
	elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).'gb';
	else return round($bytes / 1099511627776, 2).'tb';
}