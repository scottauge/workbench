// c:\tmp\progresslike.php

// Build_20230511221439 
// - Made comments for version control
// - Made Login always available, not an on/off unless via 
//   programmer calls
// - Login info at the top for everything to know it automatically
// - CanFind() works
// - Create () works
// - Delete () works
// - For_Each()
// - Find ()

//
// DB login info righ and ready.
//

global $Login;

$Login = array (
"servername" => "localhost",
"username" => "root",
"password" => "",
"dbname" => "background"
);

// 
// Heart of db connection
//

function DoSQL ($sql, $DataFunction) {

  global $Login;
  
  // Create connection
  // if ("Conn") is set, use that, otherwise make one
  // This will stop connects to the db to one only
  
  if (isset($Login["conn"]))
	  $conn = $Login["conn"];
  else { 
    $conn = new mysqli(	 
						$Login["servername"], 
						$Login["username"],
						$Login["password"], 
						$Login["dbname"]
                      );
    $Login["conn"] = $conn;
  }
  
  if ($conn->connect_error) {
	  Debug("DoSQL() connection error");
	  die("Connection failed: " . $conn->connect_error);
  }

  // Through some DML (Data Manipulation Language) through the system
  Debug("DoSQL query! " . $sql);
  $result = $conn->query($sql);

  if (str_contains($sql, "select")) {
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $DataFunction($row);
      } // while
    } // if num_row > 0
  } else {
    Debug("DoSQL() select not in $sql");
  }
  
  // Dont close up the connection, will be done with CloseDB()
  // $conn->close();

} // DoSQL()


//
// Close the db
//

function CloseDB() {
	global $Login;
	Debug("CloseDB() Closing the db");
	$Login["conn"]->close();
}

//
// boolean to string
//

function BtoS($l) {return ($l == true) ? "true" : "false"; }

//
// Debugging
//

function Debug($Msg) {
	// return;
  if ($Msg != "") 
	  print("Debug() " . $Msg ."<br>");
  else
    print("<br>");
}

// --------------------------------------------------------------------------------------
// The following are meant to imitate the 4gl as best as we can with SQL statements.
// --------------------------------------------------------------------------------------

//
// CanFind()
//

function CanFind($sql) {

  global $FoundIt;

  $sql = "select * from " . $sql . " limit 1";
  Debug("CanFind() " . $sql);
  DoSQL($sql, "FoundIt");

  return $FoundIt;

}

function FoundIt($row) {

  global $FoundIt;
  
  $FoundIt=false;
  if($row) $FoundIt=true;
  return $FoundIt;
  
}

//
// Create ("tablename (fields) values (values)")
// Create("session () values ()");
//

function Create ($sql) {
	
	$sql = "insert into " . $sql;
	Debug('Create() ' . $sql);
	DoSQL($sql, "EmptyJSR");
	
}

function EmptyJSR($row){
	return;
}

//
// Set up a for each into a select
//

function For_Each($sql) {
  
  Debug("1 " . $sql);
  $sql  = "select * from " . $sql;
  DoSQL($sql, "ViewForEach");
  Debug("2 " . $sql);
	
}

function ViewForEach($r) {
  var_dump($r);
  Debug("<br>CValue=" . $r["CValue"]);
  }

//
// Try to do a find no next or prev yet!
//

function Find($sql) {	

  $sql = "select  * from " . $sql . " limit 1";
  Debug('Find() ' . $sql);
  DoSQL($sql, "fiblock");

	
}

function fiblock ($row) {
  Debug("fiblock()");
	var_dump($row);
  Debug("<br>CValue = " . $row["CValue"]);
  
}


function Delete ($sql) {
	$sql = "delete from " . $sql;
	Debug('Delete() ' . $sql);
	DoSQL($sql, "EmptyJSR");

}

//
// Handle a canfind
//

Debug("");
$Cookie="-1";
Debug("Doing BtoS(CanFind('session where Cookie=' . $Cookie))");
Debug("CanFind() is " . BtoS(CanFind('session where Cookie=' . $Cookie)));

Debug("");
Debug("Calling Create()");
if (!CanFind('session where CValue = "empty"')) 
  Create ("session (CValue, Cookie) values ('empty', 1)");

Debug("");
Debug("Calling For_Each()");
For_Each("session");

Debug("");
Debug("Calling Find()");
Find("session");

/*
Debug("");
Debug("Calling Delete()");
Delete("session where CValue = 'empty'");
*/

Debug("");
Debug("Calling CloseDB()");
CloseDB();





