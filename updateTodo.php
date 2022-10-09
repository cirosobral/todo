<?php

require_once 'db.php';

$dbh = new DB();

$sth = $dbh->prepare("UPDATE `todo` SET `feito` = :status WHERE `todo`.`id` = :id;");

try {
  foreach ($_POST as $id => $status)
    $sth->execute([
      ':id' => $id,
      ':status' => ($status == 'false' ? false : true),
    ]);
} catch (Exception $e) {
  http_response_code(500);
}
