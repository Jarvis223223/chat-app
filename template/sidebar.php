<?php
	// Show Accounts
	$userId = $_SESSION['users']->id;
	$statement = $db->prepare("SELECT * FROM users WHERE id != $userId ");
  $statement->execute();
  $users = $statement->fetchAll(PDO::FETCH_OBJ);

	// Add Friend
	if (isset($_POST['add_friend'])) {
		$sender_id = $_SESSION['users']->id;
		$receiver_id = $_POST['receiver'];
		$statement = $db->prepare("INSERT INTO request (sender_id, receiver_id) VALUES ($sender_id, $receiver_id)");
		$statement->execute();
	}

	// Request
	$reqStatement = $db->prepare("SELECT sender_id  FROM request WHERE receiver_id = $userId AND status = 'pending'");
	$reqStatement->execute();
	$request = $reqStatement->fetchAll(PDO::FETCH_OBJ);
	
	$senderIds = array_map( function($res) {
		return $res->sender_id;
	} ,$request);
	$ids = join("','",$senderIds); 
	$sql = $db->prepare("SELECT * FROM users WHERE id IN ('$ids')");
	$sql->execute();
	$requestFriends = $sql->fetchAll(PDO::FETCH_OBJ);
	
	// Confirm OR Delete
	if (isset($_POST['response'])) {
		$senderId = $_POST['sender_id'];
		$response = $_POST['response'];
		if ($response === 'accept') {
			$statement = $db->prepare("UPDATE request SET status = 'accept' WHERE sender_id = $senderId ");
			$friendStatement = $db->prepare("INSERT INTO friends (auth_id, friend_id) VALUES ($userId, $senderId), ($senderId, $userId); ");
			header('location:index.php');
		} else if ($response === 'reject') {
			$statement = $db->prepare("DELETE FROM request WHERE sender_id = $senderId");
			$friendStatement = $db->prepare("DELETE FROM friends");
		} else {
			die("Invalid");
		}
		$statement->execute();
		$friendStatement->execute();
	} 

	// Show Accept Friends
	$accStm = $db->prepare("SELECT friends.friend_id, users.name, users.image, users.status as user_status FROM friends INNER JOIN users ON friends.friend_id = users.id WHERE friends.auth_id = $userId");
	$accStm->execute();
	$friends = $accStm->fetchAll(PDO::FETCH_OBJ);

	$st = $db->prepare("SELECT status FROM request WHERE status = 'pending'");
	$st->execute();
	$re = $st->fetchAll(PDO::FETCH_OBJ);

