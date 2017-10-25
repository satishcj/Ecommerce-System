<?php
  include_once('dbFunction.php');  
       
   $funObj = new dbFunction();
	$message = ""; // initial message 
	
	if(isset($_POST['submit_data']) ){  

		// Gets the data from post
		$length = 10;
		$uid =$funObj->getToken($length);
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirm_password'];  		
		if($password == $confirmPassword){  
            $emailexists = $funObj->isUserExist($email);  
			
			
            if(!$emailexists){  
                $register = $funObj->UserRegister($uid, $name, $email, $username, $password);  
                if($register){  

                     echo "<script>alert('Registration Successful')</script>";  
					?> <script type="text/javascript">location.href = 'login.php';</script><?php
                }else{  
                    echo "<script>alert('Registration Not Successful')</script>";  
                }  
            } else {  
                echo "<script>alert('Email Already Exist')</script>";  
            }  
        } else {  
            echo "<script>alert('Password Not Match')</script>";  
          
        }  
		
	  
        
    }  
	?>


<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
   <div class="main">
   	
      <div class="one">
        <div class="register">
          <h3>Create your account</h3>
				<!-- showing the message here-->
				<div><?php echo $message;?></div>
          <form id="reg-form" action="register.php" method="post">
            <div>
              <label for="name">Name</label>
              <input name="name" type="text" id="name" spellcheck="false" placeholder=""/>
            </div>
            <div>
              <label for="email">Email</label>
              <input name="email" type="text" id="email" spellcheck="false" placeholder=""/>
            </div>
            <div>
              <label for="username">Username</label>
              <input name="username" type="text" id="username" spellcheck="false" placeholder="" />
            </div>
            <div>
              <label for="password">Password</label>
              <input name="password" type="password" id="password" />
            </div>
            <div>
              <label for="confirm_password">Confirm Password </label>
              <input  name="confirm_password" type="password" id="password-again" />
            </div>
            <div>
              <label></label>
              <input type="submit" name="submit_data" value="Create Account" id="create-account" class="button"/>
            </div>
          </form>
        </div>
      </div>
      <?php //} ?>
      <div class="two">

      </div>
    </div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="js/index.js"></script>

</body>
</html>
