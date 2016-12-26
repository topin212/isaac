<?php
    namespace Isaac\Core;
    
    /**
     * A class, that takes a name of task, and task number? 
     */
    class ScriptExecutor{
        //essentials
        private $taskNumber;
        //make this an array for testing
        private $expectedResult;
        
        //technical info
        private $filename;
        private $cachePath;
        private $executionString;
        public $cachedName;
        
        public $passed;
        
        const CACHE_PATH = './uploads/exec_cache/';
        
        /**
         * 
         */
        public function __construct($filepath, $taskNumber, $expectedResult = 0, $cachePath = ScriptExecutor::CACHE_PATH){
            $this->taskNumber = $taskNumber;
            $this->cachePath = $cachePath;
            
            $this->executionString = '';
            $this->filename = $filepath;
            $this->expectedResult = $expectedResult;
            $this->cachedName = 'test';
        }
        
        
        /**
         * Preparing an execution string
         */
        public function prepare(){
            $matches = array();
            preg_match('/^\.[^\.]+\.(?<fileExtension>[^$]+)/', $this->filename, $matches);
            switch($matches['fileExtension']){
                case 'c':   $this->executionString = 'gcc '.$this->filename.' -o '.$this->cachePath.$this->cachedName.' 2>&1 && '.$this->cachePath.$this->cachedName;break;
                case 'cpp': $this->executionString = 'g++ '.$this->filename.' -o '.$this->cachePath.$this->cachedName.' 2>&1 && '.$this->cachePath.$this->cachedName;break;
                
                //not yet ready
                case 'py':  $this->executionString = 'python -c '.$this->filename.' -o test 2>&1 && .test';break;
                case 'hs': $this->executionString = ''; break;
                case 'java' : $this->executionString = ''; break; 
            }
        }
        
        
        /**
         * Here we are launching the code, and checking the results
         */
        public function execute(){
            $codeResult = array();
            $errorCode = 0;
            exec($this->executionString, $codeResult, $errorCode);
            switch($errorCode){
                case 0: return $this->passed = $codeResult[0] == $this->expectedResult;
                case 1: return $codeResult[1];break;
                default: return "Error code $errorCode";break;
            }
        }
    }