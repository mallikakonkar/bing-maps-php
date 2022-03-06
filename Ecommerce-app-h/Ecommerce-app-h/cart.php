<?php

session_start();
$recListCart= $_SESSION['array'];
// print_r($recListCart);
// print_r(82874);

?>
<!DOCTYPE html>
<html>
<script>
		// location.reload();
		window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
	</script>
	<head>
		<meta charset="UTF-8">
		<title>Roosevelt Field</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>

		<style>
			body {
			background-image: url('wall-background.jpg');
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: 100% 100%;
			}
			</style>
			
	</head>

	

<body>
<div class="wait overlay">
	<div class="loader"></div>
</div>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse" aria-expanded="false">
					<span class="sr-only">navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">Roosevelt Field</a>
			</div>
		<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>Home</a></li>
				<li><a href="index.php"><span class="glyphicon glyphicon-modal-window"></span>Store</a></li>
			</ul>
		</div>
	</div>
	</div>
	<p><br/></p>
	<p><br/></p>
	<p><br/></p>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="cart_msg">
				<!--Cart Message--> 
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row justify-content-center">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">Cart Checkout</div>
					<div class="panel-body">
						<div class="row justify-content-center">
							<div class="col-md-12">
							<div class="row">
							<div class="col-md-3"></div>

							<div class="col-md-2 col-xs-2" style="text-align: center;"><b>Store Image</b></div>
							<div class="col-md-2 col-xs-2"><b>Store Name</b></div>
							<div class="col-md-2 col-xs-2"><b>Delete</b></div>
							<div class="col-md-3"></div>
					
							<!-- <div class="col-md-2 col-xs-2"><b>Quantity</b></div> -->
							<!-- <div class="col-md-2 col-xs-2"><b>Product Price</b></div> -->
							<!-- <div class="col-md-2 col-xs-2"><b>Price in <?php 
							// echo CURRENCY; 
							?></b></div> -->
						</div>

						</div>
						</div>
						<div id="cart_checkout"></div>
						<!--<div class="row">
							<div class="col-md-2">
								<div class="btn-group">
									<a href="#" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
									<a href="" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span></a>
								</div>
							</div>
							<div class="col-md-2"><img src='product_images/imges.jpg'></div>
							<div class="col-md-2">Product Name</div>
							<div class="col-md-2"><input type='text' class='form-control' value='1' ></div>
							<div class="col-md-2"><input type='text' class='form-control' value='5000' disabled></div>
							<div class="col-md-2"><input type='text' class='form-control' value='5000' disabled></div>
						</div> -->
						<!--<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4">
								<b>Total $500000</b>
							</div> -->
						</div> 
					</div>


					<h2 style="padding: 10px 0;">
						Recommended just for you! 
					</h2>

					
					<br>

					
					
					
				</div>
				
			</div>
			<div class="row">
			<div class="col-md-2"></div>

				<div class="col-md-8">
				
				<?php

// $recListCart=array_unique($recListCart,SORT_REGULAR);

$k=count($recListCart)-1;

while($k!=-1)
{ 

$product_id = $recListCart[$k][0];
$product_title = $recListCart[$k][1];
$product_image = $recListCart[$k][2];
$category=$recListCart[$k][3];

$k=$k-1;





echo "
<div class='col-md-4'>
	<div class='panel panel-info'>
		<div class='panel-heading'>$product_title</div>
		<div class='panel-body'>
			<img src='product_images/$product_image' style='display: block;
			margin-left: auto;
			margin-right: auto;
			height: 250px;
			width: 75%;'/>
		</div>
		<div class='panel-heading' style='padding: 10px'>
			<button pid='$product_id' style='float:center;' id='product' class='btn btn-danger btn-xs' onClick='window.location.reload()'>Add To Cart</button>
		</div>
	</div>
</div>	
";
}


?>

				</div>
				
			</div>
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
				<div class="panel-footer">
						<button><a href="distancecalculateNew.php">Navigate</a></button>
					</div>
				</div>
			</div>
			

			
			
		</div>
<?php
		// print_r($recListCart);
?>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="main.js"></script>
</body>	


<!-- echo 
						'<div class="row">
								<div class="col-md-2">
									
								</div>
								<input type="hidden" name="product_id[]" value="'.$product_id.'"/>
								<div class="col-md-2"><img class="img-responsive" src="product_images/'.$product_image.'"></div>
								<div class="col-md-2">'.$product_title.'</div>
								
							</div>'; -->

</html>
















		