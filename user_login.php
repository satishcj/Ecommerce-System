
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Log In </title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <?php 
  
if (isset($_SESSION["user"])) {
    header("location: index.php"); 
    exit();
}
?>

<?php 
if (isset($_POST["username"]) && isset($_POST["password"])) {

	$user = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]);
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
	echo $password = md5($password);
   include_once('dbFunction.php');  
    $funObj = new dbFunction(); 
	$conn = $funObj->getConnection();
	
    $sql = mysqli_query($conn,"SELECT cid FROM customers WHERE username='$user' AND password='$password' LIMIT 1"); 
	
    $existCount = mysqli_num_rows($sql);
	
    if ($existCount == 1) { 
	     while($row = mysqli_fetch_array($sql)){ 
             echo $id = $row["cid"];
		 }
		 $_SESSION["cid"] = $id;
		 $_SESSION["user"] = $user;
		 $_SESSION["password"] = $password;
		 
		 header("location: index.php?userloginsuccess");
         exit();
    } else {
		echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
		exit();
	}
}
?>
  <div id="pageContent"><br />
    <div align="left" style="margin-left:24px;">
      <h2>Please Log In To Buy</h2>
      <form id="form2" name="form2" method="post" action="user_login.php">
        User Name:<br />
          <input name="username" type="text" id="username" size="40" />
        <br /><br />
        Password:<br />
       <input name="password" type="password" id="password" size="40" />
       <br />
       <br />
       <br />
       
         <input type="submit" name="button" id="button" value="Log In" />
       
      </form>
      <p>&nbsp; </p>
    </div>
    <br />
  <br />
  <br />
  </div>
  <?php include_once("footer.php");?>
</div>
</body>
</html>