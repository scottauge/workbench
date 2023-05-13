// c:\tmp\dosql.php
// tested select
// tested create
// tested update
// tested delete

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

function DoWithData($row) {

  foreach($row as $_key => $_value) print("row[$_key] = $_value<br/>");
  
  print("<br/>");

} // DoWithData()



$Login = array (
"servername" => "localhost",
"username" => "root",
"password" => "",
"dbname" => "game"
);

$DataFunction="DoWithData";

$s="insert into room (RecID, Description, MapName) values(4, 'Doorway', 'a');";
//$s="delete from room where RecID = 4";
//$s="update room set Description = 'New' where RecID = 4;";
//$s="select * from room;";

DoSQL ($s, $Login, $DataFunction);


printf("\nDid %s", $s);



