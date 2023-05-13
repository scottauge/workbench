<?php
// websession.php
// Name should be "LastUsed"

$CRLF="\r";

function WriteCSession ($Cookie, $Name, $Value) {
	
  global $result;

  // Are we doing an insert or an update?
  $SQL="select CValue from session where cookie = '$Cookie' and Description = '$Name'";
  out("WriteCSession " . $SQL);
  DoSQL($SQL, "SessionData");
	
  if ($result)
    $SQL = "update session set CValue = '$Value' where Cookie='$Cookie' and Description = '$Name'";
  else 
    $SQL = "insert into session (Cookie, Description, CValue) values ('$Cookie', '$Name', '$Value');";
  
  out("WriteCSession  SQL:" . $SQL);
  out("Resetting result");
  $result=false;

  out("WriteCSession " . $SQL);
  DoSQL($SQL, "ViewWriteCSession");
	
  if ($Name != "LastUsed") 
    WriteLastUsed($Cookie, "LastUsed");

} // WriteCSession -





function ReadCSession ($Cookie, $Name) {
  WriteLastUsed($Cookie, "LastUsed");
  $SQL = "select * from session where cookie='$Cookie' and Description='$Name'";
  return DoSQLFor1($SQL, "VReadSession");
} // ReadCSession() -




function VReadSession ($row) {
  return $row["CValue"];
} // VReadSession() -




//
// --- Clear Session
//

function ClearSession ($Cookie) {
  $SQL="delete from session where cookie = '$Cookie'";
  out("ClearSession :" . $SQL);
  DoSQL($SQL, "SessionData");
} // ClearSession() - 



function ClearAllSession () {
  out("ClearAllSession ");
  $SQL="delete from session";
  DoSQL($SQL, "SessionData");
} // ClearAllSession() -


function LastUsed () {
  $SQL="now()";
  DoSQL($SQL,"ShowLastUsed");
} // LastUsed()

function ShowLastUsed($row) {
  return $row[0];
}




function SessionData ($row) {
  global $result;
  if (isset($row)) {
    $result=1;
    //var_dump($row);
    //echo "<br>";
  } else {
    $result=0;
    out ("Not found!");
  }
} // SessionData() -



function out($p) {
  //return;  // for turning off
  echo "<b>-- </b><i>" . $p . "</i><br />\r\n";
} // function out()-



function WriteLastUsed($Cookie, $Name) {
	
  WriteCSession($Cookie, $Name, microtime());
  
}

?>