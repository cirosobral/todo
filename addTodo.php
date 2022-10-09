<?php

require_once 'db.php';

$dbh = new DB();

$sth = $dbh->prepare("INSERT INTO `todo` (`texto`) VALUES (:todo);");

try {
  $sth->execute([
    ':todo' => $_POST['todo'],
  ]);

  header("location: index.php");
} catch (Exception $e) {
  http_response_code(500);
}
