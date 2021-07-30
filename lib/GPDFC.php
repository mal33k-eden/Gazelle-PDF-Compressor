<?php

namespace EmmKwami\GPDFC;

use Exception;
use mikehaertl\shellcommand\Command;
use EmmKwami\GPDFC\GPDFCCONFIG\GPDFCCONFIG as CONFIG;

//require_once __DIR__."/vendor/autoload.php";

// Initialize library class
class GPDFC extends CONFIG{

    private $inputPath;
    private $outputFile;
    private $result = [];



    /**
     * GPDFC constructor.
     * @param $inputPath  //must be a pdf file
     * @param $outputFile //name of the output pdf file after compression
     */
    public function __construct($inputPath, $outputFile)
    {

        $this->inputPath = $inputPath;
        $this->outputFile = $outputFile;
    }

    private function _validateFile(){
        if(file_exists($this->inputPath) && mime_content_type($this->inputPath) == 'application/pdf'){
            return true;
        }
        throw new Exception("Invalid file parsed");
    }

    private function _getFileInformation($filePath){
        $PATH = $filePath;
        $arr = pathinfo($PATH);
        $fileName = $arr['basename'];
        //Clear cache and check filesize again
        clearstatcache();
        $fileByteSize = filesize($PATH);
        $fileReadableSize = CONFIG::FileSizeConvert($fileByteSize);
        return  array("name"=>$fileName, "byte-size"=>$fileByteSize,"readable-size"=>$fileReadableSize);
    }

    public function compress(){
        $memoryBefore = memory_get_usage();
        try {
            $this->_validateFile();
        }catch (Exception $exception){

           return  'Caught exception: '.  $exception->getMessage(). "\n";
        }
            $command = new Command('/usr/bin/gs -dNOPAUSE -dQUIET -dBATCH');
            $command->addArg('-sDEVICE=','pdfwrite')
                ->addArg('-dCompatibilityLevel=','1.4')
                ->addArg('-dPDFSETTINGS=',"/ebook")
                ->addArg('-sOutputFile=',array($this->outputFile,$this->inputPath));

        if ($command->execute()) {
            $memoryAfter = memory_get_usage();
            $result['status'] = 'success';
            $result = $this->_getFileInformation($this->outputFile);

            $result['memory']['before']=$memoryBefore;
            $result['memory']['after']=$memoryAfter;
            return $result;
        } else {
            $result['status'] = 'error';
            $result['msg'] = $command->getError();
            $result['code'] = $command->getExitCode();
        }
        return true;
    }




}