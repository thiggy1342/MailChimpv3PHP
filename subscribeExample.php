<?php
//This is a short example of how to add a subscriber to the list
include('mcapiv3.php');

$mc = new MailChimp3('yourApiKeyHere-usX');

$email = "testing@test.com";

//we'll be making the request to the list members collection, so we'll need to include the category, instance ID, and subcategory
$category = "lists";
$listId = "a1b2c3d4";
$subcategory = "members";

//Next, we'll need to set the parameters according to the JSON schema: https://us3.api.mailchimp.com/schema/3.0/Lists/Members/Instance.json
$requestBody = array(
  'email_address'=>$email,
  //when adding a subscriber, the status is used to set the opt-in method. Subscribed=single opt-in, pending=double opt-in. You can also set to unsubscribed or cleaned.
  'status'=>'subscribed',
  'email_type'=>'html',
  'merge_fields'=>array(
    'FNAME'=>'Testy',
    'LNAME'=>'McTesterson'
  )
);

//Now, use the call method to make the request. We'll need to make a POST request to create the new subscriber.
$requestType = 'POST';
$mc->call($requestType, $requestBody, $category, $listId, $subcategory);

?>
