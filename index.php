<?php
    require_once __DIR__.'/vendor/autoload.php'; 
    error_reporting(E_ALL);
    Twig_Autoloader::register();
    
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array('cache' => false));
    
    $app = new Silex\Application(); 
    $app['debug'] = true;
    
    $app->get('/', function() use ($twig){
        return $twig->render('index.html');
        
    });
    
    $app->get('/uploadTest', function() use($twig){
        $fileSaver = new Isaac\Util\FileSaver();
        return $twig->render('uploadTest.html');//'uploadTest.html');//, array('name'=>'test', 'annotation'=>'unknown'));
    });
    
    $app->post('/fileSaving', function() use($app){
        $fileSaver = new Isaac\Util\FileSaver();

        $fileSaver->saveFiles();//$twig->render('uploadTest.html', array('message' => print_r($_FILES)));
        
        $codeExecutor = new Isaac\Core\ScriptExecutor($fileSaver->filePath, $fileSaver->taskNumber, 'Hello');
        $codeExecutor->prepare();
        $codeExecutor->execute();
        
        //$fileSaver->filePath;
        
        unlink(Isaac\Core\ScriptExecutor::CACHE_PATH.$codeExecutor->cachedName);
        unlink($fileSaver->filePath);
        return $codeExecutor->passed?'passed':'oh shit';
    });
    
    $app->get('/taskMaker', function() use($twig){
        return $twig->render('taskMaker.html'); 
    });
    
    $app->run(); 