<?php
// c:\tmp\dosql.php

global $Login;
/*
$Login = array (
"Server" => "localhost",
"User" => "root",
"Password" => "",
"DBName" => "background"
);
*/

function DoSQL ($sql, $DataFunction) {

  global $Login;
  
  if(!isset($Login['Conn'])) {
    // Create connection - keep around so we can continue to use the connection.
    $conn = new mysqli($Login["Server"], $Login["User"], $Login["Password"], $Login["DBName"]);
    $Login["Conn"]=$conn;
  } else {
    $conn=$Login["Conn"];
  }
  
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
   } else ;//print("select not in $sql");

  // $conn->close();

} // DoSQL()

function CloseDB() {
  global $Login;
  $Login["Conn"]->close();
}
?>
