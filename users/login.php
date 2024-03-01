<?php 
  require_once("../layout/header.php");

  if (isset($_POST['logInBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $statement = $db->prepare("SELECT * FROM users WHERE email='$email' AND password='$password' ");
    $user = $statement->execute();
    if ($user) {
      $_SESSION['user'] = $user;
      echo "<script>sweetAlert('logged in', '../index.php')</script>";
    }
  }
?> 

    <div class="signin-form">
      <form class="form mt-5 mx-auto" method="post">
        <p class="form-title">Sign in to your account</p>
          <div class="input-container">
            <input type="email" name="email" placeholder="Enter email" required>
            <span>
            </span>
        </div>
        <div class="input-container">
            <input type="password" name="password" placeholder="Enter password" required>
          </div>
          <button name="logInBtn" class="submit">
          Log in
        </button>

        <p class="signup-link">
          No account?
          <a href="register.php">Register</a>
        </p>
    </form>

    </div>
    
    <?php require_once("../layout/footer.php") ?>