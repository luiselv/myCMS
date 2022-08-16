<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>MyCMS</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="description" content="myCMS" />
		<meta name="author" content="Luis Evangelista" />
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<script src="jquery/jquery-2.0.2.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
	<div class="container">
		<form method="post" action="" enctype="multipart/form-data">
		    <input type="file" name="pdf" />
		    <input type="submit" name="submit" value="Upload" />
		</form>
<?php
	include_once '_common.php';
	echo(realpath(__FILE__));
	echo('<br/>');
	$partes_ruta = pathinfo($_SESSION['ruta']);
	echo $partes_ruta['dirname'], "<br/>";
	echo $partes_ruta['basename'], "<br/>";
	echo $partes_ruta['extension'], "<br/>";
	echo $partes_ruta['filename'], "<br/>"; // desde PHP 5.2.0
	echo $_SERVER['DOCUMENT_ROOT'];

	if (isset($_POST['submit'])){
		$pdfDirectory = "pdf/";
		$thumbDirectory = "pdfimage/";
		//get the name of the file
		$filename = basename( $_FILES['pdf']['name'], ".pdf");
		//remove all characters from the file name other than letters, numbers, hyphens and underscores
		$filename = preg_replace("/[^A-Za-z0-9_-]/", "", $filename).".pdf";
		//name the thumbnail image the same as the pdf file
		$thumb = basename($filename, ".pdf");
		 
	    if(move_uploaded_file($_FILES['pdf']['tmp_name'], $pdfDirectory.$filename)) {
		    //the path to the PDF file
		    $pdfWithPath = $pdfDirectory.$filename;
		    //add the desired extension to the thumbnail
		    $thumb = $thumb.".jpg";
		    //execute imageMagick's 'convert', setting the color space to RGB and size to 200px wide
		    //exec("convert \"{$pdfWithPath}[0]\" -colorspace RGB -geometry 200 $thumbDirectory$thumb");
		    $command = "convert \"{$pdfWithPath}[0]\" -colorspace RGB -geometry 200 $thumbDirectory$thumb";
		    exec($command);
		    //show the image
		    echo "<p><a href=\"$pdfWithPath\"><img src=\"pdfimage/$thumb\" alt=\"\" /></a></p>";
		    var_dump($command);
	    }
	}
?>
	</div>
	</body>	
</html>