<?php

require_once 'testcase_database.php';
require_once 'PHPUnit.php';

$suite  = new PHPUnit_TestSuite("DatabaseTestcase");
$phpunit= new PHPUnit();
$result = $phpunit->run($suite);
echo $result->toString();

?>