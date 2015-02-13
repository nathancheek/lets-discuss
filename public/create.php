<?php
    include 'sqlconnect.php';
	include 'discuss_functions.php';
	//create a random discussion id (placed in discuss_functions.php)
	//check if discussion name already exists (placed in discuss_functions.php)
	//main page
	if(!empty($_POST)) {
		$discuss_inscr=substr($_POST['discuss'], 0, 500);
		$discuss=htmlspecialchars($discuss_inscr);
		$discuss_db=mysqli_escape_string($sqlconnect,$discuss_inscr);
		$discuss_url=rawurlencode($discuss_inscr);
		$password=$_POST['1234'];
		$prompt_inscr=substr($_POST['prompt'], 0, 1000);
		$prompt=htmlspecialchars($prompt_inscr);
		$prompt_db=mysqli_escape_string($sqlconnect,$prompt_inscr);
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$discussion_id=discussion_id(discussion_id);
		$discussion_pub_id=discussion_id("discussion_pub_id");
		$cookie_name="admin_$discussion_id";
		setcookie($cookie_name,"1","0","/","discuss.nathancheek.com");
		include 'header.php';
		include 'header2.php';
		include 'header3.php';
		if (discussion_exist($discuss_url) == "true") {
			?>
	<div class='announce'><div class='col-md-2'></div><div class='col-md-8'><div class='alert alert-danger'><strong>Error</strong> - This discussion name is already in use. Please choose a different name.</div></div><div class='col-md-2'></div></div>
      <div class="col-md-4">
      </div>
      <div class="col-md-4">
        <div class="panel panel-info create-panel">
          <div class="panel-heading">
            <div class="panel-title">
              <h3>Create a discussion room</h3>
            </div>
          </div>
          <div class="panel-body">
            <form class="form-vertical" name="create" action="/create.php" method="post">
              <fieldset>
                <div class="form-group">
                    <input id="discuss" name="discuss" type="text" class="form-control input-md" placeholder="Discussion Name*" required="" autofocus>
                    <script>if (!("autofocus" in document.createElement("input"))) { document.getElementById("discuss").focus() }</script>
                </div>
                <div class="form-group">
                  <input id="1234" name="1234" type="password" class="form-control input-md" placeholder="Admin Password* (use a unique password)" value="<?php echo $password?>" required="">
                </div>
                <div class="form-group">
                  <textarea id="prompt" rows="3" name="prompt" class="form-control" placeholder="Discussion Prompt" rows="5"><?php echo $prompt?></textarea>
                </div>
                <div class="register">
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="contact-submit"></label>
                      <div class="col-md-4">
                        <button id="discuss-create" name="discuss-create" type="submit" class="btn btn-primary">Register</button>
                      </div>
                  </div>
                </div>
              </fieldset>
              </form>
            </div>
          </div>
        </div>
			<?php
		} else {
			echo "<div class='announce'><div class='col-md-2'></div><div class='col-md-8'><div class='alert alert-info'><h3>Creating \"<strong>".$discuss."</strong>\"</h3>";
                	if(isset($sqlerror)) {
                	      echo "<h2>Error 503 - Database error</h2><p>".mysqli_connect_error()."</p><p>Please contact website administrator</p></div></div><div class='col-md-2'></div></div>";
              	  } else {
			$password_hash=password_hash($password, PASSWORD_BCRYPT);
			echo "<h4>Discussion ID: ".$discussion_id."</h4></div></div><div class='col-md-2'></div></div>";
			if (!empty($_POST['prompt'])) {
				$query="INSERT INTO discussion_topics (discussion_id, discussion_pub_id, discussion_name, admin_password, discussion_prompt, create_ip_addr , setting_name_req) VALUES ('$discussion_id', '$discussion_pub_id', '$discuss_db', '$password_hash', '$prompt_db', '$ip_address' , '0')";
				mysqli_query($sqlconnect,$query);
			} else {
				$query="INSERT INTO discussion_topics (discussion_id, discussion_pub_id, discussion_name, admin_password, create_ip_addr, setting_name_req) VALUES ('$discussion_id', '$discussion_pub_id', '$discuss_db', '$password_hash', '$ip_address', '0')";
				mysqli_query($sqlconnect,$query);
			}
			echo "<script>window.location='discuss.php?discussion=$discuss_url';</script>";
		}
		}
	//redirect to home page
	} else {
		echo "<script>window.location='/';</script>";
	}
	include 'footer.php';
?>
