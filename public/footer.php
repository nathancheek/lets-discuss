      </div>
    </div><!-- /container -->
    <div class="container">
      <footer>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
?>
        <hr>
        <p>Developed by <a href="http://www.nathancheek.com">Nathan Cheek</a> 2014 - Times are in UTC - Gen'd in <?php echo $total_time; ?> secs</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>