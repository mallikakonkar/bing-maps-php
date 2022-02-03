<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

// $shoprec=array();
$recList=array();


if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";
	$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
	echo "
		<div class='nav nav-pills nav-stacked'>
			<li class='active'><a href='#'><h4>Store Categories</h4></a></li>
	";
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
			echo "
					<li style='background:white'><a href='#' class='category' cid='$cid'>$cat_name</a></li>
			";
		}
		echo "</div>";
	}
}
// if(isset($_POST["brand"]))
// {
// 	$brand_query = "SELECT * FROM brands";
// 	$run_query = mysqli_query($con,$brand_query);
// 	echo "
// 		<div class='nav nav-pills nav-stacked'>
// 			<li class='active'><a href='#'><h4>Brands</h4></a></li>
// 	";
// 	if(mysqli_num_rows($run_query) > 0){
// 		while($row = mysqli_fetch_array($run_query)){
// 			$bid = $row["brand_id"];
// 			$brand_name = $row["brand_title"];
// 			echo "
// 					<li><a href='#' class='selectBrand' bid='$bid'>$brand_name</a></li>
// 			";
// 		}
// 		echo "</div>";
// 	}
// }
if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/9);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#' page='$i' id='page'>$i</a></li>
		";
	}
}
if(isset($_POST["getProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products LIMIT $start,$limit";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			echo "
				<div class='col-md-4'>
							<div class='panel panel-info'>
								<div class='panel-heading'>$pro_title</div>
								<div class='panel-body'>
									<img src='product_images/$pro_image' style='display: block;
									margin-left: auto;
									margin-right: auto;
									height: 250px;
									width: 75%;
									padding:22px 0;'
									/>
								</div>
								<div class='panel-heading' style='padding: 10px'>
									<button pid='$pro_id' style='float:center;' id='product' class='btn btn-danger btn-xs'>Add To Cart</button>
								</div>
							</div>
						</div>	
			";
		}
	}
}
if(isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])){
	if(isset($_POST["get_seleted_Category"])){
		$id = $_POST["cat_id"];
		$sql = "SELECT * FROM products WHERE product_cat = '$id'";
	}else if(isset($_POST["selectBrand"])){
		$id = $_POST["brand_id"];
		$sql = "SELECT * FROM products WHERE product_brand = '$id'";
	}else {
		$keyword = $_POST["keyword"];
		$sql = "SELECT * FROM products WHERE product_keywords LIKE '%$keyword%'";
	}
	
	$run_query = mysqli_query($con,$sql);
	while($row=mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			echo "
				<div class='col-md-4'>
							<div class='panel panel-info'>
								<div class='panel-heading'>$pro_title</div>
								<div class='panel-body'>
									<img src='product_images/$pro_image' style='display: block;
									margin-left: auto;
									margin-right: auto;
									height: 250px;
									width: 75%;
									padding:22px 0;'/>
								</div>
								<div class='panel-heading'  style='padding: 10px'>
									<button pid='$pro_id' style='float:center;' id='product' class='btn btn-danger btn-xs'>Add To Cart</button>
								</div>
							</div>
						</div>	


						
			";
		}
	}
	


	if(isset($_POST["addToCart"])){
		

		$p_id = $_POST["proId"];
		

		if(isset($_SESSION["uid"])){

		$user_id = $_SESSION["uid"];

		$sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
		$run_query = mysqli_query($con,$sql);
		$count = mysqli_num_rows($run_query);
		if($count > 0){
			echo "
				<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Store is already added into the cart add other Stores.</b>
				</div>
			";//not in video
		} else {
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','$user_id','1')";
			if(mysqli_query($con,$sql)){
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Store is Added..!</b>
					</div>
				";
			}
		}
		}else{
			$sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
			$query = mysqli_query($con,$sql);
			if (mysqli_num_rows($query) > 0) {
				echo "
					<div class='alert alert-warning'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Store is already added into the cart add other Stores.</b>
					</div>";
					exit();
			}
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','1')";
			if (mysqli_query($con,$sql)) {
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Your Shop has been added to cart!</b>
					</div>
				";
				exit();
			}
			
		}
		
		
		
		
	}

