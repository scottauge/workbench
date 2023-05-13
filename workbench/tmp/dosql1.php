// c:\tmp\dosql.php

//function DoSQL($sql, $servername, $username, $password, $dbname) {
function DoSQL ($sql, $Login) {

  // Create connection
  $conn = new mysqli($Login[servername], $Login[username], $Login[password], $Login[dbname]);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_NUM)) {
        DoWithData($row);
      } // while

    } // if num_row > 0

  $conn->close();

} // dosql()

function DoWithData($row) {

  foreach($row as $_key => $_value) 
  {
    print("row[$_key] = $_value<br/>");
  }

  print("<br/>");

} // DoWithData()

function strExists($value, $string)
{
    foreach ((array) $value as $v) {
        if (false !== strpos($string, $v)) return true;
    }
}  // strExists();

Login = array (
server => "localhost"
user => "root"
password => ""
db => "game"
);
$s = "select * from room;";
DoSQL ($s, $Login);
print("\nDid Select");



