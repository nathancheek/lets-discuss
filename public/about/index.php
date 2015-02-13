<?php
    $description="";
    $author="";
    $title="About this site";
    $navbarTitle="about";
    include '../header.php';
    //insert custom css here
    echo "<link href=\"../../jumbotron.css\" rel=\"stylesheet\">";
    include '../header2.php';
    include '../header3.php';
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
      <div class="col-md-8">
        <h1 class="title">About this website</h1>
        <p>This site is under development by Nathan Cheek.  You can find out more about him at his <a href="http://www.nathancheek.com">website</a>.</p>
      </div>
      <div class="row">
      <div class="col-md-4">
        <div class="panel panel-info">
          <div class="panel-heading">
            <div class="panel-title">
              <h3>Create a discussion room</h3>
            </div>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" name="create" action="/create.php" method="post">
              <fieldset>
                <div class="form-group">
                    <input id="discuss" name="discuss" type="text" class="form-control input-md" placeholder="Discussion Name*" required="" autofocus>
                    <script>if (!("autofocus" in document.createElement("input"))) { document.getElementById("discuss").focus() }</script>
                </div>
                <div class="form-group">
                  <input id="1234" name="1234" type="password" class="form-control input-md" placeholder="Admin Password* (use a unique password)" required="">
                </div>
                <div class="form-group">
                  <textarea id="prompt" rows="3" name="prompt" class="form-control" placeholder="Discussion Prompt" rows="5"></textarea>
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
      </div>
      </div>
      </div>
    </div>
<?php include '../footer.php' ?>
