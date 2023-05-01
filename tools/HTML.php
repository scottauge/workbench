<?php
include "webspeed.php";
/*
Covert text document to an HTML one.  In the future call 
clsPages.php to put it in the db.
*/

class clsHTML {

  public function ToHTML ($Text) {
	  $Text = str_ireplace("\n","<br>",$Text);
	  return $Text;
  }
}

/* Retrieve what is put below and get the goods. */
$ch = new clsHTML();
$T=GetValue("title");
$M = $ch->ToHTML(GetValue("message"));
?>
<html>
<form action="http://localhost/pages/HTML.php" >
Title: <input type="text" name="title" width="50" value="<?php print($T) ?>"><br>
<textarea name="message" rows="17" cols="60"><?php print($M) ?></textarea><br>
<input type="submit" value="Submit"><br><?php print($M) ?>
</form>
</html>
