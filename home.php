<?php
session_start();

if (isset($_SESSION['username'])) {
	# database connection file

	include 'app/db.conn.php';
	include 'app/helpers/user.php';
	include 'app/helpers/conversations.php';
	include 'app/helpers/timeAgo.php';
	include 'app/helpers/last_chat.php';




	# Getting User data data
	$user = getUser($_SESSION['username'], $conn);

	# Getting User Conversation
	$conversations = getConversation($user['user_id'], $conn);

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Chat App - Home</title>
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
					<div class="dropdown img-5">
						<a class="navbar-brand img-5 dropdown-toggle"href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="uploads/<?= $user['p_p'] ?>" class="w-100 rounded-circle">
					</a>

						<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<li><a href="logout.php" class="btn btn-dark">Logout</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>
		<div class="p-2 w-400
                rounded shadow 
				margin-auto">
			<div>
				<div class="d-flex
    		            mb-3 p-3 bg-light
			            justify-content-between
			            align-items-center">
				</div>

				<div class="input-group mb-3">
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
		</div>
		<div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
			<div class="offcanvas-header">
				<h3>Chats</h3>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
			$(document).ready(function() {

				// Search
				$("#searchText").on("input", function() {
					var searchText = $(this).val();
					if (searchText == "") return;
					$.post('app/ajax/search.php', {
							key: searchText
						},
						function(data, status) {
							$("#chatList").html(data);
						});
				});

				// Search using the button
				$("#serachBtn").on("click", function() {
					var searchText = $("#searchText").val();
					if (searchText == "") return;
					$.post('app/ajax/search.php', {
							key: searchText
						},
						function(data, status) {
							$("#chatList").html(data);
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