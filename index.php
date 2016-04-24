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
           $app->response()->header("Content-Type", "application/json");
           $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
           echo json_encode($resp);    
    }
});

$app->get('/allcompanies', function () use($app) {
	$params = $app->request()->get();
        try {
            if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = Companies::AllCompanies($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
            } else {
	    $app->response->setStatus(401);
            $app->response()->header("Content-Type", "application/json");
            $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
            echo json_encode($resp);    
            } 
        } catch     (Exception $ex) {
            $app->response->setStatus(401);
            $app->response()->header("Content-Type", "application/json");
            $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
            echo json_encode($resp);    
        }     	
});

$app->post('/savecompany', function () use($app) {
	$params = $app->request()->post();
        try {
            if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = Companies::CreateCompany($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
            } else {
                 $app->response->setStatus(401);
                $app->response()->header("Content-Type", "application/json");
                $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
                echo json_encode($resp);    
            }
        } catch (Exception $ex) {
             $app->response->setStatus(401);
            $app->response()->header("Content-Type", "application/json");
            $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
            echo json_encode($resp);    
        }
});

$app->get('/getcompany', function () use($app) {
	$params = $app->request()->get();
        try {
          if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = Companies::GetCompany($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
          } else {
	   $app->response->setStatus(401);
           $app->response()->header("Content-Type", "application/json");
           $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
           echo json_encode($resp);    
	  }  
        } catch (Exception $ex) {
           $app->response->setStatus(401);
           $app->response()->header("Content-Type", "application/json");
           $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
           echo json_encode($resp);    
        }
	
});

$app->post('/createservice', function () use($app) {
	$params = $app->request()->post();
        try {
            if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = Companies::CreateService($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
            } else {
                $app->response->setStatus(401);
                $app->response()->header("Content-Type", "application/json");
                $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
                echo json_encode($resp);    
            }
        } catch (Exception $ex) {
           $app->response->setStatus(401);
           $app->response()->header("Content-Type", "application/json");
           $resp = array('error_code'=>1,'status'=>'failed','description'=>'Unauthorized Access');
           echo json_encode($resp);    
        }
	
});

$app->get('/getservices', function () use($app) {
	$params = $app->request()->get();
        try {
            if($params['authkey'] == Utility::getConfig('authkey')) {
		$response = User::Login($params);
		$app->response()->header("Content-Type", "application/json");
		echo json_encode($response, JSON_FORCE_OBJECT);
            } else {
	    $app->response->setStatus(401);
	    $resp = array('error'=>'true','description'=>'Unauthorized Access');
	    echo json_encode($resp);
            } 
        } catch (Exception $ex) {
            $app->response->setStatus(401);
            $app->response()->header("Content-Type", "application/json");
            $resp = array('error'=>'true','description'=>'Unauthorized Access');
            echo json_encode($resp); 
        }
});


$app->get('/getservices', function () use($app) {
	
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