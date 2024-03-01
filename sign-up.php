<?php 
  require_once("layout/header.php"); 
  require_once("config/db.php");

  if (isset($_POST['signInBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $imageName = $_FILES['image']['name'];
    $imageType = $_FILES['image']['type'];
    $imageTmpName = $_FILES['image']['tmp_name'];
    $password = md5($password);
    $status = "Active Now";

    $imageName = uniqid() . "_" . $imageName;
    if (in_array($imageType, ['image/png', 'image/jpg', 'image/jpeg'])) {
      move_uploaded_file("$imageTmpName", "assets/images/$imageName");
    }
    $statement = $db->prepare("INSERT INTO users (name, email, password, image, status) VALUES ('$name', '$email', '$password', '$imageName', '$status')");
    $result = $statement->execute();
    if ($result) {
      echo "<script>sweetAlert('registration', 'sign-in.php')</script>";
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Sign Up – Swipe</title>
    <meta name="description" content="#" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap core CSS -->
    <link
      href="swipe-chat-platform/dist/css/lib/bootstrap.min.css"
      type="text/css"
      rel="stylesheet"
    />
    <!-- Swipe core CSS -->
    <link href="swipe-chat-platform/dist/css/swipe.min.css" type="text/css" rel="stylesheet" />
    <!-- Favicon -->
    <link href="swipe-chat-platform/dist/img/favicon.png" type="image/png" rel="icon" />
  </head>
  <body class="start">
    <main>
      <div class="layout">
        <!-- Start of Sign Up -->
        <div class="main order-md-2">
          <div class="start">
            <div class="container">
              <div class="col-md-12">
                <div class="content">
                  <h1>Create Account</h1>
                  <div class="third-party">
                    <button class="btn item bg-blue">
                      <i class="material-icons">pages</i>
                    </button>
                    <button class="btn item bg-teal">
                      <i class="material-icons">party_mode</i>
                    </button>
                    <button class="btn item bg-purple">
                      <i class="material-icons">whatshot</i>
                    </button>
                  </div>
                  <p>or use your email for registration:</p>
                  <form class="signup" method="post" enctype="multipart/form-data">
                    <div class="form-parent">
                      <div class="form-group">
                        <input
                          type="text"
                          name="name"
                          id="inputName"
                          class="form-control"
                          placeholder="Username"
                          required
                        />
                        <button class="btn icon">
                          <i class="material-icons">person_outline</i>
                        </button>
                      </div>
                      <div class="form-group">
                        <input
                          type="email"
                          name="email"
                          id="inputEmail"
                          class="form-control"
                          placeholder="Email Address"
                          required
                        />
                        <button class="btn icon">
                          <i class="material-icons">mail_outline</i>
                        </button>
                      </div>
                    </div>
                    <div class="form-group">
                      <input
                        type="password"
                        name="password"
                        id="inputPassword"
                        class="form-control"
                        placeholder="Password"
                        required
                      />
                      <button class="btn icon">
                        <i class="material-icons">lock_outline</i>
                      </button>
                    </div>
                    <!-- <div class="form-group">
                      <input
                        type="file"
                        name="image"
                        class="form-control"
                        required
                      />
                    </div> -->
                    <div class="custom-file form-group">
                      <input type="file" name="image" class="custom-file-input " id="customFile" required>
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <button
                      type="submit"
                      name="signInBtn"
                      class="btn button"
                    >
                      Sign Up
                    </button>
                    <div class="callout">
                      <span
                        >Already a member?
                        <a href="sign-in.html">Sign In</a></span
                      >
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Sign Up -->
        <!-- Start of Sidebar -->
        <div class="aside order-md-1">
          <div class="container">
            <div class="col-md-12">
              <div class="preference">
                <h2>Welcome Back!</h2>
                <p>
                  To keep connected with your friends please login with your
                  personal info.
                </p>
                <a href="sign-in.php" class="btn button">Sign In</a>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Sidebar -->
      </div>
      <!-- Layout -->
    </main>
    <!-- Bootstrap core JavaScript
		================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script
      src="dist/js/jquery-3.3.1.slim.min.js"
      integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
      crossorigin="anonymous"
    ></script>
    <script>
      window.jQuery ||
        document.write(
          '<script src="dist/js/vendor/jquery-slim.min.js"><\/script>'
        );
    </script>
    <script src="dist/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
