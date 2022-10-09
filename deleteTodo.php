<?php

require_once 'db.php';

$dbh = new DB();

$sth = $dbh->prepare("DELETE FROM todo WHERE `todo`.`id` = :id");

try {
  foreach ($_POST as $id => $status)
    if ($status == 'on')
      $sth->execute([
        ':id' => $id,
      ]);

  header("location: index.php");
} catch (Exception $e) {
  http_response_code(500);
}
