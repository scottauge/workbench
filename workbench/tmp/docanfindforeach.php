// c:\tmp\docanfind.php

// Build_20230511221439 
// - Made Login always available, not an on/off this unless via 
// programmer calls
// - Login info at the top for everything to know it automattically

//
// DB login info righ and ready.
//

global $Login;

$Login = array (
"servername" => "localhost",
"username" => "root",
"password" => "",
"dbname" => "game"
);

// 
// Heart of db connection
//

function DoSQL ($sql, $DataFunction) {

  // Create connection
  // if ("Conn") is set, use that, otherwise make one
  // This will stop connects to the db to one only
  
  if (isset($Login["conn"]))
	  $conn = $Login["conn"];
  else {
    $conn = new mysqli($Login["servername"], 
	                   $Login["username"], 
					   $Login["password"], 
					   $Login["dbname"]);
    $Login["conn"] = $conn;
  }
  
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Through some DML (Data Manipulation Language) through the system
  
  $result = $conn->query($sql);

  if (str_contains($sql, "select")) {
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $DataFunction($row);
      } // while
    } // if num_row > 0
   } else print("select not in $sql");

  // Dont close up the connection, will be done with CloseDB()
  // $conn->close();

} // DoSQL()


//
// Close the db
//

function CloseDB() {
	$Login["conn"]->close();
}

//
// boolean to string
//

function BtoS($l) {return ($l == true) ? "true" : "false"; }

// --------------------------------------------------------------------------------------
// The following are meant to imitate the 4gl as best as we can with SQL statements.
// --------------------------------------------------------------------------------------

//
// CanFind()
//

function CanFind($sql) {

  global $FoundIt, $Login;

  $sql = "select * from " . $sql . " limit 1";

  DoSQL($sql, $Login, "FoundIt");

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
//

function Create ($sql) {
	
	$sql = "insert into " . $sql;
	
	DoSQL($sql, $Login, "CreateJSR");
}

function CreateJSR($row){
	return;
}

function ForEach($sql) {
	
}

function Find($sql) {	

  $sql = $sql . " limit 1";
  DoSQL($sql, $Login, "fiblock");
	
}

function fiblock ($row) {
	
}

function Create ($sql) {
	$sql = "insert into" . $sql
}

function Delete ($sql) {
	
}

//
// Handle a canfind
//

$Cookie="-1";
print("Doing BtoS(CanFind('session where Cookie=' . $Cookie))" . " <br>");
print("CanFind() is " . BtoS(CanFind('session where Cookie=' . $Cookie)));






