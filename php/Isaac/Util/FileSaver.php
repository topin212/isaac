<?php
namespace Isaac\Util;

/**
 * 
 */
class FileSaver
{
    private $data;
    public $filePath;
    public $taskNumber;
    
    public function __construct()
    {
        $data = array();
    }
    
    //TODO: Rewrite this totally
    public function saveFiles(){
        $error = false;
        $file = $_FILES['solution'];
    
        $uploaddir = './uploads/';
        if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name'])))
        {
            $this->filePath = $uploaddir .$file['name'];
            $this->taskNumber = $_POST['taskNumber'];
        }
        else
        {
            $error = true;
        }
        
        //$data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);

        //$data = array('success' => 'Dunno, actually', 'formData' => $_POST);
        return json_encode($_POST);
    }
}