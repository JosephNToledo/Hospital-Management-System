<?php
    $authenticated = false;
    if(isset($_POST['verify']) && $_POST['verify']=="Verify"){
        
        $user = $_POST['user'];
        $pwd = $_POST['pwd'];
        
        $conn = pg_connect("host=toledo-hospital-db.cpoo6g2yq7yg.us-east-1.rds.amazonaws.com port=5432 dbname=hospital user=toledo password=hospital1998");
        if($conn){
            $query = 'select * from verify($1,$2)';
            $res = pg_query_params($conn,$query,array($user,$pwd));
            $result = pg_fetch_object($res);

            if ($result) {
              if ($result->verify == 1) {
                $authenticated = true;
                // Retrieve user role from a separate query
                $roleQuery = "SELECT role FROM users WHERE username = '$user'";
                $roleResult = pg_query($conn, $roleQuery);
                if (pg_num_rows($roleResult) > 0) {
                  $userRole = trim(strtolower(pg_fetch_result($roleResult, 0, "role")));
                } else {
                  // Handle error: unable to retrieve role
                  echo "Error fetching user role";
                  exit();
                }
              }
            }
        }
        if (!$authenticated){
            echo "Not valid";
        }
        else{
          if ($userRole == 'admin') {
              header("Location: admin.php");
          } elseif ($userRole == 'patient') {
              header("Location: patient.php");
          } else {
              header("Location: index.php");
          }
          exit();
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; /* Remove default browser margins */
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f0f0f0; /* Optional background color */
    }

    .login-form {
      padding: 20px;
      border-radius: 5px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .login-label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      box-sizing: border-box;
    }

  </style>
</head>

<body>
  <div class="login-container">
    <form class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <label class="login-label" for="user">Username:</label>
      <input class="login-input" type="text" name="user" id="user" required>
      <label class="login-label" for="pwd">Password:</label>
      <input class="login-input" type="password" name="pwd" id="pwd" required>
      <input type="submit" value="Verify" name="verify">
    </form>
  </div>
</body>
</html>


