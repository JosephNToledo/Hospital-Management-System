<?php
// Connection details
$host = "toledo-hospital-db.cpoo6g2yq7yg.us-east-1.rds.amazonaws.com";
$dbname = "hospital";
$user = "toledo"; 
$password = "hospital1998"; 

// Connect using PDO
try {
  $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}

// SQL query
$sql = "SELECT * FROM patients";

// Execute the query
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Patients</title>
  <style>
        body { 
        background-color: #008080; 
        color: black; 
        font-family: Arial, sans-serif; 
        text-align: center; 
        margin: 0; 
        padding: 20px; 
    } 
    h2{ 
        background-color:#ADD8E6; 
            padding: 1%; 
            border-radius: 35px; 
    } 
    table { 
        background-color: #ADD8E6; 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
    } 
    th, td { 
        border: 5px solid #606060FF; 
        padding: 10px; 
        color:black; 
    } 
    th { 
        background-color: #ADD8E6; 
    }
  </style>
</head>
<body>
  <h2>View Patients</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Age</th>
      <th>Gender</th>
      <th>Address</th>
      <th>Admission Date</th>
    </tr>
    <?php
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['age']}</td>
        <td>{$row['gender']}</td>
        <td>{$row['address']}</td>
        <td>{$row['admission_date']}</td>
      </tr>";
    }
    ?>
  </table>
</body>
</html>
