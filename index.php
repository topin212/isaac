<?php
    require_once __DIR__.'/vendor/autoload.php'; 
    Twig_Autoloader::register();
    
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader, array('cache' => false));
    
    $app = new Silex\Application(); 
    $app['debug'] = true;
    
    $app->get('/', function() use ($twig){
        return $twig->render('index.html');
        
    });
    
    //testing codeExecutor
    $app->get('/codeTest', function() use($app){
        $codeExecutor = new Isaac\Core\ScriptExecutor('codeSamples/test.c', 1, __DIR__.'/codeSamples/cache');
        $codeExecutor->prepare();
        return '<pre>'.$codeExecutor->execute().'</pre>';
    });
    
    $app->get('/uploadTest', function() use($twig){
        return $twig->render('uploadTest.html', array('meta' => file_get_contents('templates/meta.html')));//'uploadTest.html');//, array('name'=>'test', 'annotation'=>'unknown'));
    });
    
    $app->get('/taskMaker', function() use($twig){
        return $twig->render('taskMaker.html'); 
    });
    
    $app->run(); 