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
    <link rel="shortcut icon" href="/images/drive-test.ico">
    <title>Registration</title>
</head>
<body>

        <?php require_once "navigation.php"; ?>
        
        <div class="container">
          <div class="row">
              <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
                  <div class="panel border bg-white">
                      <div class="panel-heading">
                          <h3 class="pt-3 font-weight-bold">SIGN UP</h3>
                      </div>
                      <div class="panel-body p-3">
                      <form action="/signup" method="post" id="signup_form">
             
                <!-- NAME -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="name" name="name" placeholder="Name"> </div>
                  <span class="error-name"></span>
                </div>
           
                <!-- EMAIL -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="email" name="email" placeholder="Email"> </div>
                  <span class="error-email"></span>
                </div>
           
                <!-- PHONE -->
                <div class="form-group py-1">
                  <div class="input-field"><input type="text" id="phone" name="phone" placeholder="Phone"> </div>
                  <span class="error-phone"></span>
                </div>
           

            <!-- PASSWORD -->
            <div class="form-group py-1 pb-2">
                  <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Password">
                  </div>
                  <span class="error-password"></span>
              </div>


                <!-- PROVINCE -->
                <div class="form-group py-1 pb-2">
                <select class="form-control" id='province' name='province' >
                <?php
                    $provinces=["ON","AB","BC","MB"];
                    echo "<option value='-1'>Select a province..</option>";
                    foreach($provinces as $province)
                    {
                        echo "<option value='$province'>$province</option>";
                    }
                ?>
            </select>
              <span class="error-usertype"></span>
            </div>


                <button type="submit" class="btn btn-block mt-3 btn-login" id="submit">Sign Up</button>
                <div class="text-center pt-4 text-muted">
                  You have an account?
                  <a href="login.php" id="login">Login</a>
                </div>
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