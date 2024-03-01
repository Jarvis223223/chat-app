<?php 
	require_once("layout/header.php");
	if (!isset($_SESSION['users'])) {
		header("location: sign-in.php");
	}

	$userId = $_SESSION['users']->id;
	$statement = $db->prepare("SELECT * FROM users WHERE id != $userId");
	$statement->execute();
	$users = $statement->fetchAll(PDO::FETCH_OBJ);

	if (isset($_POST['add'])) {
		
	}
?>

	<div class="container my-5">				
		<div class="row">
			<div class="col-md-4 border border-danger">
			<h5>View Accounts</h5>
				<ul class="list-unstyled">
					<?php foreach($users as $user): ?>
						<div class="my-3 d-flex justify-content-between" style="border-bottom: 2px solid black">
							<div>
								<div class="user_img"><img style="width: 50px" src="assets/images/<?php echo $user->image ?>" alt="Profile image"></div>
								<div class="user_info"><span><?php echo $user->name; ?></span>
							</div>
							<div>
								<!-- <span><a href="user_profile.php?id=<?php echo $user->id ?>" class="btn btn-primary btn-sm">Add Friend</a></div> -->
								<form method="post">
									<button class="btn btn-primary btn-sm" name='add'>Add Friend</button>
								</form>
							</div>
						</div>
					<?php endforeach; ?>
				</ul> 
			</div>
			<div class="col-md-8 border border-danger"></div>
		</div>
	</div>
<!-- <?php require_once("layout/footer.php"); ?> -->