//Count User cart item
if (isset($_POST["count_item"])) {
	//When user is logged in then we will count number of item in cart by using user session id
	if (isset($_SESSION["uid"])) {
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = $_SESSION[uid]";
	}else{
		//When user is not logged in then we will count number of item in cart by using users unique ip address
		$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = '$ip_add' AND user_id < 0";
	}
	
	$query = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($query);
	echo $row["count_item"];
	exit();
}
//Count User cart item

//Get Cart Item From Database to Dropdown menu
if (isset($_POST["Common"])) {

	if (isset($_SESSION["uid"])) {
		//When user is logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,a.product_cat FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
	}else{
		//When user is not logged in this query will execute
		$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,a.product_cat FROM products a,cart b WHERE a.product_id=b.p_id AND b.ip_add='$ip_add' AND b.user_id < 0";
	}
	$query = mysqli_query($con,$sql);
	if (isset($_POST["getCartItem"])) {
		//display cart item in dropdown menu
		if (mysqli_num_rows($query) > 0) {
			$n=0;
			while ($row=mysqli_fetch_array($query)) {
				$n++;
				$product_id = $row["product_id"];
				$product_title = $row["product_title"];
				$product_price = $row["product_price"];
				$product_image = $row["product_image"];
				$cart_item_id = $row["id"];
				$qty = $row["qty"];
				echo '
					<div class="row">
						<div class="col-md-3">'.$n.'</div>
						<div class="col-md-3"><img class="img-responsive" src="product_images/'.$product_image.'" /></div>
						<div class="col-md-3">'.$product_title.'</div>
						
					</div>';
				
			}
			?>
				<a style="float:right;" href="cart.php" class="btn btn-warning">See Shops&nbsp;&nbsp;<span class="glyphicon glyphicon-edit"></span></a>
			<?php
			exit();
		}
	}
	if (isset($_POST["checkOutDetails"])) {

		$sql2 = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty,a.product_cat FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
		$query2 = mysqli_query($con,$sql2);

		$arr=array();
		$row1=mysqli_fetch_all($query2);
		$i=count($row1);
		// print_r(count($row1));

		while($i!=0)
		{
			array_push($arr,$row1[$i-1][0]);		
			$i=$i-1;	
		}
		// print_r($arr);

		
		if (mysqli_num_rows($query) > 0) {
			//display user cart item with "Ready to checkout" button if user is not login
			echo "<form method='post' action='login_form.php'>";
				$n=0;
				// print_r(1);
				
				while ($row=mysqli_fetch_array($query)) {
				// print_r($row);

				
				// print_r(2);
		
		


					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];
					$category=$row["product_cat"];


					// $it=mysqli_fetch_all($query);

					// $array
					// print_r($it);

					// $pid=array_column($it,0);

					// print_r($pid);

					// print_r(gettype($arr));
					// print_r(implode(',', $arr));
					// print_r("jn");
					// print_r(in_array(70,$arr));



					$sql3="SELECT product_id,product_title,product_image,product_cat 
					FROM products 
					WHERE product_cat=$category and product_id NOT IN (" . implode(',', $arr) . ")";
					
					// -- and pid NOT IN (22,24,80)";

					
					// -- in_array($product_id,$arr);";

// and in_array($product_id,$pid);

					$query3 = mysqli_query($con,$sql3);

					// if (mysqli_fetch_all($query) > 0) {
					// 	print_r("yes");
					// }
					// 	else{
					// 		print_r("no");
					// 	}

					// print_r(2);
					$list=mysqli_fetch_all($query3);
					shuffle($list);

					// $list = array_map("unserialize", array_unique(array_map("serialize", $list)));

					// $list=array_unique($list);


					
					 
					// $newArray = array(); 
					// $Fruits = array(); 
					// foreach ( $list AS $key => $line ) { 
					// 	if ( !in_array($line[0], $Fruits) ) { 
					// 		$Fruits[] = $line[0]; 
					// 		$newArray[$key] = $line; 
					// 	} 
					// } 
					// $originalArray = $newArray; 
					// $newArray = NULL;
					// $Fruits = NULL;
					// $list=$originalArray;
					 
					// print_r($list);



					// print_r($originalArray);
					
					// print(3);

					echo 
						'<div class="row justify-content-center" style="padding: 20px;">
								
								<input type="hidden" name="product_id[]" value="'.$product_id.'"/>
								<input type="hidden" name="" value="'.$cart_item_id.'"/>
								<div class="col-md-3"></div>
								
								<div class="col-md-2"><img class="img-responsive" src="product_images/'.$product_image.'"></div>
								<div class="col-md-2" style="padding-top: 60px">'.$product_title.'</div>

								<div class="col-md-2">
									<div class="btn-group">
										<a href="#" remove_id="'.$product_id.'" class="btn btn-danger remove" style="margin-top: 55px"><span class="glyphicon glyphicon-trash"></span></a>
									</div>
								</div>
								<div class="col-md-3"></div>

								
							</div>';

					$k=0;
					while($k<2)
					{
						

						array_push($recList,$list[$k]);
						$k=$k+1;

					
					}

					$_SESSION['array'] = $recList;

// print_r($recList);

					
				}

				
				
				if (!isset($_SESSION["uid"])) {
					echo '<input type="submit" style="float:right;" name="login_user_with_product" class="btn btn-info btn-lg" value="Ready to Checkout" >
							</form>';
					
				}else if(isset($_SESSION["uid"])){
					//Paypal checkout form
					echo '
						</form>
						<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@ecommerceastro.com">
							<input type="hidden" name="upload" value="1">';
							  
							$x=0;
							$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
							$query = mysqli_query($con,$sql);
							while($row=mysqli_fetch_array($query)){
								$x++;
								echo  	
									'<input type="hidden" name="item_name_'.$x.'" value="'.$row["product_title"].'">
									 </form>';
								}
							  
							// echo   
							// 	'<input type="hidden" name="return" value="http://localhost/project1/payment_success.php"/>
					        //         <input type="hidden" name="notify_url" value="http://localhost/ecommerce-app-h/payment_success.php">
							// 		<input type="hidden" name="cancel_return" value="http://localhost/ecommerce-app-h/cancel.php"/>
							// 		<input type="hidden" name="currency_code" value="USD"/>
							// 		<input type="hidden" name="custom" value="'.$_SESSION["uid"].'"/>
							// 		<input style="float:right;margin-right:80px;" type="image" name="submit"
							// 			src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/blue-rect-paypalcheckout-60px.png" alt="PayPal Checkout"
							// 			alt="PayPal - The safer, easier way to pay online">
							// 	';
				}
			}

			
	}
	
	
}

