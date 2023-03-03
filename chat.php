<?php
session_start();

if (isset($_SESSION['username'])) {
	# database connection file
	include 'app/db.conn.php';
	include 'app/helpers/user.php';
	include 'app/helpers/chat.php';
	include 'app/helpers/opened.php';
	include 'app/helpers/conversations.php';
	include 'app/helpers/timeAgo.php';
	include 'app/helpers/last_chat.php';

	if (!isset($_GET['user'])) {
		header("Location: home.php");
		exit;
	}
	# Getting User data data
	$user = getUser($_SESSION['username'], $conn);

	# Getting User Conversation
	$conversations = getConversation($user['user_id'], $conn);

	# Getting User data data
	$chatWith = getUser($_GET['user'], $conn);

	if (empty($chatWith)) {
		header("Location: home.php");
		exit;
	}

	$chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);

	opened($chatWith['user_id'], $conn, $chats);
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Chat App</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" href="img/logo.png">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>

	<body>
		<header>
			<nav class="navbar fixed-right navbar-light bg-light">
				<div class="container-fluid">
					<div class="w-20">
						<button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><span class="navbar-toggler-icon"></span></button>
						<img src="img/logo.png" class="w-10">
						<span class="w-10">Chats</span>
					</div>
					<a class="navbar-brand img-5" href="#">
						<img src="uploads/<?= $user['p_p'] ?>" class="w-100 rounded-circle">
					</a>
				</div>
			</nav>
		</header>
		<div class="shadow p-4 rounded">
			<a href="home.php" class="fs-5 link-dark">&#8592;</a>

			<div class="d-flex align-items-center">
				<img src="uploads/<?= $chatWith['p_p'] ?>" class="w-10 rounded-circle">

				<h3 class="display-4 fs-sm m-2">
					<?= $chatWith['name'] ?> <br>
					<div class="d-flex
               	              align-items-center" title="online">
						<?php
						if (last_seen($chatWith['last_seen']) == "Active") {
						?>
							<div class="online"></div>
							<small class="d-block p-1">Online</small>
						<?php } else { ?>
							<small class="d-block p-1">
								Last seen:
								<?= last_seen($chatWith['last_seen']) ?>
							</small>
						<?php } ?>
					</div>
				</h3>
			</div>

			<div class="shadow p-4 rounded
    	               d-flex flex-column
    	               mt-2 chat-box" id="chatBox">
				<?php
				if (!empty($chats)) {
					foreach ($chats as $chat) {
						if ($chat['from_id'] == $_SESSION['user_id']) { ?>
							<p class="rtext align-self-end
						        border rounded p-2 mb-1">
								<?= $chat['message'] ?>
								<small class="d-block">
									<?= $chat['created_at'] ?>
								</small>
							</p>
						<?php } else { ?>
							<p class="ltext border 
					         rounded p-2 mb-1">
								<?= $chat['message'] ?>
								<small class="d-block">
									<?= $chat['created_at'] ?>
								</small>
							</p>
					<?php }
					}
				} else { ?>
					<div class="alert alert-info 
    				            text-center">
						<i class="fa fa-comments d-block fs-big"></i>
						No messages yet, Start the conversation
					</div>
				<?php } ?>
			</div>
			<div class="input-group mb-3">
				<textarea cols="3" id="message" class="form-control"></textarea>
				<button class="btn btn-primary" id="sendBtn">
					<i class="fa fa-paper-plane"></i>
				</button>
			</div>

		</div>
		<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
			<div class="offcanvas-header">
				<h3>Chats</h3>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="input-group mb-3 p-2">
				<input type="text" placeholder="Search..." id="searchText" class="form-control">
				<button class="btn btn-primary" id="serachBtn">
					<i class="fa fa-search"></i>
				</button>
			</div>
			<ul id="chatList" class="list-group mvh-50 overflow-auto">
				<?php if (!empty($conversations)) { ?>
					<?php

					foreach ($conversations as $conversation) { ?>
						<li class="list-group-item">
							<a href="chat.php?user=<?= $conversation['username'] ?>" class="d-flex
	    				          justify-content-between
	    				          align-items-center p-2">
								<div class="d-flex
	    					            align-items-center">
									<img src="uploads/<?= $conversation['p_p'] ?>" class="w-10 rounded-circle">
									<h3 class="fs-xs m-2">
										<?= $conversation['name'] ?><br>
										<small>
											<?php
											echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn);
											?>
										</small>
									</h3>
								</div>
								<?php if (last_seen($conversation['last_seen']) == "Active") { ?>
									<div title="online">
										<div class="online"></div>
									</div>
								<?php } ?>
							</a>
						</li>
					<?php } ?>
				<?php } else { ?>
					<div class="alert alert-info 
    				            text-center">
						<i class="fa fa-comments d-block fs-big"></i>
						No messages yet, Start the conversation
					</div>
				<?php } ?>
			</ul>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>
			var scrollDown = function() {
				let chatBox = document.getElementById('chatBox');
				chatBox.scrollTop = chatBox.scrollHeight;
			}

			scrollDown();

			$(document).ready(function() {

				$("#sendBtn").on('click', function() {
					message = $("#message").val();
					if (message == "") return;

					$.post("app/ajax/insert.php", {
							message: message,
							to_id: <?= $chatWith['user_id'] ?>
						},
						function(data, status) {
							$("#message").val("");
							$("#chatBox").append(data);
							scrollDown();
						});
				});

				/** 
				auto update last seen 
				for logged in user
				**/
				let lastSeenUpdate = function() {
					$.get("app/ajax/update_last_seen.php");
				}
				lastSeenUpdate();
				/** 
				auto update last seen 
				every 10 sec
				**/
				setInterval(lastSeenUpdate, 10000);



				// auto refresh / reload
				let fechData = function() {
					$.post("app/ajax/getMessage.php", {
							id_2: <?= $chatWith['user_id'] ?>
						},
						function(data, status) {
							$("#chatBox").append(data);
							if (data != "") scrollDown();
						});
				}

				fechData();
				/** 
				auto update last seen 
				every 0.5 sec
				**/
				setInterval(fechData, 500);

			});
		</script>
	</body>

	</html>
<?php
} else {
	header("Location: index.php");
	exit;
}
?>