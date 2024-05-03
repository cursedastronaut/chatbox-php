<?php
	include_once("config.php");

	define("ERR_NO_MESSAGE",		"no_msg");
	define("ERR_NO_USERNAME",		"no_usr");
	define("ERR_INVALID_USERNAME",	"invalid_username");


	class Chat {
		function executeSQL($sql) {
			$db = mysql_connect(DB_URL, DB_User, DB_Password) or die("Error 500 - Unable to reach internal database. (Free's DB may be down?)");
			mysql_select_db(DB_Name, $db);

			$result = mysql_query($sql) or die('SQL Error:<br>'.mysql_error().'<br>'.$sql.'<br>');
			mysql_close();
			return $result;
		}

		function getMessages() {
			$this->deleteOldMessages();
			$sql = "SELECT idMessage, contentMessage, dateMessage, timeMessage, usernameMessage FROM ChatMessages ORDER BY idMessage";
			
			$result = $this->executeSQL($sql);

			if ($result->num_rows < 0)
				return -1;
			return $result;
		}

		function transformToEntities($str, $deleteNewLine) {
			$result = "";
			for ($i = 0; $i < strlen($str); $i++) {
				if ($str[$i] == '\n') {
					if (false) {	$result .= "";	}
					else				{	$result .= "<br>"; }
				} else {
					$result .= "&#" . ord($str[$i]) . ";";
				}
			}
			return $result;
		}

		//Removes messages that are not part of the 100 latest messages
		function deleteOldMessages() {
			$sql = ""
			. "DELETE FROM ChatMessages "
			. "WHERE idMessage NOT IN ("
			. "	SELECT idMessage"
			. "	FROM ("
			. "		SELECT idMessage"
			. "		FROM ChatMessages"
			. "		ORDER BY idMessage DESC"
			. "		LIMIT 100"
			. "	) AS latest_messages"
			. ");";

			$result = $this->executeSQL($sql);
		}

		function addMessage($content, $username) {
			$content	= $this->transformToEntities($content, false);
			$username	= $this->transformToEntities($username, true);

			$sql = "" 
			. "INSERT INTO ChatMessages ("
			. "	idMessage, contentMessage, dateMessage, timeMessage, usernameMessage"
			. ") SELECT COALESCE(MAX(idMessage), 0) + 1, '". $content . "', CURRENT_DATE(), CURRENT_TIME(),"
			. "'" . $username . "' " 
			. "FROM ChatMessages;";

			$result = $this->executeSQL($sql);
		}
		
		function isUsernameValid($username) {
			//I hate PHP4
			$forbiddenUsernames = array("Error", "Admin");
			foreach ($forbiddenUsernames as $string) {
				if ($username === $string) {
					return false;
				}
			}
			return true;
		}

		function resetDB() {
			$sql = "DELETE FROM ChatMessages WHERE idMessage > 1";
			$result = $this->executeSQL($sql);
		}
	}

?>