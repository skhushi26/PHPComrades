<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/site.css">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="/images/drive-test.ico">
    <title>Registration</title>
</head>
<body>

        <?php 
        require_once('navigation.php');
        ?>
        
        <div class="container">
          <div class="row">
              <div class="offset-md-2 col-lg-5 col-md-7 offset-lg-4 offset-md-3">
                  <div class="panel border bg-white">
                      <div class="panel-heading">
                          <h3 class="pt-3 font-weight-bold">LOGIN</h3>
                      </div>
                      <div class="panel-body p-3">
                          <form action="/login" method="post" id="login_form">

                              <div class="form-group py-2">
                                  <div class="input-field"><input type="text" id="email" name="email" placeholder="Email"> </div>
                                  <span class="error-email"></span>
                                </div>
                              <div class="form-group py-1 pb-2">
                                  <div class="input-field"><input type="password" id="password" name="password" placeholder="Password"></div>
                                  <span class="error-password"></span>
                              </div>
                              <button type="submit" class="btn btn-block mt-3 btn-login" id="submit">Login</button>
                              <div class="text-center pt-4 text-muted">Don't have an account? 
                                <a href="registration.php" id="signup">Sign up</a> 
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