<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication( '959574484121181','8763569a0b481a8e73b26413ab02a7b5' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://localhost/SEP_WE_016/public/fbauth/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?fields=id,name,email' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    //$_SESSION['FBID'] = $fbid;           
        $_SESSION['OAuth_name'] = $fbfullname;
	    $_SESSION['OAuth_email'] =  $femail;
    /* ---- header location after session ----*/
    
  header('Location: ' . '../googleauth');
} else {
  $loginUrl = $helper->getLoginUrl(array(
   'scope' => 'email'
));
 header("Location: ".$loginUrl);
}
?>