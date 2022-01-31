<?php
include "connection.php";
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_pass = trim($_POST['confirm_pass']);
//     $salt = mt_rand(1000,9999);
// //    echo $room_code.'<br>';
//     $pass_hash = md5($salt.$password);
//    echo $password.'<br>';
//    echo $salt.'<br>';
//    echo $salt.$password.'<br>';
//    echo $pass_hash.'<br>';
    if($query = $conn->prepare("SELECT * FROM login WHERE email = ?")) {
//        $error = '';
        $query->bind_param('s',$email);
        $query->execute();
        
        $query->store_result();
        if ($query->num_rows > 0){
            $error .= '<p class="error">The email address is already registered!</p>';
        }
        else {
            // Validate Password Strength
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);
            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8){
                $error .= '<p class="error">Password must have atleast 8 characters and should include at least one uppercase, one lowercase, one number, and one special character.</p>';
            }
            // Validate Confirm Password
            if (empty($error)) {
                if ( $password != $confirm_pass){
                    $error .= '<p class="error">Password did not match.</p>'; 
//                echo "Fail";
                }
                else {
                    $insertQuery = $conn->prepare("INSERT INTO login (email, password) VALUES (?, ?);");
                    $insertQuery->bind_param("ss",$email,$password);
                    $result = $insertQuery->execute();
                    if ($result){
                        echo '<p class="success"> Your registration was successful!</p>';
                    } else {
                        echo '<p class="success"> Your registration was unsuccessful</p>';
                    }
                    $insertQuery->close();
//                    echo "Success";
                    header('Location: LoginPage.php');
                }
            } 
        }
        $query->close();
    }
    // Close DB connection
    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
<title>Register</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="LoginPage.css">
<style>
.bg-image-vertical {
  position: relative;
  overflow: hidden;
  background-repeat: no-repeat;
  background-position: right center;
  background-size: auto 100%;
}

.align {
    text-align: center;
}

</style>
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
      
                <form style="width: 23rem;" action="" method="POST" >
      
                  <h3 class="fw-normal mb-3 pb-3 align" style="letter-spacing: 1px;">Register</h3>

                  <div class="form-outline mb-4">
                    <input type="text" id="form2Example18" class="form-control form-control-lg" name="name" required="required"/>
                    <label class="form-label" for="form2Example18">Full Name</label>
                  </div>
      
                  <div class="form-outline mb-4">
                    <input type="email" id="form2Example18" class="form-control form-control-lg" name="email" required="required"/>
                    <label class="form-label" for="form2Example18">Email address</label>
                  </div>
      
                  <div class="form-outline mb-4">
                    <input type="password" id="form2Example28" class="form-control form-control-lg" name="password" required="required"/>
                    <label class="form-label" for="form2Example28">Password</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="form2Example28" class="form-control form-control-lg" name="confirm_pass" required="required"/>
                    <label class="form-label" for="form2Example28">Confirm Password</label>
                  </div>
                  <div>
                    <?php echo $error; ?>
                  </div>
      
                  <div class="pt-1 mb-4 align">
                    <button class="btn btn-info btn-lg btn-block" type="submit" name="submit">Signup</button>
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
