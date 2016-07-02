<?php
    namespace Isaac\Core;
    
    /**
     * A class, that takes a name of task, and task number? 
     */
    class ScriptExecutor
    {
        //essentials
        private $code;
        private $taskNumber;
        
        //technical info
        private $filename;
        private $cachePath;
        private $executionString;
        
        /**
         * 
         */
        public function __construct($filepath, $taskNumber, $cachePath)
        {
            $this->code = file_get_contents($filepath);
            $this->taskNumber = $taskNumber;
            $this->cachePath = $cachePath;
            
            $this->executionString = '';
            $this->filename = $filepath;
        }
        
        
        /**
         * Preparing an execution string
         */
        public function prepare(){
            $matches = array();
            preg_match('/^[^\.]+\.([^$]+)/', $this->filename, $matches);
            switch($matches[1]){
                case 'c': $this->executionString = 'gcc '.$this->cachePath.'/kek.c -o '.$this->cachePath.'/test 2>&1 && ./test ';break;
                case 'cpp': $this->executionString = 'g++ '.$this->cachePath.'/kek.c -o '.$this->cachePath.'/test 2>&1 && ./test';break;
                
                //not yet ready
                case 'py': $this->executionString = 'python -c '.$this->cachePath.'/kek.c -o test 2>&1 && ./test';break;
            }
        }
        
        
        /**
         * Here we are launching the code, and checking the results
         */
        public function execute(){
            file_put_contents($this->cachePath.'/kek.c', $this->code);
            $codeResult = array();
            $errorCode = 0;
            exec($this->executionString, $codeResult, $errorCode);
            echo $errorCode;
            switch($errorCode){
                case 0: return $codeResult;
                case 1: return $codeResult[1];
                default: return "unhandled Error seen";
            }
            
        }
    }