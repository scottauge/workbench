function ConnectTheatre() {
$servername = "localhost";
$database = "theatre";
$username = "root";
$password = "";

// Create connection

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

return $conn;
}

function SendStatement ($conn,$statement){
$stmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt, "?")) {
  // Bind parameters
  //mysqli_stmt_bind_param($stmt, "s", $statement);

  // Execute query
  mysqli_stmt_execute($stmt);

  // Bind result variables
  mysqli_stmt_bind_result($stmt, $district);

  // Fetch value
  mysqli_stmt_fetch($stmt);

  printf("%s is in district %s", $city, $district);

  // Close statement
  mysqli_stmt_close($stmt);
}

mysqli_close($con);
}

ConnectTheatre();
SendStatement();