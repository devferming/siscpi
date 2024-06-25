<?php
  error_reporting(E_ALL ^ E_NOTICE);
  //error_reporting(E_ERROR | E_PARSE | E_NOTICE);

  $bd_client = 'cplainma_siscpi';
  $conn = new mysqli('localhost', 'root', '', $bd_client);
  if ($conn->connect_error) {
    echo $error->$conn->connect_error;
  }

?>

