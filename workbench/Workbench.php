<!DOCTYPE html>
<?php
//Eval code (cookie setting usually) in $_REQUEST["Header"]
if(isset($_REQUEST["Header"])) eval($_REQUEST["Header"]);

$Screen = "New";

// Code to test PHP in a screen


if (isset($_REQUEST["Code"])) {
	$Code = $_REQUEST["Code"];
	$Screen="";
}
else {
	$Code = "";
    $Screen="New";
}
 
// Save

if (isset($_REQUEST["button"]) && $_REQUEST["button"] == "Save") {
	//echo $_REQUEST["button"];
	$diskfile = $_REQUEST["file"];
	echo "Writing file " . $diskfile;
	$Handle=fopen($diskfile, "w");
	fwrite($Handle, $Code);
	fclose($Handle);
}

// Load

if (isset($_REQUEST["button"]) && $_REQUEST["button"] == "Load") {
	//echo $_REQUEST["button"];
	$diskfile = $_REQUEST["file"];
	echo "Reading file " . $diskfile;
	$Handle=fopen($diskfile, "rb");
	$Code = fread($Handle, filesize($diskfile) /* 2024 */);
	fclose($Handle);
}

if ( isset($_REQUEST["file"])) 
  {
	  $diskfile = $_REQUEST["file"];
  }
else 
  {
	  $diskfile = "";
  }
/*
// Option to look at an OS Request
if (isset($_REQUEST["Action"]))
	if ($REQUEST["Action"] == "OSCmd") 
*/




?>
<html>
<?php
// Set up workbench with header level cookies (setcookie will work)

if (isset($_REQUEST["Header"])) {
	//echo $_REQUEST["Header"];
	$Header=$_REQUEST["Header"];
}
else
	$Header="";
?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>PHP Workbench</title>
  </head>
  
  <?php
  // Handles the screen for code
  if ($Screen == "New" || $Screen == "") {
  ?>
  <body>
    <p><br>
    </p>
	<?php include "menu.php"; ?>
	Header/Programming
    <form name="" action="" method="POST" autocomplete="off" novalidate="novalidate">
	<textarea name="Header" rows="5" cols="120" id="Header"><?php echo $Header; ?></textarea><br>
	<textarea name="Code" rows="30" cols="120" id="Code"><?php echo $Code ?></textarea><br>
    <input type="submit" value="Run">
	<input type="button" value="Clear" onclick="x=document.getElementById('Code');x.value=''">File Name:
    <input type="text" id="file" name="file" <?php if (isset($diskfile)) { echo "value=\"$diskfile\""; } else { echo ""; } ?>>
	<input type="submit" name="button" value="Load">
	<input type="submit" name="button" value="Save">
    </form>
    <p><br>
    </p>
    <?php 
    if (isset($Code)) eval($Code);
    ?>
  </body>
  <?php
  }
  
  if ($Screen == "OSCmd") {
  ?>
  <body>
  </body>
  <?php
  }
  ?>
  
</html>
