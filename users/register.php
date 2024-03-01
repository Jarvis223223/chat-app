<?php 
  require_once("../layout/header.php"); 

  if (isset($_POST['signInBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $statement = $db->prepare("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    $statement->execute();
    echo "<script>sweetAlert('registration', 'login.php')</script>";
  }

?>
    <div class="signin-form">
      <form class="reform mx-auto mt-5" method="post">
        <p class="title">Register </p>
        <p class="message">Signup now and get full access to our app. </p>

        <label>
            <input required placeholder="" name="name" type="name" class="input">
            <span>Name</span>
        </label> 
                
        <label>
            <input required placeholder="" name="email" type="email" class="input">
            <span>Email</span>
        </label> 
            
        <label>
            <input required placeholder="" name="password" type="password" class="input">
            <span>Password</span>
        </label>
        <label>
          <!-- <span>Photo</span> -->
          <input required placeholder="Upload Photo" name="image" type="file" class="file form-control">
        </label>
        <button name="signInBtn" class="submit">Register</button>
        <p class="signin">Already have an acount ? <a href="login.php">Login</a> </p>
      </form>
    </div>

    <?php require_once("../layout/footer.php") ?>