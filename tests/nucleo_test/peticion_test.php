<?php

require_once 'testcase_peticion.php';
require_once 'PHPUnit.php';

$_DEFAULT_APP ='TESTS';
$_DEFAULT_CONTROLLER = 'paginas';
$_DEFAULT_ACTION = 'index';

$suite  = new PHPUnit_TestSuite("PeticionTestcase");
$phpunit= new PHPUnit();
$result = $phpunit->run($suite);
echo $result -> toString();

?>