<?php
  $hostname = "localhost";
  $dbname = "depkesgabungan";
  $username = "root";
  $password = "root";

  $connect=mysql_connect($hostname,$username,$password) or die("Unable to Connect");
  mysql_select_db($dbname) or die("Could not open the db");
  echo "Connected to database";
   
  ?>