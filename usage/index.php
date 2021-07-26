<?php
require '../vendor/autoload.php';

use EmmKwami\GPDFC\GPDFC;

$input = '../storage/staff/documents/sup_docs/in.pdf';
$output = 'o.pdf';

$GPDFC = new GPDFC($input, $output, 'unix','local');

var_dump($GPDFC->compress());