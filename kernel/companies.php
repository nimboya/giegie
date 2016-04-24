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
                        //foreach($companies as $company) {
                        //    $response = $company;
                        //}
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
            
            // Validation
            $company = isset($params['company']) ? $params['company'] : null;;
            $cid = isset($params['cid']) ? $params['cid'] : null;;
            $description = isset($params['description']) ? $params['description'] : null;
        }
        
        public static function GetCompanies($params) {
            
        }
        
        
	public static function CreateService($params) {
            
        }
        
        public static function GetServices($params) {
            
        }
	
}

?>