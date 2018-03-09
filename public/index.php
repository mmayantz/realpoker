<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

require_once '../connection.php';


$app = new \Slim\App;

$conn = NULL;

$app->post('/register', function (Request $request, Response $response, array $args) {
    $data = $request->getParsedBody();

    $email = $data['email'];

    $status = 200;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$response->getBody()->write("Invalid email address format");
  		$status = 400;
	} else {

    	$sql = "SELECT count(*) from registration where email='$email'";

    	$res = getConnection()->query($sql);
    	$found = false;
	    foreach ($res as $row) {
        	if ($row['count(*)'] > 0) {
        		$found = true;
        	}
    	}

    	if ($found) {
    		$response->getBody()->write("Email is a duplicate of existing record");
    		$status = 409;
    	} else {
		 	$sql = "INSERT INTO registration (id, email) VALUES (null, '$email')";
	 		getConnection()->query($sql);
    	}

	}


    return $response->withStatus($status);
});
$app->run();

	# getConnection
	function getConnection(){
        global $conn;
        if(is_null($conn)){
            $conn = new Connection();
        }
        return $conn->getConnection();
    }