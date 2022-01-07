<!DOCTYPE html>
<?php

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

/*
// Option to look at an OS Request
if (isset($_REQUEST["Action"]))
	if ($REQUEST["Action"] == "OSCmd") 
*/
?>
<html>
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
	Programming
    <form name="" action="" method="GET" autocomplete="off" novalidate="novalidate">
	<textarea name="Code" rows="20" cols="80" id="Code"><?php echo $Code ?></textarea><br>
    <input type="submit" value="Run"><input type="button" value="Clear" onclick="x=document.getElementById('Code');x.value=''"> 
    </form>
    <p><br>
    </p>
    <?php 
    if (isset($Code)) eval($Code)
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
