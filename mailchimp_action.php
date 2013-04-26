<?php
// Brought to you by: ChimpChamp.com 


Class XmlUtils {
 
    public static function xmlToObject($xml, $obj = null) {
        if (!$obj) $obj = new StdClass();
        //**********************************************************
        // Create array of unique node names
        $uniqueNodeNames = array();
        foreach ($xml->children() as $xmlChild) {
            @$uniqueNodeNames[$xmlChild->getName()]++;
        }
        //**********************************************************
        // Create child types - object for single nodes, array of objects for multi nodes:
        foreach ($uniqueNodeNames as $nodeName => $nodeCount) {
            if ($nodeCount > 1) {
                $obj->$nodeName = array();
                for ($i=0; $i<$nodeCount; $i++) {
                    array_push($obj->$nodeName, new StdClass());
                }
            } else {
                $obj->$nodeName = new StdClass();
            }
        }
        //**********************************************************
        // For each child node: add attributes as object properties and invoke recursion
        $arrayIdx = array();
        foreach ($xml->children() as $xmlChild) {
            $str = trim($xmlChild);
            //print_r($xmlChild->attributes());
            $nodeText = trim($xmlChild);
            $nodeName = $xmlChild->getName();
            // If child is array
            if (is_array($obj->$nodeName)) {
                $idx = (int)@$arrayIdx[$nodeName];
                $objArray = $obj->$nodeName;
                // Add attributes as object properties
                foreach($xmlChild->attributes() as $attributeType => $attributeValue) {
                    $objArray[$idx]->$attributeType = (string)$attributeValue;
                }
                // If element text (e.g. <node>ElementText<node>
                if (strlen($nodeText)) $objArray[$idx]->$nodeName = $nodeText;
                // Invoke recursion
                XmlUtils::xmlToObject($xmlChild, $objArray[$idx]);
            }
            // If child is object
            if (is_object($obj->$nodeName)) {
                // Add attributes as object properties
                foreach($xmlChild->attributes() as $attributeType => $attributeValue) {
                    $obj->$nodeName->$attributeType = (string)$attributeValue;
                }
                // If element text (e.g. <node>ElementText<node>
                if (strlen($nodeText)) $obj->$nodeName->$nodeName = $nodeText;
                // Invoke recursion
                XmlUtils::xmlToObject($xmlChild, $obj->$nodeName);
            }
            @$arrayIdx[$nodeName]++;
        }
        return $obj;
    }
 
    public static function xmlFileToObject($xmlFileName) {
        if (!file_exists($xmlFileName)) die ("XmlUtils::xmlFileToObject Error: $xmlFileName nonexistent!");
        $xml = simplexml_load_file($xmlFileName);
        return XmlUtils::xmlToObject($xml);
    }
}



// EDIT THE NEXT 4 LINES ONLY

// $apikey = 'YOURAPIKEY'; // Enter your API Key
// $listId = 'YOURLISTID'; // Enter your List ID
$double = 'false'; // Enter true or false for Double Opt-in
$welcome = 'true'; // Enter true or false to send the Final Welcome Email Message

	$name = $_POST["fname"];
	$format = "html";
	$xmlFile = 'input.xml';
	$resultObj = XmlUtils::xmlFileToObject($xmlFile);
	$email = !isset($_POST['email']) ? 0 : $_POST['email'];
    $email_type='html';
	$totalgroupings = intval($resultObj->totalgroupings->key);


    $apikey = $resultObj->apikey->key;
    $apiUrl = 'http://api.mailchimp.com/1.3/';
	$listId = $resultObj->listid->key; 
	$double=$resultObj->doubleoptin->key;
	$update_existing=true;
	$replace_interests=true;
	$welcome=$resultObj->welcomeemail->key;
	$successtype=$resultObj->successtype->key;
    $thankyouurl=$resultObj->thankyouurl->key;



	

	require_once 'MCAPI.class.php';
	

	// EDIT BELOW THIS LINE AT YOUR OWN RISK
	ob_start();
	echo "Your request is being processed...";


	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

		//$success ="";
		//$retval = $api->listMemberInfo( $listId, array($email) );
		// var_dump($retval);
		// if($retval){
		// 	$cnt = $retval['data']['0']['merges']['COUNT'];
		// 	$success = $retval['success'];
		// }
			//CODE TO ADD NEW SUBSCRIBER
			echo "new subscriber<br>";
			
		    $index=0;
		    $groupArray =array();
		    //print_r($resultObj->groups);
		    foreach ($resultObj->groups as $groups) {
		    	
		    	$garray ='';
		    	$Gettype = gettype($groups);
		    	if($Gettype == 'array'){
			    	foreach ($groups as $groupings) {

			    	 	$grouping = $groupings->key;
			    	 	$intrests = array();
			    	 	
			    	 	foreach ($groupings->group as $gp){
			      	 	if(empty($gp->key)){
			      	 		echo $resultObj->grouping->key ."==>".$gp."<br />";
			      	 		$garray[++$index] = array('name'=>$groupings->key,'groups'=>$gp);        
			      	 	}else{	
			      	 	  echo $resultObj->grouping->key ."==>".$gp->key."<br />";
			      	 	  $garray[++$index] = array('name'=>$groupings->key,'groups'=>$gp->key);        
			      	 	}			      	 		
			       	}
			    	 	$groupArray = $garray;
			    	} 
		    	}else{

		        foreach ($groups->group as $gp){
		          if(empty($gp->key)){
		           echo $groups->group->key ."==>".$gp."<br />";
		           $garray[++$index] = array('name'=>$groups->key,'groups'=>$gp);        
		            
		          }else{ 
		            echo $groups->group->key ."==>".$gp->key."<br />";
		            $garray[++$index] = array('name'=>$groups->key,'groups'=>$gp->key);        
		          } 
		           
		        }
		    	}
		    }

		   $merge_vars = array('FNAME'=>$name, 
		 	'LNAME'=>"", 
		 	'EMAIL'=>htmlentities($email),
		    'GROUPINGS'=>$garray
		    );

		   		$api = new MCAPI($apikey);

                $retval = $api->listSubscribe($listId,$email, $merge_vars,$email_type,$double,$update_existing, $replace_interests, $welcome);
				//$retval = $api->listSubscribe( $listId, $email, $merge_vars, $format, $double, $welcome);
		    
				if ($api->errorCode){
					echo "Unable to load listSubscribe()!\n";
					echo "\tCode=".$api->errorCode."\n";
					echo "\tMsg=".$api->errorMessage."\n";
					header ("Location: index.php?msg=email_error");

				} else {

					echo "\n Subscribed";
					if($successtype === "url")
				    {
				      	header ("Location: ".$thankyouurl);
											    
				    }
				    else 
				    {
				        header ("Location: index.php?msg=success");
				    }

				}
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
			header ("Location: index.php?msg=email_error");
	}

?>
