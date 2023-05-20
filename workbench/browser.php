<?php
// Make a() return underlined entry
// Our current directory
// fill in directories ()
// fill in files (delmited with ())

// Make the file listing
// windows
function q($a) {return "\"" . $a . "\"";}

function sq($a) {return "'" . $a . "'";}

function script() {return "<script>";}

function escript() {return "</script>";}

function cr() {return "<br>\n";}

function a($href, $hfriendly, $onclick) {
  return "<a href=" . q($href) . " onclick=\"" . $onclick . "\">" . $hfriendly . "</a>";
  return "<a href=" . q($href) . " onclick=\"" . $onclick . "\">" . $hfriendly . "</a>";
  //return "<a href=" . q($href) . " onclick='" . $onclick . "'>" . $hfriendly . "</a>";
}

function v() {
  if (!isset($_REQUEST['diskfile']) || $_REQUEST['diskfile']=="") echo ""; else echo $_REQUEST['diskfile'];
}

function onclick($a,$v) {return " onClick=" . $a . "(\"" . $v . "\")"; }

function winremovelastdirectory($f) {
  $delimiter="/";
  $e=explode($delimiter,$f);
  $n=count($e);
  $o="";
  $i=0;
  while($i<$n-1) {
    $o .= $e[$i] . $delimiter;
    $i++;
  }
  return $o;

}

function winnremovelastdirectory($f,$j) {
  $delimiter="/";
  $e=explode($delimiter,$f);
  $n=count($e);
  $o="";
  $i=0;
  while($i<$j+1) {
    $o .= $e[$i] . $delimiter;
    $i++;
  }
  return $o;

}
?>
<html>

<head>
<title>File/Directory Browser</title>
</head>

<body>
<form>
<input type="text" name="diskfile" id="diskfile" value="<?php v(); ?>">
<input type="submit" value="Go">
</form>

<script type="text/javascript">
function v(rewrite) {
document.getElementById('diskfile').value=rewrite;
}

function a(rewrite) {alert(rewrite);}

function o(file) {
  window.opener.document.getElementById("file").value=file;
  window.close();
  window.focus();
  }
</script>

<?php
if(!isset($_REQUEST["diskfile"]))
  if(!isset($_REQUEST["diskfile"]) || $_REQUEST["diskfile"] == "") $_REQUEST["diskfile"] = "c:\*.*";

// give a root of where we are at
//echo "d " . a("..", "..", "v('" . str_replace("\\", "/", "..") . "/*')") . cr();
echo "Directory: " . ($_REQUEST["diskfile"]) . cr(). cr();
$filename="..";
/*
echo "d " . a(winremovelastdirectory($_REQUEST["diskfile"]), 
              winremovelastdirectory($_REQUEST["diskfile"]), 
              "v('" . winremovelastdirectory($_REQUEST["diskfile"]) . "*')") . cr();
              */
//echo "d <u>..</u>" . cr();  // how to give this an onclick?
// give a listing of where we at
foreach (glob($_REQUEST['diskfile']) as $filename) {
  if(is_dir($filename))
    echo "d " . a($filename, $filename, "v('" . str_replace("\\", "/", $filename) . "/*')") . cr();
  else
    echo "f " . a($filename, $filename, "o('" . $filename . "')") . cr();
    //echo "f " . a($filename, $filename, "a('" . $filename . "')") . cr();

}

/*-----------------
//Get a list of file paths using the glob function.
if (!isset($REQUEST["diskfile"])
  $fileList = glob('c:/*');
else
  $fileList = glob($REQUEST['diskfile']);

//Loop through the array that glob returned.
foreach($fileList as $filename){
   //Simply print them out onto the screen.
   echo $filename, '<br>'; 
}
------*/
?>

</body>
</html>