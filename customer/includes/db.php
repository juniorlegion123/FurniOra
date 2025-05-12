<?php
  $host = getenv('DB_HOST');
  $user = getenv('DB_USER');
  $pass = getenv('DB_PASS');
  $name = getenv('DB_NAME');
  $port = getenv('DB_PORT');

  $con = mysqli_connect($host, $user, $pass, $name, $port);

  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>