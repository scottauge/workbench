global $CRLF;

$CRLF="\r\n";

function out($p) {
  global $CRLF;
  //return;  // for turning off
  echo "<b>-- </b><i>" . $p . "</i><br>" . $CRLF;
} // function out()-

out("this");
out("that");