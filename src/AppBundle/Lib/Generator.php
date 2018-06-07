<?php

namespace AppBundle\Lib;

use AppBundle\Entity\Code;

class Generator{
    private $nameFile; // nazwa pliku z kodami domyślnie tmp.file do katalogu web
    private $timeDelay; // opoźnienie w microsekundach 
    private $logger;
    private $em = false;
    private $repo = false;

    public function __construct($logger, $nameFile = "tmp.file", $timeDelay = 0) {
        $this->nameFile = $nameFile;
        $this->timeDelay = $timeDelay;
        $this->logger = $logger;
    }

    public function generate($countOfCodes, $lenghtOfCode){
        for ($i=0; $i < $countOfCodes; $i++){
            usleep($this->timeDelay);
            $num = $this->generateChar($lenghtOfCode);
            if(!$this->issetCode($num)){
                file_put_contents($this->nameFile, $num.PHP_EOL, FILE_APPEND | LOCK_EX);
                
                if($this->em){
                    $code = new Code();
                    $code->setCode($num);
                    $this->em->persist($code);
                    $this->em->flush();
                }
            }
        }
    }
    
    public function setEMR($em, $repo){
        $this->em = $em;
        $this->repo = $repo;
    }
    
    function getNameFile() {
        return $this->nameFile;
    }

    function setNameFile($nameFile) {
        $this->nameFile = $nameFile;
    }

    
    private function generateChar($length){
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $key = "";

        for ($i=0; $i < $length; $i++) {
            $randNumber = rand(0, 61);
            $key .= $characters[$randNumber];
        }

        return $key;
    }

    private function issetCode($code){
        if(!$this->em){
            if(file_exists($this->nameFile)){
                $handle = fopen($this->nameFile, "r") or $this->logger->err("Couldn't get handle");
                if ($handle) {
                    while (!feof($handle)) {
                        $buffer = fgets($handle, 4096);
                        if($buffer == $code)
                            return true;
                    }
                    fclose($handle);
                }
            }        
            return false;
        }
        else{
            return $this->repo->findBy(['code' => $code]);
        }
        
    }
}

