<?php
    $description="";
    $author="";
    $title="Welcome to Let's Discuss";
    $navbarTitle="home";
    include 'header.php';
    //insert custom css here
    echo "<link href=\"../../jumbotron.css\" rel=\"stylesheet\">";
    //header2.php is for regular wrap
    include 'header2.php';
    include 'header3.php';
?>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
      <div class="col-md-8">
        <h1 class="title">Welcome to Let's Discuss</h1>
        <p>This site makes it easy to manage any kind of discussion. Just choose a discussion name and set an admin password. Later you can set various options such as closing time, access password, and email alerts.</p>
        <p><a class="btn btn-primary btn-lg" role="button" href="#getting-started">Learn more &raquo;</a></p>
      </div>
      <div class="row">
      <div class="col-md-4">
        <div class="panel panel-info create-panel">
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
                  <!-- Take that NSA (till I add https) -->
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
                      <div class="col-md-4">
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

    <div class="container info" style="margin-top: 10px;">
    <a name="getting-started" class="anchor"></a>
    <p><h1>Getting Started</h1></p>
      <div class="row">
        <div class="col-sm-4">
        <div class="well well-main">
          <h2>Discussion Name</h2>
          <p>Choose a unique title for your discussion.  This will be what everyone uses to look up the discussion room.</p>
        </div>
        </div>
        <div class="col-sm-4">
        <div class="well well-main">
          <h2>Admin Password</h2>
          <p>Setting an administrative password for the discussion allows you - and only you - to change settings such as closing time or user authentication requirements, as well as delete the discussion.</p>
        </div>
        </div>
        <div class="col-sm-4">
        <div class="well well-main">
          <h2>Discussion Prompt</h2>
          <p>Optionally enter a discussion prompt for everyone to see when they load the discussion.</p>
        </div>
        </div>
      </div>
      <p><h1>Other Features</h1></p>
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
        <div class="well">
        <h4>
        <p><span class="glyphicon glyphicon-star"></span> *Set closing time</p>
        <p><span class="glyphicon glyphicon-star"></span> *Set access password</p>
        <p><span class="glyphicon glyphicon-star"></span> *Get email alerts</p>
        <p><span class="glyphicon glyphicon-star"></span> *Require Google authentication</p>
        <p><span class="glyphicon glyphicon-star"></span> Limit post character length</p>
	<p>*Coming Soon</p>
        </h4>
        </div>
        </div>
      </div>
    </div>
<?php include 'footer.php' ?>
