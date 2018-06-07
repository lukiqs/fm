<?php

namespace AppBundle\Entity;

class GenerateForm{
    protected $numberOfCodes;
    protected $numberOfChars;
    
    function getNumberOfCodes() {
        return $this->numberOfCodes;
    }

    function getNumberOfChars() {
        return $this->numberOfChars;
    }

    function setNumberOfCodes($numberOfCodes) {
        $this->numberOfCodes = $numberOfCodes;
    }

    function setNumberOfChars($numberOfChars) {
        $this->numberOfChars = $numberOfChars;
    }
}

