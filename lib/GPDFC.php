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
    private $location;
    private $environment;



    /**
     * GPDFC constructor.
     * @param $inputPath  //must be a pdf file
     * @param $outputFile //name of the output pdf file after compression
     * @param $fileLocation  // (optional) either local or foreign - default = local
     * @param $environment // (optional)either uinx or windows - default = unix
     */
    public function __construct($inputPath, $outputFile, $environment="unix", $fileLocation ="local")
    {

        $this->inputPath = $inputPath;
        $this->outputFile = $outputFile;
        $this->location = strtolower($fileLocation);
        $this->environment = strtolower($environment);
    }

    private function _validateSetUp(){
        if (!in_array($this->environment,CONFIG::ENV)){
            throw new Exception("Invalid environment parameter parsed");
        }
        if (!in_array($this->location,CONFIG::FILELOCATIONTYPE)){
            throw new Exception("Invalid environment parameter parsed");
        }
        return true;
    }
    /**
     * @param $location
     * @param $filePath
     * @return bool
     */
    private function _validateFile(){
        switch ($this->location){
            CASE 'external':
                $headers=get_headers($this->inputPath);
                if (stripos($headers[0],"200 OK") && mime_content_type($this->inputPath) == 'application/pdf'){
                    return true;
                }
                break;
            default:
                if(file_exists($this->inputPath) && mime_content_type($this->inputPath) == 'application/pdf'){
                    return true;
                }
        }
        throw new Exception("Invalid file parsed");
    }

    private function _getFileInformation($filePath){
        $PATH = 'compressed/'.$filePath;
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
            $this->_validateSetUp();
            $this->_validateFile();
        }catch (Exception $exception){

           return  'Caught exception: '.  $exception->getMessage(). "\n";
        }
            $command = new Command(CONFIG::OPTIONS[strtoupper($this->environment)]);
            $command->addArg('-sDEVICE=','pdfwrite')
                ->addArg('-dCompatibilityLevel=','1.4')
                ->addArg('-dPDFSETTINGS=',"/ebook")
                ->addArg('-sOutputFile=',array('compressed/'.$this->outputFile,$this->inputPath));

            if ($command->execute()) {
                $memoryAfter = memory_get_usage();
                $result = $this->_getFileInformation($this->outputFile);

                $result['memory']['before']=$memoryBefore;
                $result['memory']['after']=$memoryAfter;
                return $result;
            } else {
                echo $command->getError();
                $exitCode = $command->getExitCode();
            }
        return true;
    }




}