<?php
			include('/home/apw1043/p/dhb.inc');
			$conn = mysqli_connect($db_server,$user,$password,$db_names);
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			$username=trim(addslashes($_POST["username"]));
			$passcode=trim(addslashes($_POST["password"]));
            $email=trim(addslashes($_POST["email"]));

            if(!empty($_POST["username"])&& !empty($_POST["password"])&& !empty($_POST["confirm_password"])){
                if($_POST["password"]==$_POST["confirm_password"]){
                    $sql_string="INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES (NULL, '$username', '$passcode', '$email')";
                    mysqli_query($conn,$sql_string);
                    echo "User data is registered";
                }
                else
                {
                echo "Both Passwords dont match";
                }
            }
            else{
            echo "Missing username or password fix it <br>";
            }
			mysqli_close($conn);
            header("Location: https://example.com");
            exit;
		?>