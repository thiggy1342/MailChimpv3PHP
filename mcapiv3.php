<?php

class MailChimp3 {

public $apikey;
public $root;

public function __construct($apikey=null) {

$this->apikey = $apikey;
$explodeKey = explode("-",$apikey,2);
$dc = (string) $explodeKey[1];
$this->root = "https://".$dc.".api.mailchimp.com/3.0/";

}

/*
once instantiated, you can use this call function to make any kind of request.
$requestType - (string) this will be the HTTP verbs like "GET", "POST", "PATCH", or "DELETE"
$filters - (string) these are the query strings at the end of the URL for which fields should be returned. Should be in the category.field format, and each entry should be comma separated.
$params - (array) this should be an array structured to follow the JSON schema for the call you're looking to make
$category - (string) this will be the first category of the endpoint, like "lists"
$instance - (string) this will be the instance of the topmost category like "list_id"; can be left out.
$subcategory - (string) this will be the subcategory of the instance above like "members"; can be left out.
$subcategoryInstance - (string) this will be instance of the above subcat, like "member_id"; can be left out.
$subSubcategory - (string) this should be the lowest level of the endpoint, like "ecomm"; can be left out.
$count = the number of entries to return.
$offset = the entry number to start at when returning a set of data
*/

public function call($requestType,$params=null, $category=null, $instance=null, $subcategory=null, $subcategoryInstance=null, $subSubcategory=null, $count=null, $offset=null, $filters=null) {

//adds category to endpoint URL if present
if (strlen($category)>0){
$methodEndpoint = $category;
}
//adds instance to endpoint URL if present
if (strlen($instance)>0){
$methodEndpoint =  $methodEndpoint."/".$instance;
}
//adds subcategory to URL if present
if (strlen($subcategory)>0){
$methodEndpoint =  $methodEndpoint."/".$subcategory;
}
//adds subcategoryInstance to URL if present
if (strlen($subcategoryInstance)>0){
$methodEndpoint =  $methodEndpoint."/".$subcategoryInstance;
}
//adds sub-subcategory to URL if present
if (strlen($subSubcategory)>0){
$methodEndpoint =  $methodEndpoint."/".$subSubcategory;
}
//adds query string filters to the end of the endpoint URL if present
if (strlen($filters)>0){
$methodEndpoint =  $methodEndpoint.'?fields='.$filters;
	if(strlen($count)>0){
	$methodEndpoint = $methodEndpoint.'&count='.$count;
	}
	if(strlen($offset)>0){
	$methodEndpoint = $methodEndpoint.'&offset='.$offset;
	}
} else {
	if(strlen($count)>0){
	$methodEndpoint = $methodEndpoint.'?count='.$count;
	} else {
		if(strlen($offset)>0){
		$methodEndpoint = $methodEndpoint.'?offset='.$offset;
		}
	}
	if(strlen($offset)>0){
	$methodEndpoint = $methodEndpoint.'&offset='.$offset;
	}
}

$requestBody = json_encode($params);

$curl = curl_init();

curl_setopt($curl, CURLOPT_USERAGENT, 'MailChimp v3 test');
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, $this->root.$methodEndpoint);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($requestType));
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: apikey '.$this->apikey));
curl_setopt($curl, CURLOPT_POSTFIELDS, $requestBody);

$responseBody = curl_exec($curl);

$result = json_decode($responseBody, true);

return $result;

curl_close($curl);

}

}

?>
