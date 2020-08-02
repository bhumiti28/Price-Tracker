<?php
    session_start();

    require 'login_reg_form.htm';

    error_reporting(-1);
    ini_set('display_errors', true);
    
    $host = "localhost";
    $dbuname = "root";
    $dbpsd = "";
    $dbname = "price_tracker";

    if(isset($_POST['submit-login'])){
        $check_in = $_COOKIE['check_lin'];
        $userid_in = $_POST['username'];
        $pass_in = $_POST['password'];
        if($check_in){
            $conn = new mysqli($host, $dbuname, $dbpsd, $dbname);

            if($conn->connect_error):
                die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
            endif;
            
            $sql = "SELECT check_login('".$userid_in."', '".$pass_in."') AS check_login;";
            if($result = $conn->query($sql)){
                $row = $result->fetch_assoc();
                if($row['check_login'] == 'Y'){
                    $_SESSION['u_id'] = $userid_in;
                    echo "Logged in successfully";
                    header("Location /index.php");
                }else{
                    echo $row['check_login'];
                    echo "User-ID or Password doesn't exist";
                }
            }else{
                echo "Error: " . $sql . "" . mysqli_error($conn);
            }
            $conn->close();
        }
    }

    if(isset($_POST['submit-reg'])){
        $check_sup = $_COOKIE['check_sup'];
        $userid = $_POST['usernamesignup'];
        $pass = $_POST['pswd1'];
        $mail = $_POST['emailsignup'];

        if($check_sup){
            $conn = mysqli_connect($host, $dbuname, $dbpsd, $dbname);

            if($conn->connect_error):
                die('Connect_Error'.mysqli_connect_error().'- ErrorNo : '.mysqli_connect_errno());
            endif;
            
            $sql = "INSERT into user_detail VALUES ('".$userid."' ,'".$mail."', '".$pass."')";
            if(mysqli_query($conn, $sql)){
                echo "New record created successfully...";
                header("Location /index.php");
            }else{
                echo "Error: " . $sql . "" . mysqli_error($conn);
            }
            $conn->close();
        }
    }