//Remove Item From cart
if (isset($_POST["removeItemFromCart"])) {
	$remove_id = $_POST["rid"];
	if (isset($_SESSION["uid"])) {
		$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "DELETE FROM cart WHERE p_id = '$remove_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo "<div class='alert alert-danger'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Store is removed from cart</b>
				</div>";
		exit();
	}
}


//Update Item From cart
if (isset($_POST["updateCartItem"])) {
	$update_id = $_POST["update_id"];
	$qty = $_POST["qty"];
	if (isset($_SESSION["uid"])) {
		$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND user_id = '$_SESSION[uid]'";
	}else{
		$sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND ip_add = '$ip_add'";
	}
	if(mysqli_query($con,$sql)){
		echo "<div class='alert alert-info'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Store is updated</b>
				</div>";
		exit();
	}
}



// <div class="col-md-2"><input type="text" class="form-control qty" value="'.$qty.'" ></div>
								// <div class="col-md-2"><input type="text" class="form-control price" value="'.$product_price.'" readonly="readonly"></div>
								// <div class="col-md-2"><input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></div>

// <div class="col-md-3">'.CURRENCY.''.$product_price.'</div>

// echo '<div class="row">
// 							<div class="col-md-8"></div>
// 							<div class="col-md-4">
// 								<b class="net_total" style="font-size:20px;"> </b>
// 					</div>';
// <a href="#" update_id="'.$product_id.'" class="btn btn-primary update"><span class="glyphicon glyphicon-ok-sign"></span></a>


?>






