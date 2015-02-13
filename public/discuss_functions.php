<?php
	function discussion_id($query_id) {
		require 'sqlconnect.php';
		$chars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		for($i=0;$i<10;$i++) {
			$random .=$chars[rand(0,strlen($chars)-1)];
		}
		//check if it already exists and if so gen another one
		$exists=true;
		while($exists==true) {
			$query="SELECT * FROM discussion_topics WHERE $query_id = '$random'";
			$result=mysqli_query($sqlconnect,$query);
			$row=mysqli_fetch_array($result);
			if($row !== NULL) {
				$random="";
				for($i=0;$i<10;$i++) {
					$random .=$chars[rand(0,strlen($chars)-1)];
				}
			} else {
				$exists=false;
				return $random;
			}
		}
	}
	function discussion_exist($discuss_inscr) {
		require 'sqlconnect.php';
		$discuss=mysqli_escape_string($sqlconnect,$discuss_inscr);
		$query="SELECT * FROM discussion_topics WHERE discussion_name = '$discuss'";
		$result=mysqli_query($sqlconnect,$query);
		$row=mysqli_fetch_array($result);
		if($row !== NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	function discussion_create($discussion_id_inscr,$discussion_pub_id_inscr,$discussion_name_inscr,$admin_password_inscr,$discussion_prompt_inscr) {
		$discussion_id=mysqli_escape_string($sqlconnect,$discussion_id_inscr);
		$discussion_pub_id=mysqli_escape_string($sqlconnect,$discussion_pub_id_inscr);
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$admin_password=mysqli_escape_string($sqlconnect,$admin_password_inscr);
		$discussion_id=mysqli_escape_string($sqlconnect,$discussion_id_inscr);
		$create_time=time();
		$query="INSERT INTO discussion_topics (discussion_id, discussion_pub_id, discussion_name, admin_password, discussion_prompt, setting_name_req, create_time) VALUES ('$discussion_id', '$discussion_pub_id', '$discuss', '$password_hash', '$prompt', '1', '$create_time')";
		mysqli_query($sqlconnect,$query);
	}
	
	function get_discussion_settings($discussion_name_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$query="SELECT * FROM discussion_topics WHERE discussion_name = '$discussion_name'";
		$result=mysqli_query($sqlconnect,$query);
		$row=mysqli_fetch_row($result);
		return $row;
	}
	/**function check_discussion_id($discuss_inscr,$discussion_id_cookie_inscr) {
		require 'sqlconnect.php';
		$discuss=mysqli_escape_string($sqlconnect,$discuss_inscr);
		$discussion_id_cookie=mysqli_escape_string($sqlconnect,$discussion_id_cookie_inscr);
		$query="SELECT discussion_id FROM discussion_topics WHERE discussion_name = '$discuss'";
		$result=mysqli_query($sqlconnect,$query);
		$row=mysqli_fetch_array($result);
		$discussion_id=$row[0];
		if ($discussion_id==$discussion_id_cookie) {
			return true;
		} else {
			return false;
		}
	}**/
	function write_prompt($discussion_name_inscr,$prompt_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$prompt=mysqli_escape_string($sqlconnect,substr($prompt_inscr, 0, 1000));
		$query="UPDATE discussion_topics SET discussion_prompt='$prompt' WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
	}
	function write_name_req($discussion_name_inscr,$value_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		if ($value_inscr==2) {
			$value=2;
		} elseif ($value_inscr==1) {
			$value=1;
		} else {
			$value=0;
		}
		$query="UPDATE discussion_topics SET setting_name_req='$value' WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
	}
	function write_char_limit($discussion_name_inscr,$char_length_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$char_length_scr=mysqli_escape_string($sqlconnect,$char_length_inscr);
		if (!$char_length_scr) {
		$query="UPDATE discussion_topics SET setting_char_length=NULL WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
		return 0;
		}
		if ($char_length_scr<"500" && $char_length_scr>"0") { $char_length=$char_length_scr; }
		else { $char_length="500"; }
		$query="UPDATE discussion_topics SET setting_char_length='$char_length' WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
	}
	function write_close_time($discussion_name_inscr, $close_time_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$close_time=mysqli_escape_string($sqlconnect,$close_time_inscr);
	}
	function write_access_password($discussion_name_inscr, $access_password_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$access_password=mysqli_escape_string($sqlconnect,password_hash($access_password_inscr, PASSWORD_BCRYPT));
		if ($access_password_inscr){
		$query="UPDATE discussion_topics SET setting_access_password='$access_password' WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
		$random_id=discussion_id("discussion_pub_id");
		$query="UPDATE discussion_topics SET discussion_pub_id='$random_id' WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
		}
		else {
		$query="UPDATE discussion_topics SET setting_access_password=NULL WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
		}
	}
	function write_google_domain($discussion_name_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
	}
	function write_del_discussion($discussion_name_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$query="DELETE FROM discussion_topics WHERE discussion_name='$discussion_name'";
		mysqli_query($sqlconnect,$query);
		$query="DELETE FROM discussions WHERE discussion_name='$discussion_name'";
	}
	function write_post($discussion_name_inscr, $discussion_char_length_inscr, $discussion_msg_inscr, $discussion_user_name_inscr, $discussion_email_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		if ($discussion_char_length_inscr) {
		$discussion_char_length=mysqli_escape_string($sqlconnect,$discussion_char_length_inscr);
		}else {
		$discussion_char_length="500";
		}
		$discussion_msg=mysqli_escape_string($sqlconnect,$discussion_msg_inscr);
		$discussion_user_name=mysqli_escape_string($sqlconnect,$discussion_user_name_inscr);
		$discussion_email=mysqli_escape_string($sqlconnect,$discussion_email_inscr);
		$discussion_msg=substr($discussion_msg,0,$discussion_char_length);
		$time=time();
		$query="INSERT INTO discussions (discussion_name, time, name, email, message) VALUES ('$discussion_name', '$time', '$discussion_user_name', '$discussion_email', '$discussion_msg')";
		mysqli_query($sqlconnect,$query);
	}
	function get_posts($discussion_name_inscr) {
		require 'sqlconnect.php';
		$discussion_name=mysqli_escape_string($sqlconnect,$discussion_name_inscr);
		$query="SELECT * FROM discussions WHERE discussion_name='$discussion_name' ORDER BY time DESC";
		$result=mysqli_query($sqlconnect,$query);
		return $result;
	}
?>
