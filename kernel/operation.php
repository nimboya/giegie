<?php


class Operations {
	/*
		- Name of Professor - name
	*/
	public static function AllCompanies($params) {
		$db = Utility::mysqlRes();
		$response = array();
		
		$name = trim($params['name']);
		$state = trim($params['state']);
		
		$results= $db->profs();
		if($results->count() > 0) {
			$response = $results;
		} else {
			$response = array('error_code'=>'0','status'=>'failed','description'=>"No Results Found");
		}
		return $response;
	}
	
	
}

?>