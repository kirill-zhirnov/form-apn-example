<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	echo 'ok';
	exit();
}

$request = json_decode(file_get_contents('php://input'), TRUE);

$type = null;
if (
	!empty($request['type'])
	&& in_array($request['type'], ['interestedInNewBoat', 'mainOffice', 'messageTo', 'subscribeForm', 'contactDealer'])
) {
	$type = $request['type'];
}

switch ($type) {
	case 'messageTo':
	case 'mainOffice':
	case 'interestedInNewBoat':
	case 'subscribeForm':
	case 'contactDealer':
		return interestedInNewBoat();

	default:
		sendJson(['unknown type'], false);
}

function interestedInNewBoat() {
	global $request;

	$errors = [];
//	if (empty($request['name'])) {
//		$errors['name'] = ['Name should be filled.'];
//	}

	if (empty($errors)) {
//		send
		sendJson([]);
	} else {
		sendJson(['errors' => $errors], false);
	}
}

function sendJson(array $out, $isSuccess = true) {
	if (!$isSuccess) {
		http_response_code(400);
	}

	header('Content-Type: application/json');
	echo json_encode($out);
	exit();
}