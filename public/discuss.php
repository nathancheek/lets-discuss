<?php
	include 'sqlconnect.php';
	include 'discuss_functions.php';
	$discussion_title_decode=rawurldecode($_GET['discussion']);
	$discussion_title_decode_safe=htmlentities($discussion_title_decode);
	$discussion_title_encode=rawurlencode($discussion_title_decode);
	//query discussion settings
	$settings_row=get_discussion_settings($discussion_title_decode);
	$query_id=$settings_row[0];
	$query_discussion_id=$settings_row[1];
	$query_discussion_pub_id=$settings_row[2];
	$query_discussion_name=htmlentities($settings_row[3]);
	$query_discussion_name_inscr=$settings_row[3];
	$query_admin_password=$settings_row[4];
	$query_discussion_prompt=htmlentities($settings_row[5]);
	$query_create_time=$settings_row[6];
	$query_create_ip_addr=$settings_row[7];
	$query_settings_name_req=$settings_row[8];
	$query_settings_close_time=$settings_row[9];
	$query_settings_access_password=$settings_row[10];
	$query_settings_google_req=$settings_row[11];
	$query_settings_google_domain=$settings_row[12];
	$query_settings_char_length=htmlentities($settings_row[13]);
	$cookie_admin_name="admin_$query_discussion_id";
	$cookie_admin_id=$_COOKIE[$cookie_admin_name];
	$cookie_pub_name="pub_$query_discussion_pub_id";
	$cookie_pub_id=$_COOKIE[$cookie_pub_name];
	if (password_verify($_POST['admin_auth'],$query_admin_password)) { //if admin logged in set cookie and reload
	setcookie($cookie_admin_name,"1","0","/","discuss.nathancheek.com");
	echo "<script>window.location='';</script>";
	}
	if (password_verify($_POST['auth'],$query_settings_access_password)) { //if user entered correct discussion password
	setcookie($cookie_pub_name,"1","0","/","discuss.nathancheek.com");
	}
	//if setting change is posted
	if (isset($_POST['setting_save']) && $cookie_admin_id=="1") {
		$send_prompt=($_POST['setting_prompt']);
		$send_identity=($_POST['setting_identity']);
		$send_char_limit=($_POST['setting_char_limit']);
		if ($_POST['setting_access_password']!=="pwdnoworky") {
		write_access_password($query_discussion_name_inscr,$_POST['setting_access_password']);
		}
		write_prompt($query_discussion_name_inscr,$send_prompt);
		write_name_req($query_discussion_name_inscr,$send_identity);
		write_char_limit($query_discussion_name_inscr,$send_char_limit);
		echo "<script>window.location='';</script>";
	}
	if (isset($_POST['delete_discussion']) && $cookie_admin_id=="1") { //delete discussion
		write_del_discussion($query_discussion_name_inscr);
		$status_discussion_del=1;
	}
	$description="";
	$author="";
	$title="Discuss '$query_discussion_name'";
	$navbarTitle="Discuss";
	include 'header.php';
	include 'header2one.php';
	include 'header3.php';
	if (isset($_GET['discussion'])) { //only load if discussion title is requested
		if (discussion_exist($discussion_title_encode) == false && $status_discussion_del==1) { //if discussion was just deleted
			echo "<div class='container'><div class='col-md-2'></div><div class='col-md-8'><div class='alert alert-success'>Discussion '<strong>$discussion_title_decode_safe</strong>' successfully deleted</div></div><div class='col-md-2'></div></div>";
		}elseif (discussion_exist($discussion_title_decode) == false) { //announce if the discussion doesn't exist
			echo "<div class='container'><div class='col-md-2'></div><div class='col-md-8'><div class='alert alert-danger'>Sorry, discussion '<strong>$discussion_title_decode_safe</strong>' does not exist</div></div><div class='col-md-2'></div></div>";
		} //discussion doesn't exist
		elseif (!$query_settings_access_password || $cookie_admin_id=="1" || $cookie_pub_id=="1" || password_verify($_POST['auth'],$query_settings_access_password) || password_verify($_GET['auth'],$query_settings_access_password)) { //load page if no access password or access password in post/get request
			if (isset($_POST['post_message'])) {
				if (isset($_POST['post_name']) && $query_settings_name_req == "0") {
					write_post($query_discussion_name, $query_settings_char_length, $_POST['post_message'],$_POST['post_name']);
				} else {
					write_post($query_discussion_name, $query_settings_char_length, $_POST['post_message']);
				}
			}
?>
	<div class="container wrap-one-height discuss-window">
		<div class="row wrap-one-height">
		<div class="col-sm-4 sidebar wrap-one-height">
		<div style="text-align: center;"><h1>Discuss</h1><h2>'<?php echo $query_discussion_name;?>'</h2></div>
	<hr>
	<form class="form-vertical" name="post" action="" method="post">
		<fieldset>
            <div class="form-group">
            <?php if ($query_settings_name_req=="0") { //if name is required
            	echo "<input id='post_name' name='post_name' type='text' class='form-control input-md' maxlength='50' placeholder='Your name*' required='' autofocus>";
            	echo "<script>if (!('autofocus' in document.createElement('input'))) { document.getElementById('discuss').focus() }</script>";
            	} elseif ($query_settings_name_req=="1") {
            	echo "<h4 class=\"well\">Google requirement code goes here</h4>";
            	}
            ?>
            </div>
            <div class="form-group">
              <input name="discussion" type="hidden" value="<?php echo $discussion_title_decode_safe?>" /><textarea id="post_message" rows="5" name="post_message" class="form-control" placeholder="Your message*" required="" maxlength="<?php if ($query_settings_char_length) {echo $query_settings_char_length;}else {echo "500";}?>"></textarea>
         	</div>
        	<div class="register">
            	<div class="form-group">
                 	<label class="col-md-4 control-label" for="post_send"></label>
                 		<div class="col-md-4">
                 			<button id="post_send" name="post_send" type="submit" class="btn btn-primary">Submit</button>
                    	</div>
                </div>
            </div>
        </fieldset>
    </form>
    <hr>
<?php
				if ($cookie_admin_id=="1" || password_verify($_POST['admin_auth'],$query_admin_password)) { //check if browser has cookie to admin the discussion
				?>
					<h3 style="text-align: center;">Change discussion settings</h3>
					<form class="form-horizontal" name="settings_change" style="margin-left: 15px; margin-right: 15px;" action="" method="post">
						<fieldset>

							<!-- Textarea -->
							<div class="form-group">                     
								<textarea class="form-control" id="setting_prompt" name="setting_prompt" placeholder="Discussion Prompt" rows="3"><?php echo html_entity_decode($query_discussion_prompt); ?></textarea>
							</div>

							<!-- Appended Input-->
							<div class="form-group">
							<label class="col-md-5 control-label" for="setting_char_limit">Character limit</label>
							<div class="col-md-7">
							<input id="setting_char_limit" name="setting_char_limit" class="form-control" placeholder="Up to 500" type="text" value="<?php echo $query_settings_char_length; ?>">
							</div>
							</div>
							<!-- Password Input -->
							<div class="form-group">
							<label class="col-md-5 control-label" for="setting_access_password">Access code</label>
							<div class="col-md-7">
							<input id="setting_access_password" name="setting_access_password" type="password" class="form-control input-md" value="<?php if ($query_settings_access_password) { echo "pwdnoworky"; } ?>">
							</div>
							</div>
							<!-- Multiple Radios -->
							<div class="form-group">
							<label class="col-md-5 control-label" for="radios">Identity</label>
							<div class="col-md-7">
							<div class="radio">
							<label for="setting_identity_0">
							<input type="radio" name="setting_identity" id="setting_identity_0" value="0" <?php if ($query_settings_name_req==0) { echo "checked=\"checked\""; } ?>>
							Name
							</label>
							</div>
							<div class="radio">
							<label for="setting_identity_1">
							<input type="radio" name="setting_identity" id="setting_identity_1" value="1" <?php if ($query_settings_name_req==1) { echo "checked=\"checked\""; } ?>>
							Google authentication
							</label>
							</div>
							<div class="radio">
							<label for="setting_identity_2">
							<input type="radio" name="setting_identity" id="setting_identity_2" value="2" <?php if ($query_settings_name_req==2) { echo "checked=\"checked\""; } ?>>
							Anonymous
							</label>
							</div>
							</div>
							</div>

							<!-- Button -->
							<div class="form-group">
								<button id="setting_save" name="setting_save" class="btn btn-success pull-left">Save Changes</button>
							</div>

						</fieldset>
					</form>
					<button class="btn btn-danger pull-left" data-toggle="modal" data-target="#alertDelete">Delete Discussion</button>
					<div class="modal fade" id="alertDelete">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h2 class="modal-title">Are you sure?</h2>
								</div>
								<div class="modal-body">
								<p><h4>If you delete this discussion, it is gone forever!</h4></p>
								</div>
								<div class="modal-footer">
								<form name="delete_discussion" action="" method="post">
								<button class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button id="delete_discussion" name="delete_discussion" class="btn btn-danger">Delete</button>
								</form>
								</div>
							</div>
						</div>
					</div>

				<?php
				} //cookie check
				else {
				?>
					<form name="admin_auth" class="push-bottom" action="" method="post">
						<div class="form-inline">
							<input id="admin_auth" name="admin_auth" type="password" class="form-control" style="max-width:170px;" placeholder="Admin Password" required="">
							<button id="admin_auth_send" type="submit" class="btn btn-default">Enter</button>
						</div>
					</form>
				<?php
				}
				?>
		</div>
		<div class="col-sm-8 message-column">
		<div class="message-header">
		<div class="message-border-top">
		</div>
		</div>
		<div class="message-content">
		<?php if ($query_discussion_prompt) {?>
		<div class="panel panel-info discuss-panel">
		<h4><?php echo nl2br($query_discussion_prompt) ?></h4>
		</div>
		<?php
		}
		?>
		<div class="message-bubbles">
		<?php
		$msg_result = get_posts($query_discussion_name);
		$isOdd=true;
		while ($row=mysqli_fetch_assoc($msg_result)) {
		$msg_name1 = $row['name'];
		if ($msg_name1 && $query_settings_name_req !="2") {
			$msg_name = "$msg_name1 - ";
		}
		$msg_time = $row['time'];
		$msg_content = nl2br($row['message']);
		if ($isOdd) {
			$pull="left";
		} else {
			$pull="right";
		}
		$isOdd = !$isOdd;
		echo "<div class='bubble-" . $pull . "'>";
		echo "<h5>" . $msg_name . date('m/d/y - h:m:s A', $msg_time) . "</h5>";
		echo "<hr>";
		echo "<p>";
		echo "$msg_content";
		echo "</p>";
		echo "</div>";
		}
		?>
		</div>
		<?php
		/*echo "<p>id $query_id</p>";
		echo "<p>discussion id $query_discussion_id</p>";
		echo "<p>discussion pub id $query_discussion_pub_id<p>";
		echo "<p>discussion name $query_discussion_name</p>";
		echo "<p>discussion admin password $query_admin_password</p>";
		echo "<p>discussion prompt $query_discussion_prompt</p>";
		echo "<p>create time $query_create_time</p>";
		echo "<p>create IP address $query_create_ip_addr</p>";
		echo "<p>name req? $query_settings_name_req</p>";
		echo "<p>close time $query_settings_close_time</p>";
		echo "<p>access password $query_settings_access_password</p>";
		echo "<p>google req? $query_settings_google_req</p>";
		echo "<p>google domain $query_settings_google_domain</p>";
		echo "<p>char length $query_settings_char_length</p>";
		echo "<p></p>";
		echo "<p>$cookie_admin_name - $cookie_admin_id</p>";
		*/?>
		</div>
		<div class="message-border-bottom">
		</div>
		<div class="message-footer">
		</div>
		</div>
		</div>
	</div>
<?php
			}//load page
			elseif ($query_settings_access_password) {//require password if access password set
?>
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			<div class="container alert">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3>Password required to view this discussion</h3>
				</div>
				<div class="panel-body">
					<form name="auth" action="" method="post">
						<div class="form-inline">
							<input id="auth" name="auth" type="password" class="form-control" placeholder="Password" required="">
							<button id="auth_send" type="submit" class="btn btn-default">Enter</button>
						</div>
					</form>
				</div>
			</div>
			</div>
		</div>
		<div class="col-md-2">
		</div>
<?php
			} //require password
	} //is discussion title requested
	else { //redirect to home page
		echo "<script>window.location='/';</script>";
	} //redirect to home page
	?>
	</div>
	<?php
	include 'footer.php';
?>
