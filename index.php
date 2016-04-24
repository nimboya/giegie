<?php
/*
@ Author: Ewere Diagboya
@ Date: 12-04-2016
@ Time: 4:54pm
@ Location: Ikoyi, Lagos
@ Project: giegie Mobile App
*/
require_once "Slim/Slim.php";
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


// Post is to Create
// Get is to Retrieve
// Put is to Update

// Import Kernel/Db Functions
$kernel = (array)glob('kernel/*.php');
foreach ($kernel as $kernelFile) {
    require $kernelFile;
}

$app->post("/activate", function () use($app) {
   $params = $app->request()->post();
    
    if($params['authkey'] == Utility::getConfig('authkey')) {
      $response = User::Activate($params);    
      $app->response()->header("Content-Type", "application/json");
	  echo json_encode($response, JSON_FORCE_OBJECT);
    } else {
	  $app->response->setStatus(401);
	  $resp = array('error'=>'true','description'=>'Unauthorized Access');
      json_encode($resp);
    }
});

    $app->get('/allcompanies', function () use($app) {
	$params = $app->request()->get();
        
        if(empty($params['authkey'])) {
            $app->response->setStatus(401);
            $resp = array('error'=>'true','status'=>'failed','description'=>'No Auth Key');
        }
        try {
           if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = Companies::AllCompanies($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
            echo json_encode($resp);
	} 
        } catch (Exception $ex) {
            $app->response->setStatus(401);
            $resp = array('error'=>'true','description'=>'Unauthorized Access');
            echo json_encode($resp);
        }
        	
});

$app->post('/savecompany', function () use($app) {
	$params = $app->request()->post();
	if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = User::Login($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
	    echo json_encode($resp);
	}
});

$app->get('/getcompany', function () use($app) {
	$params = $app->request()->post();
	if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = User::Login($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
	    echo json_encode($resp);
	}
});

$app->post('/services', function () use($app) {
	$params = $app->request()->get();
	if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = User::Login($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
	    echo json_encode($resp);
	}
});

$app->get('/services', function () use($app) {
	
	$params = $app->request()->post();
	if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = User::Login($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
        } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
	    echo json_encode($resp);
	}
});

$app->run();