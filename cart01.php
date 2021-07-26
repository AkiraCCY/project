<?php 
session_start();
include('backhome/condb.php');
include('h.php');
 include('navbar2.php'); 
 include('navbar_member.php'); 
 $m_id =$_GET['member_id'];
 
if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
			$count = count($_SESSION["shopping_cart"]);
			$item_array = array(
				'item_id'			=>	$_GET["id"],
				'item_name'			=>	$_POST["hidden_name"],
				'item_price'		=>	$_POST["hidden_price"],
				'item_quantity'		=>	$_POST["quantity"]
				
				
			);
			$_SESSION["shopping_cart"][$count] = $item_array;
			
		}
		else
		{
			echo '<script>alert("Item Already Added")</script>';
		}
	}
	else
	{
		$item_array = array(
			'item_id'			=>	$_GET["id"],
			'item_name'			=>	$_POST["hidden_name"],
			'item_price'		=>	$_POST["hidden_price"],
	
			'item_quantity'		=>	$_POST["quantity"]
		);
		$_SESSION["shopping_cart"][0] = $item_array;
	}
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				echo '<script>alert("Item Removed")</script>';
				echo '<script>window.location="cart.php"</script>';
			}
		}
	}
}

if(isset ($_SESSION['shopping_cart'])){
    $numrand = (mt_rand(100000,999999));
            $num = $numrand ; 
foreach($_SESSION["shopping_cart"] as $keys => $values )
    

{
			$sql = "SELECT * FROM tbl_product_detail as d
			INNER JOIN tbl_product as p ON d.p_id = p.p_id
			INNER JOIN tbl_member as m ON d.member_id = m.member_id";
			$result2 = mysqli_query($con,$sql)or die("Error in query: $sql".mysqli_error());
			$row1 = mysqli_fetch_array($result2);
			$d_total = $values["item_quantity"] * $values["item_price"];
            
			$add = "INSERT INTO tbl_product_detail(d_code,member_id,p_id,d_quantity,d_total,d_status)
			VALUES ( '$num', '$m_id', '$values[item_id]', '$values[item_quantity]', '$d_total', 'cart')";	
            $query4	= mysqli_query($con, $add);
            
            
            

		}

    }
    
	session_unset("shopping_cart");
	Header("Location:cart.php");
?>
