<?php  
require_once 'dbConnect.php';  
session_start();  
    class dbFunction {  
            
        function __construct() {  
              
            // connecting to database  
            $db = new dbConnect(); 
            require_once('config.php');  
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABSE);  
            mysqli_select_db($conn,DB_DATABSE);  
            if(!$conn)// testing the connection  
            {  
                die ("Cannot connect to the database");  
            }   
            return $conn;  
        }  
        // destructor  
        function __destruct() {  
              
        }  
		
		
		
		
		 public function Close(){  
            mysqli_close($conn);  
        }  
		function getToken($length){
			 	$token = "";
			// $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			// $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
			 	$codeAlphabet= "0123456789";
			 	$max = strlen($codeAlphabet); // edited

			for ($i=0; $i < $length; $i++) {
				$token .= $codeAlphabet[random_int(0, $max-1)];
			}
		return $token;
		}
        public function UserRegister($uid, $name,$email, $username, $password){ 
				$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABSE);  
				mysqli_select_db($conn,DB_DATABSE); 
				
				//$uid = mysqli_query($conn,"ALTER TABLE users AUTO_INCREMENT=100");
				//echo($uid);die;				
                $password = md5($password);  
                echo $qr = mysqli_query($conn,"INSERT INTO users(uid, name, email, username, password) values('".$uid."','".$name."','".$email."','".$username."','".$password."')") or die(mysqli_error($conn));  
                return $qr;  
               
        }  
        public function Login($username, $password){ 
		
				$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABSE);  
				mysqli_select_db($conn,DB_DATABSE); 
			
            $res = mysqli_query($conn,"SELECT * FROM users WHERE username = '".$username."' AND password = '".md5($password)."'");  
            $user_data = mysqli_fetch_array($res,MYSQLI_NUM);  
            //print_r($user_data);  die();
            $no_rows = mysqli_num_rows($res);  
            if ($no_rows == 1)   
            {  
           
                $_SESSION['login'] = true;  
                $_SESSION['uid'] = $user_data['uid'];  
                $_SESSION['username'] = $user_data['username'];  
                $_SESSION['email'] = $user_data['emailid'];  
                return TRUE;  
            }  
            else  
            {  
                return FALSE;  
            }  
               
                   
        } 
		
        public function isUserExist($email){  
				$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABSE);  
            mysqli_select_db($conn,DB_DATABSE); 
            $result = mysqli_query($conn,"SELECT * FROM users WHERE email= '".$email."'");  
            echo $row = mysqli_num_rows($result);  
			
            if($row > 0){  
                return true;  
            } else {  
                return false;  
            }  
        }  
    }  
?>  