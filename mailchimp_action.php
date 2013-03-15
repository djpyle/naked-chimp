<?php
// Brought to you by: ChimpChamp.com

// EDIT THE NEXT 4 LINES ONLY

$apikey = 'YOURAPIKEY'; // Enter your API Key
$listId = 'YOURLISTID'; // Enter your List ID
$double = 'false'; // Enter true or false for Double Opt-in
$welcome = 'true'; // Enter true or false to send the Final Welcome Email Message

// EDIT BELOW THIS LINE AT YOUR OWN RISK

ob_start();
echo "Your request is being processed...";

$name = $_POST["fname"];
$email = $_POST["email"];
$format = "html";

require_once 'MCAPI.class.php';
$api = new MCAPI($apikey);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

	$retval = $api->listMemberInfo( $listId, array($email) );
	//var_dump($retval);
	if($retval){
		$cnt = $retval['data']['0']['merges']['COUNT'];
		$success = $retval['success'];
	}
	if($success == '0'){
		//CODE TO ADD NEW SUBSCRIBER
		echo "new subscriber";
		$merge_vars = array(
				'FNAME'=>$name, 
				'LNAME'=>'',
				);

			$retval = $api->listSubscribe( $listId, $email, $merge_vars, $format, $double, $welcome);

			if ($api->errorCode){
				echo "Unable to load listSubscribe()!\n";
				echo "\tCode=".$api->errorCode."\n";
				echo "\tMsg=".$api->errorMessage."\n";
			} else {
			    echo "Subscribed - look for the confirmation email!\n";
			}
		header ("Location: index.php?msg=success");
		//CODE TO UPDATE SUBSCRIBER
		/*if($cnt == 0){
			$count = '1';
			$merge_vars = array(
				'FNAME'=>$name, 
				'LNAME'=>$name,
				'COUNT'=> $count
				);

			$retval = $api->listUpdateMember($listId, $email, $merge_vars, 'html', false);

			if ($api->errorCode){
				echo "Unable to load listSubscribe()!\n";
				echo "\tCode=".$api->errorCode."\n";
				echo "\tMsg=".$api->errorMessage."\n";
			} else {
			    echo "Subscribed - look for the confirmation email!\n";
			}
		}
		header ("Location: index.php?msg=update");*/
	}else{
		header ("Location: index.php?msg=update");
	}
}else{
		header ("Location: index.php?msg=email_error");
}

?>
