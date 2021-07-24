<?php
use  EmmKwami\GPDFC\GPDFC;
require('../vendor/autoload.php');

$GPDFC = new GPDFC('gwy.pdf','out.pdf');

// function _validateSetUp($n , $GPDFC){
//
//    if (!in_array($n,$GPDFC::ENV)){
//        return new Exception("Invalid environment parameter parsed");
//    }
////    if (!in_array($this->location,CONFIG::FILELOCATIONTYPE)){
////        return new Exception("Invalid environment parameter parsed");
////    }
//    return true;
//}
//
//try {
//     echo _validateSetUp('unix',$GPDFC);
//}catch (Exception $e){
//    echo   'Caught exception: '.  $e->getMessage(). "\n";
//}

var_dump($GPDFC->compress());









//
//use mikehaertl\shellcommand\Command;
//
//// Basic example
//$command = new Command('/usr/local/bin/gs -dNOPAUSE -dQUIET -dBATCH');
//$command->addArg('-sDEVICE=','pdfwrite')->addArg('-dCompatibilityLevel=','1.4')->addArg('-dPDFSETTINGS=',"/ebook")->addArg('-sOutputFile=',array('output.pdf','gwy.pdf'));
//
//if ($command->execute()) {
//    echo $command->getOutput();
//} else {
//    echo $command->getError();
//    $exitCode = $command->getExitCode();
//}
