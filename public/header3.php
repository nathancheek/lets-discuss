    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">Let's Discuss</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php if($navbarTitle=='home') echo 'class="active"' ?>><a href="/">Home</a></li>
            <li <?php if($navbarTitle=='about') echo 'class="active"' ?>><a href="/about">About</a></li>
          </ul>
          <form class="navbar-form navbar-right" action="../../discuss.php" method="get">
            <input id="discussion" name="discussion" type="text" placeholder="View a discussion" class="form-control" required="">
            <button id="discussion_view" type="submit" class="btn btn-success" value="go">Go</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

