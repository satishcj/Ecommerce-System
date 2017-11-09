<?php 
ini_set('display_errors', '1');
 include_once('dbFunction.php');  
    $funObj = new dbFunction(); 
	$conn = $funObj->getConnection();
	
?>
<?php 
if(isset($_POST['cid']) && isset($_POST['pid'])){
	 $cid = $_POST['cid'];
	$pid = $_POST['pid'];
	
	$addcart = $funObj->addtoCart($cid,$pid);
	header("location: cart.php"); 
    exit();
}

?>
<?php
session_start();
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart" && isset($_SESSION["cid"])) {
		$cid = $_SESSION["cid"];
		$sql = mysqli_query($conn,"SELECT * FROM customer_cart WHERE customerid='$cid' LIMIT 1");
		$count = mysqli_num_rows($sql);
		if($count!=0){
			$sql = mysqli_query($conn,"DELETE FROM customer_cart WHERE customerid='$cid'") or die(mysqli_error($conn));
		}
}
?>

<?php
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "" && isset($_SESSION["cid"])) {
	$cid = $_SESSION["cid"];
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); 
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$ssql = mysqli_query($conn,"UPDATE customer_cart SET quantity='$quantity' WHERE productid='$item_to_adjust' AND customerid='$cid' ") or die (mysqli_error($conn));
}
?>

<?php
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != ""  && isset($_SESSION["cid"])) {
	$cid = $_SESSION["cid"];
	$toremove = $_POST['index_to_remove'];
	$sql = mysqli_query($conn,"DELETE FROM customer_cart WHERE customerid='$cid' AND productid='$toremove'") or die(mysqli_error($conn));
}
?>

<?php
$cartOutput = "";
$cartTotal = "";
if(isset($_SESSION["cid"])){
	$cid=$_SESSION["cid"];
	$sql = mysqli_query($conn,"SELECT * FROM customer_cart WHERE customerid='$cid'") or die(mysqli_error($conn));
	$count = mysqli_num_rows($sql);	
	if($count==0){
		$cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
	}
	else {
		$i=0;
		while ($lists = mysqli_fetch_array($sql)) {
				$item_id = $lists["productid"];
				$sqls = mysqli_query($conn,"SELECT * FROM products WHERE id='$item_id' LIMIT 1") or die(mysqli_error($conn));
				$list = mysqli_fetch_array($sqls);
				$product_name = $list["product_name"];
				$price = $list["price"];
				$details = $list["details"];
				$quantity = $lists["quantity"];
				$pricetotal = $price * $quantity;
				$cartTotal = $pricetotal + $cartTotal;
				$cartOutput .= "<tr>";
		$cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $product_name . '</a><br /><img src="product_imgs/' . $item_id . '.jpg" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
		$cartOutput .= '<td>' . $details . '</td>';
		$cartOutput .= '<td>INR' . $price . '</td>';
		$cartOutput .= '<td><form action="cart.php" method="post">
		<input name="quantity" type="text" value="' . $quantity . '" size="1" maxlength="2" />
		<input name="adjustBtn' . $item_id . '" type="submit" value="change" />
		<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
		</form></td>';
		$cartOutput .= '<td>' . $pricetotal . '</td>';
		$cartOutput .= '<td><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $item_id . '" /></form></td>';
		$cartOutput .= '</tr>';
		}
		$cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." INR</div>";

	}
}

//Set useful variables for paypal form
$paypal_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
$paypal_username = 'pateljignesh.spaceo@gmail.com'; //Business Email
//$paypal_username = 'jijijyothi91@gmail.com'; //Business Email
//$paypal_username = 'LNP2793CNXKAW';





?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Cart</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <div id="pageContent">
    <div style="margin:24px; text-align:left;">
	
    <br />
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
      <tr>
        <td width="18%" bgcolor="#C5DFFA"><strong>Product</strong></td>
        <td width="45%" bgcolor="#C5DFFA"><strong>Product Description</strong></td>
        <td width="10%" bgcolor="#C5DFFA"><strong>Unit Price</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Quantity</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Total</strong></td>
        <td width="9%" bgcolor="#C5DFFA"><strong>Remove</strong></td>
      </tr>
     <?php echo $cartOutput; ?>
     <!-- <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr> -->
    </table>
    <?php echo $cartTotal; ?>
    <br />
<br />
    <br />
    <br />
    <a href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
	<button><a href="<?php echo $paypal_link; ?>">Proceed to Payment Gateway</a></button>
    </div>
   <br />
  </div>
  <?php include_once("footer.php");?>
   <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="<?php echo $paypal_username; ?>">
        
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="hidden" name="item_name" value="<?php echo $product_name; ?>">
        <input type="hidden" name="item_number" value="<?php echo $item_id; ?>">
        <input type="hidden" name="amount" value="<?php echo $price; ?>">
        <input type="hidden" name="currency_code" value="USD">
        
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='http://localhost/ecommerce/paypal_cancel.php'>
		<input type='hidden' name='return' value='http://localhost/ecommerce/paypal_success.php'>

        
        
</div>
</body>
</html>