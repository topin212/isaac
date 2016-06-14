<?php
    namespace Isaac\Core;
    
    /**
     * A class, that takes a name of task, and task number? 
     */
    class ScriptExecuter
    {
        private $code;
        /**
         * 
         */
        public function __construct($code, $taskNumber)
        {
            $this->code = $code;
            $this->taskNumber = $taskNumber;
        }
    }
?>