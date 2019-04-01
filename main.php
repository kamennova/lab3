<?php

include_once 'Stack.php';
include_once 'MathExpression.php';

$string = readline('Enter  mathematical expression: ');
$exp = new MathExpression();
$exp::calculate($string);