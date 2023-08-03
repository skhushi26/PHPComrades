<?php
require_once "dal/user.php";
// $errors = [];
$errors = [
  "name" => "",
  "email" => "",
  "phone" => "",
  "province" => "",
  "password" => "",
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate the form inputs and collect any errors
    // Assuming you have already included and instantiated the User class
    $user = new User();
    $user->setName($_POST["name"]);
    $user->setEmail($_POST["email"]);
    $user->setPassword($_POST["password"]);
    $user->setPhone($_POST["phone"]);
    $user->setProvince($_POST["province"]);
  
    // Check for errors
    $errors = $user->getErrors();
  
    if (empty($errors)) {
        // update
    }
  }
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/registration.css">
    <link rel="shortcut icon" href="/images/home_decor_logo.jpeg">
    <title>Registration</title>
</head>
<body>

        <?php require_once "navigation.php"; ?>
        
        <div class="container">
          <div class="row">
              <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
                  <div class="panel border bg-white">
                      <div class="panel-heading">
                          <h3 class="pt-3 font-weight-bold">YOUR PROFILE</h3>
                      </div>
                      <div class="panel-body p-3">
                      <form method="post" id="signup_form">
             
                      <?php 
                      $isRegisterSuccessful = isset($_COOKIE["isRegisterSuccessful"]) ? $_COOKIE["isRegisterSuccessful"] : true;
                      echo !$isRegisterSuccessful ? "<div class='alert alert-danger' role='alert'>An error occurred while registering. Please try again.</div>" : ""; 
                      ?>

                <!-- NAME -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="name" name="name" placeholder="Name"> </div>
                  <?php echo $errors["name"] != null
                    ? "<span class='text-danger'>*" .
                      $errors["name"] .
                      "</span>"
                    : ""; ?>
                </div>
           
                <!-- EMAIL -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="email" name="email" placeholder="Email"> </div>
                  <?php echo $errors["email"] != null
                    ? "<span class='text-danger'>*" .
                      $errors["email"] .
                      "</span>"
                    : ""; ?>
                </div>
           
                <!-- PHONE -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="phone" name="phone" placeholder="Phone"> </div>
                  <?php echo $errors["phone"] != null
                    ? "<span class='text-danger'>*" .
                      $errors["phone"] .
                      "</span>"
                    : ""; ?>
                </div>
           

            <!-- PASSWORD -->
            <div class="form-group py-1 pb-2">
                  <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Password">
                  </div>
                  <?php echo $errors["password"] != null
                    ? "<span class='text-danger'>*" .
                      $errors["password"] .
                      "</span>"
                    : ""; ?>
              </div>


                <!-- PROVINCE -->
                <div class="form-group py-1 pb-2">
                <select class="form-control" id='province' name='province' >
                <?php
                $provinces = ["ON", "AB", "BC", "MB"];
                echo "<option value='-1'>Select a province..</option>";
                foreach ($provinces as $province) {
                  echo "<option value='$province'>$province</option>";
                }
                ?>
            </select>
            <?php echo $errors["province"] != null
              ? "<span class='text-danger'>*" . $errors["province"] . "</span>"
              : ""; ?>
            </div>


                <button type="submit" class="btn btn-block mt-3 btn-login" id="submit">Update</button>
       
              </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <p><small id="copyright-white" >Copyright &copy; 2023 PHP Comrades, All Rights Reserved</small></p>
      
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>