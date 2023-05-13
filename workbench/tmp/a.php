// Turn off warnings
error_reporting(E_ERROR | E_PARSE);



// put out cookie
/*
function Set_Cookie($Name, $Value) {
  setcookie($Name, $Value);
}
*/


//get a cookie

function Get_Cookie($Cookie){
  return $_COOKIE[$Cookie];
}



// calc cookie value

function CalcCookieValue ($length) {
  $R="";
  $Alphabet = "ABCDEFGHJIKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for($i=0; $i<$length; $i++) 
    $R .= substr($Alphabet, random_int(1,strlen($Alphabet)), 1);

  return $R;
}



// Write to a db

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



function out ($a) {
  return;
  echo "==<i>" . $a . "<br>";
}



function WriteLastUsed($Cookie, $Name) {
	
  WriteCSession($Cookie, $Name, time());
  
}



global $Login;

$Login = array (
"servername" => "localhost",
"username" => "root",
"password" => "",
"dbname" => "game"
);

function DoSQL ($sql, $DataFunction) {
  
  global $Login;
  
  // Create connection
  $conn = new mysqli($Login["servername"], $Login["username"], $Login["password"], $Login["dbname"]);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Turn autocommit off, begin a trans action
  out("DoSQL Trying </i>" . $sql);
  out( "DoSQL Manual control of transactions" );
  $conn->autocommit(FALSE);
  $conn->begin_transaction();

  // Do what was asked
  $result = $conn->query($sql);

  if (!$result) {
    print("DoSQL Error:" . $conn->error);
    exit(0);
  }
 
  out("DoSQL </i>" . $sql);

   if(str_contains($sql, "select"))
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) $DataFunction($row);
    } // if num_row > 0

    // else print("select not in <i>$sql</i><br>");

  // COMMIT transaction, unless it failed

  out("DoSQL Doing commit");

  if (!$conn->commit()) {
    out( "DoSQL Commit transaction failed");
    out( "DoSQL exit'ing!<br />" );
    exit();
  }

  out( "DoSQL Closing up connection<br />" );

  // Close things up
  $conn->close();

} // DoSQL()


// For one record!

function DoSQLFor1 ($sql, $DataFunction) {
  
  global $Login;
  
  // Create connection
  $conn = new mysqli($Login["servername"], $Login["username"], $Login["password"], $Login["dbname"]);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Turn autocommit off, begin a trans action
  out("DoSQLFor1  Trying </i>" . $sql);
  out( "DoSQLFor1 Manual control of transactions" );
  $conn->autocommit(FALSE);
  $conn->begin_transaction();

  // Do what was asked
  $result = $conn->query($sql);

  if (!$result) {
    print("DoSQLFor1 Error:" . $conn->error);
    exit(0);
  }
 
  out("DoSQLFor1 </i>" . $sql);

   if(str_contains($sql, "select"))
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) $R = $DataFunction($row);
    } // if num_row > 0

    // else print("select not in <i>$sql</i><br>");

  // COMMIT transaction, unless it failed

  out("DoSQLFor1 Doing commit");

  if (!$conn->commit()) {
    out( "DoSQLFor1 Commit transaction failed");
    out( "DoSQLFor1 exit'ing!<br />" );
    exit();
  }

  out( "DoSQLFor1 Closing up connection<br />" );

  // Close things up
  $conn->close();
  
  return $R;

} // DoSQLFor1()



function ClearAllSession () {
  out("ClearAllSession ");
  $SQL="delete from session";
  DoSQL($SQL, "SessionData");
} // ClearAllSession() -




$BRLF="<br/>";

ClearAllSession();
//echo("cookieValue set as " . $CookieValue=Get_Cookie("Login") . "<br />");

Set_Cookie("Login", "Scott");

echo("Cookie now is " . $CookieValue . $BRLF);
echo("Done ") . "<br />";


WriteCSession($CookieValue, "Login", "Scott");


