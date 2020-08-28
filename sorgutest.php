<?php

include "db.php";



$saattoplam = $database->query("SELECT WorkOrderItemId,OrtSure FROM aaa WHERE ResourceCode = 'OR008' GROUP BY WorkOrderItemId,OrtSure")->fetchAll();

print_r($saattoplam);

?>