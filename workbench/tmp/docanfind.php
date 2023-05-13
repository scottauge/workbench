// c:\tmp\docanfind.php



function DoSQL ($sql, $Login, $DataFunction) {

  // Create connection
  $conn = new mysqli($Login["servername"], $Login["username"], $Login["password"], $Login["dbname"]);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $result = $conn->query($sql);

  if (str_contains($sql, "select")) {
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $DataFunction($row);
      } // while
    } // if num_row > 0
   } else print("select not in $sql");

  $conn->close();

} // DoSQL()



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

global $Login;

$Login = array (
"servername" => "localhost",
"username" => "root",
"password" => "",
"dbname" => "game"
);

//
// Prevent browser cache'ing
//

$A="abcdefghijklmnopqrstuvwxyz";
print (strstr($A, random_int(1, strlen($A))));

//
// Handle a canfind
//

$Cookie="-1";
print("Doing BtoS(CanFind('session where Cookie=' . $Cookie))" . " <br>");
print("CanFind() is " . BtoS(CanFind('session where Cookie=' . $Cookie)));

//
// boolean to string
//

function BtoS($l) {return ($l == true) ? "true" : "false"; }




