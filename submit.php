<!--Errors/Sending message PHP-->
<?php
	include_once("chat.php");
	$chat = new Chat();
	$URL="index.php";
	
	if(isset($_POST['message']) && isset($_POST['username']) && $_POST['message'] != "" && $_POST['username'] != "") {
		if ($chat->isUsernameValid($username)) {
			$chat->addMessage($_POST['message'], $_POST['username']);
			$URL .= "?username=" . $_POST['username'];
		} else {
			$URL .= "?error=" . ERR_INVALID_USERNAME;
		}
	} else if (isset($_POST['message']) && $_POST['message'] == "") {
		$URL .= "?error=" . ERR_NO_MESSAGE . "&username=" . $_POST['username'];
		
	} else if (isset($_POST['username']) && $_POST['username'] == "") {
		$URL .= "?error=" . ERR_NO_MESSAGE;
	}

	echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
	echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
?>