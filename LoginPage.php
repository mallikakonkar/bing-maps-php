<?php
include "connection.php";
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']) && !empty($_POST['email']) )
{
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $error = '';
                  
  if (empty($error)) 
  {
    $sql = "SELECT * FROM login WHERE email = '$email';";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) 
    {
      if($password == $row['password']) 
      {
        header("location: Bingdirections.html");
      }
      else 
      {
        $error .= '<p class="error">The password is not valid.</p>';
      }
    }

    else 
    {
      $error .= '<p class="error">No User exists with that email address</p>';
    }
  }
}
?>

<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="LoginPage.css">
	<title>LoginPage</title>
</head>
<body>
	<section class="vh-100">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6 text-black">
      
              <!-- <div class="px-5 ms-xl-4">
                <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                <span class="h1 fw-bold mb-0">Logo</span>
              </div> -->
      
              <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
      
                <form style="width: 23rem;" method="POST" action="">
      
                  <h3 class="fw-normal mb-3 pb-3 align" style="letter-spacing: 1px;">Welcome!</h3>
      
                  <div class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control form-control-lg" />
                    <label class="form-label" for="form2Example18" name="email" id="email1">Email address</label>
                  </div>
      
                  <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control form-control-lg"  />
                    <label class="form-label" for="form2Example28" name="password">Password</label>
                  </div>
      
                  <div class="pt-1 mb-4 align">
                    <button class="btn btn-info btn-lg btn-block" type="submit" name="submit">Login</button>
                  </div>

                  <div class="align" style="color: red;"><?php echo $error; ?></div>
                  
      
                  <p class="small mb-5 pb-lg-2 align"><a class="text-muted" href="#!">Forgot password?</a></p>
                  <div class="align"> 
                    <p>Don't have an account? <a href="signup.php" class="link-info">Register here</a></p>
                  </div>
      
                </form>

                
      
              </div>
      
            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
              <img src="mall1.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
            </div>
          </div>
        </div>
      </section>

</body>
</html>

