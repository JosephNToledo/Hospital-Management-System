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

            if($result){
                $authenticated=$result->verify==1;
            }
        }
        if (!$authenticated){
            echo "Not valid";
        }
        else{
                header("Location: view_patients.php");
                exit();
        }
    }
?>


<!DOCTYPE html>
<html>

    <head></head>

    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            username : <input type="text" name="user"/><br/>
            password : <input type="password" name="pwd"/><br/>
            <input type="submit" value="Verify" name="verify"/>
        </form>
    </body>
</html>