<?php
    namespace Isaac\Util;
    
    /**
     * 
     */
    class Task
    {
        private $id;
        private $name;
        private $annotation;
        private $answers;
        private $points;
        
        /**
         * Everything is self-explanatory, ain't it?
         */
        public function __construct($name,$annotation, $answers, $points)
        {
            $this->name = $name;
            $this->annotation = $annotation;
            $this->answers = $answers;
            $this->points = $points;
        }
        
        /**
         * Returns an array, that is ready-to-use in PDO wrapper
         */
        public function getInsertPack(){
            return array("insert into tasks(name, annotation, answers, points) values(?,?,?,?)", 
                        $this->name, $this->annotation, $this->answers, $this->points);
        }
    }
?>