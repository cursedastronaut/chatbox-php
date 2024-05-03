<head>
	<title>Discussions - Spacie</title>
	<link rel="stylesheet" href="res/css/main.css"/>
</head>
<body>	
	<!--Chatbox-->
	<div class='chat'>
		<?php
			include_once("chat.php");
			$chat = new Chat();

			$result = $chat->getMessages();
			while ($row =  mysql_fetch_assoc($result)) {
				echo "\t<div class='msg'>\n"
				. "\t\t<p class='msg-username'>"	. $row["usernameMessage"]							. "</p>\n"
				. "\t\t<p class='msg-content'>"		. $row["contentMessage"]							. "</p>\n"
				. "\t\t<p class='msg-date'>"		. $row["dateMessage"] . " ". $row["timeMessage"]	. "</p>\n"
				. "</div>"
				;
			}

			if (isset($_GET["error"])) {
				$errorMessage = "An unknown error has occured.";
				if			($_GET["error"] == ERR_NO_MESSAGE) {
					$errorMessage = "You forgot to provide a message.";
				} else if	($_GET["error"] == ERR_NO_USERNAME) {
					$errorMessage = "You forgot to provide a username.";
				} else if	($_GET["error"] == ERR_INVALID_USERNAME) {
					$errorMessage = "Invalid username.";
				}
				echo "\t<div class='msg'>\n"
				. "\t\t<p class='msg-username' style='color:red'>"	. "Error"		. "</p>\n"
				. "\t\t<p class='msg-content'>"						. $errorMessage	. "</p>\n"
				. "</div>"
				;
			}
		?>
	</div>
	
	<!--Chat form-->
	<form id="chatForm" action="submit.php" method="post">
		<textarea id="username"	name="username"	rows="1"	cols="15"	placeholder="Enter your username"	><?php echo $_GET["username"]; ?></textarea><br>
		<textarea id="message"	name="message"	rows="4"	cols="50"	placeholder="Enter your message"	></textarea><br>
		<button type="submit"	name="submit">
			<svg width="100%" height="100%">       
				<image xlink:href="res/svg/send.svg" width="100%" height="100%"/>    
			</svg>
		</button>
	</form>

	<!--Scripts-->
	<script>
		//Scroll maximum height in chatbox.
		var chatBox = document.getElementsByClassName("chat")[0];
		chatBox.scrollTop = chatBox.scrollHeight;
	</script>
</body>