?>
<!-- Start of Sidebar -->
<div class="sidebar " id="sidebar">
	<div class="container">
		<div class="col-md-12">
			<div class="tab-content">
				<!-- Start of Contacts -->
				<div class="tab-pane fade active show" id="members">
					<div class="search">
						<form class="form-inline position-relative" method='post'>
							<input type="search" class="form-control" id="people" placeholder="Search for people...">
							<button type="submit" class="btn btn-link loop"><i class="material-icons">search</i></button>
						</form>
					</div>
					<div class="contacts">
						<h1>Friends</h1> 
						<!-- Show Friend -->
						<?php foreach($friends as $friend) : ?>
						<div class="list-group">
							<a href="index.php?user_name=<?php echo $friend->name ?>" class="filterMembers all online contact"  >
								<img class="avatar-md" src="assets/images/<?php echo $friend->image ?>">
								<?php if ($friend->user_status == 'Active Now') :?>
									<div class="status">
										<i class="material-icons online text-success">fiber_manual_record</i>
									</div>
								<?php else : ?>
									<div class="status">
										<i class="material-icons online text-secondary">fiber_manual_record</i>
									</div>
								<?php endif; ?>
								<div class="data">
									<h5><?php echo $friend->name ?></h5>
									<p>Sofia, Bulgaria</p>
								</div>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<!-- End of Contacts -->
				<!-- Start of Discussions -->
				<div id="discussions" class="tab-pane fade ">
					<div class="search">
						<form class="form-inline position-relative">
							<input type="search" class="form-control" placeholder="Search for conversations...">
							<button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
						</form>
					</div>	
					<!-- ACCEPT FRIENDS -->
					<div class="discussions"> 
						<h1>Accept Friends</h1>	
							<?php foreach($requestFriends as $requestFriend) :?>
								<div class="list-group">
									<form method="post">
										<a href="" class="all unread single">
											<img class="avatar-md" src="assets/images/<?php echo $requestFriend->image; ?>" data-toggle="tooltip" data-placement="top"alt="avatar">
											<div class="data">
												<h5><?php echo $requestFriend->name ?></h5>
											</div>
												<form method="post">
													<input type="hidden" name='sender_id' value="<?php echo $requestFriend->id; ?>">
													<button name="response" value="accept" class="btn btn-primary mx-1" style="color: #fff;background-color: blue;border: 1px solid blue">Confirm</button>
													<button name="response" value="reject" class="btn btn-danger" style="color: #000;border: 1px solid gray">Delete</button>
												</form>
											</a>	
									</form>
								</div>
							<?php endforeach; ?>
 					</div>			
					<!-- ADD FRIENDS -->
					<div class="discussions">
						<h1>All Users</h1>
							<div class="list-group">
								<?php foreach($users as $user) :?>
								<a href="" class="all unread single " >
									<img class="avatar-md" src="assets/images/<?php echo $user->image; ?>" data-toggle="tooltip" data-placement="top"alt="avatar">
									<div class="data">
										<h5><?php echo $user->name; ?></h5>		
										<p class='text-secondary'>Sofia, Bulgaria</p>								
									</div>
									<form method="post">
										<input type="hidden" name="receiver" value='<?php echo $user->id; ?>'>
										<button name="add_friend" class="btn btn-primary  mx-1" style="color: #fff;background-color: blue;border: 1px solid blue">Add</button>
									</form>
								</a>	
								<?php endforeach; ?>													
							</div>						
					</div>
				</div>
				<!-- End of Discussions -->
				<!-- Start of Settings -->
				<div class="tab-pane fade" id="settings">			
					<div class="settings">
						<div class="profile">
							<img class="avatar-xl" src="assets/images/<?php echo $_SESSION['users']->image ?>" alt="avatar">
							<h1><a href="#"><?php echo $_SESSION['users']->name ?></a></h1>
							<span>Helena, Montana</span>
							<div class="stats">
								<div class="item">
									<h2>122</h2>
									<h3>Fellas</h3>
								</div>
								<div class="item">
									<h2>305</h2>
									<h3>Chats</h3>
								</div>
								<div class="item">
									<h2>1538</h2>
									<h3>Posts</h3>
								</div>
							</div>
						</div>
						<div class="categories" id="accordionSettings">
							<h1>Settings</h1>
							<!-- Start of My Account -->
							<div class="category">
								<a href="#" class="title collapsed" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									<i class="material-icons md-30 online">person_outline</i>
									<div class="data">
										<h5>My Account</h5>
										<p>Update your profile details</p>
									</div>
									<i class="material-icons">keyboard_arrow_right</i>
								</a>
								<div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionSettings">
									<div class="content">
										<div class="upload">
											<div class="data">
												<img class="avatar-xl" src="assets/images/<?php echo $_SESSION['users']->image ?>" alt="image">
												<label>
													<input type="file">
													<span class="btn button">Upload avatar</span>
												</label>
											</div>
											<p>For best results, use an image at least 256px by 256px in either .jpg or .png format!</p>
										</div>
										<form>
											<div class="parent">
												<div class="field">
													<label for="name">Name <span>*</span></label>
													<input type="text" class="form-control" id="name" placeholder="First name" value="<?php echo $_SESSION['users']->name ?>" required>
												</div>
											</div>
											<div class="field">
												<label for="email">Email <span>*</span></label>
												<input type="email" class="form-control" id="email" placeholder="Enter your email address" value="<?php echo $_SESSION['users']->email ?>" required>
											</div>
											<!-- <div class="field">
												<label for="password">Password</label>
												<input type="password" class="form-control" id="password" placeholder="Enter a new password" value="<?php echo $_SESSION['users']->password ?>" required>
											</div> -->
											<button class="btn btn-link w-100">Delete Account</button>
											<button type="submit" class="btn button w-100">Apply</button>
										</form>
									</div>
								</div>
							</div>
							<!-- End of My Account -->
							<!-- Start of Logout -->
							<div class="category">
								<a href="sign-in.php" class="title collapsed">
									<i class="material-icons md-30 online">power_settings_new</i>
									<div class="data">
										<h5>Power Off</h5>
										<p>Log out of your account</p>
									</div>
									<i class="material-icons">keyboard_arrow_right</i>
								</a>
							</div>
							<!-- End of Logout -->
						</div>
					</div>
				</div>
				<!-- End of Settings -->
			</div>
		</div>
	</div>
</div>
<!-- End of Sidebar -->