<?php 
  session_start();
  require_once("config/db.php");

  if (!isset($_SESSION['users'])) {
    header("location:sign-in.php");
  }

	// Getting User Data Who is logged in 
	$userId = $_SESSION['users']->id;

	$statement = $db->prepare("SELECT * FROM users WHERE id = $userId");
	$statement->execute();
	$user = $statement->fetchObject();

	$sender_name = $user->name; //sender

	// Getting User Data On Which user Click 
	if (isset($_GET['user_name'])) {
		$get_userName = $_GET['user_name'];

		$statement = $db->prepare("SELECT * FROM users WHERE name = '$get_userName'");
		$statement->execute();
		$user = $statement->fetchObject();

		$receiver_name = $user->name; //receiver 
		$userProfile = $user->image;
	}
	global $receiver_name;
	// Send Message to DB
	if (isset($_POST['send_msg'])) {
		$message = $_POST['msg_content'];
		if ($message == '') {
			echo "
			<div class='alert alert-danger'>
				<strong>Message was unable to send</strong>
			</div>
			";
		} else {
			$statement = $db->prepare("INSERT INTO chats (message, sender, receiver) VALUES ('$message', '$sender_name', '$receiver_name')");
			$statement->execute();
		}
	}

	// Get Messgae
	$getMsg_statement = $db->prepare("SELECT * FROM chats WHERE (sender='$sender_name' AND receiver='$receiver_name') OR (receiver='$sender_name' AND sender='$receiver_name') ORDER BY 1 ASC");
	$getMsg_statement->execute();
	$messages = $getMsg_statement->fetchAll(PDO::FETCH_OBJ);
?>

 
      <?php require_once("template/header.php") ?>
      <?php require_once("template/navbar.php") ?>
      <?php require_once("template/sidebar.php") ?>

				<!-- Start of Create Chat -->
				<div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="requests">
							<div class="title">
								<h1>Start new chat</h1>
								<button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
							</div>
							<div class="content">
								<form>
									<div class="form-group">
										<label for="participant">Recipient:</label>
										<input type="text" class="form-control" id="participant" placeholder="Add recipient..." required>
										<div class="user" id="recipient">
											<img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
											<h5>Keith Morris</h5>
											<button class="btn"><i class="material-icons">close</i></button>
										</div>
									</div>
									<div class="form-group">
										<label for="topic">Topic:</label>
										<input type="text" class="form-control" id="topic" placeholder="What's the topic?" required>
									</div>
									<div class="form-group">
										<label for="message">Message:</label>
										<textarea class="text-control" id="message" placeholder="Send your welcome message...">Hmm, are you friendly?</textarea>
									</div>
									<button type="submit" class="btn button w-100">Start New Chat</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- End of Create Chat -->
				<div class="main">
					<div class="tab-content" id="nav-tabContent">
						<!-- Start of Babble -->
            
            <!-- Start of Chat -->
							<div class="chat" id="chat3">
								<div class="top">
									<div class="container">
										<div class="col-md-12 " >
											<div class="inside">
												<a href="#"><img class="avatar-md" src="assets/images/<?php echo $userProfile ?>" data-toggle="tooltip" data-placement="top"></a> 
												<div class="data">
													<h5><a href="#"><?php echo $receiver_name; ?></a></h5>
													<!-- <?php if ($user->status == 'Active Now') :?>
														<span>Active Now</span>
													<?php else : ?>
														<span>Offline Now</span>
													<?php endif; ?> -->
												</div>
	
												<button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>												
											</div>
										</div>
									</div>
								</div>
								<div class="content empty">
									<div class="container">
										<div class="col-md-12">
											<?php if ($_SERVER['QUERY_STRING'] == '') :?>
											<div class="no-messages request">
												<h5>No conversation yet</span></h5>
												<div class="options">
													<button class="btn button"><i class="material-icons">check</i></button>
													<button class="btn button"><i class="material-icons">close</i></button>
												</div>
											</div>
											<?php else : ?>
												<!-- Show Chat -->
												<?php foreach($messages as $message) :?>
													<?php	if ($sender_name == $message->sender AND $receiver_name == $message->receiver) : ?>
														<div class="message me">
															<div class="text-main">
																<div class="text-group me">
																	<div class="text me">
																		<p><?php echo $message->message; ?></p>
																	</div>
																</div>
																<div><?php echo $message->created_at ?></div>
															</div>
														</div>
													<?php  elseif ($sender_name == $message->receiver AND $receiver_name == $message->sender) : ?>
														<div class="message">
															<img class="avatar-md" src="assets/images/<?php echo $userProfile ?>" data-toggle="tooltip" data-placement="top"  alt="avatar">
															<div class="text-main">
																<div class="text-group">
																	<div class="text">
																		<p><?php echo $message->message; ?></p>
																	</div>
																</div>
																<div><?php echo $message->created_at ?></div>
															</div>
														</div>
													<?php endif; ?>	
												<?php endforeach; ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="col-md-12">
										<div class="bottom">
											<form class="position-relative w-100" method="post">
											<button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
												<textarea class="form-control" name="msg_content" placeholder="Send Messag..." rows="1" ></textarea>
												<button type="submit" class="btn send text-primary" name="send_msg" ><i class="material-icons">send</i></button>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Chat -->
						<!-- End of Babble -->			
					</div>
				</div>
			</div> <!-- Layout -->
  <?php require_once("template/footer.php"); ?>