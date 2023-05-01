function DoSQL ($sql, $Login, $DataFunction) {

  // Create connection
  $conn = new mysqli($Login["servername"], $Login["username"], $Login["password"], $Login["dbname"]);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $result = $conn->query($sql);

  if (!$result) {
    print("Error:" . $conn->error);
    exit(0);
  }

  if (str_contains($sql, "select")) {
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $DataFunction($row);
      } // while
    } // if num_row > 0
   } else print("select not in <i>$sql</i><br>");

  $conn->close();

} // DoSQL()