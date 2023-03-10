$servername = "localhost";
$username = "root";
$password = "";
$dbname = "theatre";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM advertisers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  echo "<hr><br>";
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["RecID"] . 
         " - Name: <b>" . $row["ContactName"] . 
         " </b>Address1: <b> " . $row["Address1"] . 
         "</b><br>";

  }
} else {
  echo "0 results";
}

$conn->close();
