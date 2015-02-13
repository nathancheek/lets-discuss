<?php
$sqlLoc="localhost"
$sqlUsr="";
$sqlPassword="";
$sqlDb="";

        $sqlconnect=mysqli_connect($sqlLoc,$sqlUsr,$sqlPassword,$sqlDb);
        if (mysqli_connect_errno($sqlconnect) ) {
                $sqlerror="true";
        }
?>
