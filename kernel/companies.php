<?php


class Companies {
	/*
		- List of Companies
	*/
	public static function AllCompanies($params) {
		$db = Utility::mysqlRes();		
		$companies= $db->companies();
                $response = array();
		if($companies->count() > 0) {
                $response = $companies;
		} else {
			$response = array('error_code'=>'0','status'=>'success','description'=>"No Results Found");
		}
		return $response;
	}
        
        public static function CreateCompany($params) {
            /*
             * $params: company, cid, description
             */
            $db = Utility::mysqlRes();
            $response = array();
            $errors = array();
            
            // Validation
            $company = isset($params['company']) ? $params['company'] : null;;
            $cid = isset($params['cid']) ? $params['cid'] : null;;
            $description = isset($params['description']) ? $params['description'] : null;
            
            if(strlen(trim($company)) === 0) {
                $errors[] = "Please enter Company Name!";
            }
            if(strlen(trim($cid)) === 0) {
                $errors[] = "Please enter Company ID!";
            }
            if(strlen(trim($description)) === 0) {
                $errors[] = "Please enter Description";
            }
            
            if(empty($errors)) {
                // Insert Data
                $companyparams = array('company'=>$company,'cid'=>$cid, 'description'=>$description);
		$proc = $db->companies->insert($companyparams);
		$response = array('error_code'=>0,'status'=>'success','description'=>"Company Created");
            } 
            else {
                    $errors = implode(",",$errors);
                    $response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
            }
            return $response;
        }
        
        public static function GetCompany($params) {
            $db = Utility::mysqlRes();		
            $companies= $db->companies()->where("cid",$params['cid']);
            $response = array();
            if($companies->count() > 0) {            
                foreach($companies as $company) {
                    $response = $company;
                }
            } else {
                    $response = array('error_code'=>'0','status'=>'success','description'=>"No Results Found");
            }
            return $response;
        }
        
	public static function CreateService($params) {
            /*
             * $params: cid, description, ussd
             */
            $db = Utility::mysqlRes();
            $response = array();
            $errors = array();
            
            // Validation
            $cid = isset($params['cid']) ? $params['cid'] : null;;
            $description = isset($params['description']) ? $params['description'] : null;;
            $ussd = isset($params['ussd']) ? $params['ussd'] : null;
            
            if(strlen(trim($cid)) === 0) {
                $errors[] = "Please enter Company ID!";
            }
            if(strlen(trim($description)) === 0) {
                $errors[] = "Please enter Description!";
            }
            if(strlen(trim($ussd)) === 0) {
                $errors[] = "Please enter USSD";
            }
            
            if(empty($errors)) {
                // Insert Data
                $companyparams = array('cid'=>$cid, 'description'=>$description, 'ussd'=>$ussd);
		$proc = $db->services->insert($companyparams);
		$response = array('error_code'=>0,'status'=>'success','description'=>"Service Created");
            } 
            else {
                    $errors = implode(",",$errors);
                    $response = array('error_code'=>1,'status'=>'failed','description'=>$errors);
            }
            return $response;
        }
        
        public static function GetServices($params) {
            /*
             * $params: cid
             */
            $db = Utility::mysqlRes();
            $cid = $params['cid']; 
            $services= $db->services("cid",$cid);
            $response = array();
            if($services->count() > 0) {            
                foreach($services as $service) {
                    $response = $service;
                }
            } else {
                    $response = array('error_code'=>'0','status'=>'success','description'=>"No Results Found");
            }
            return $response;
        }
	
}

?>