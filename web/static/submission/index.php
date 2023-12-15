<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/class-dot-env.php';

$env_file = __DIR__ . '/../.env';
(new DotEnv($env_file))->load();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, GET, PATCH, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization, Origin');

$json = file_get_contents('php://input');
$data;

try {
	$data = json_decode($json, true);
} catch (Exception $e) {
	// noop.
}

if (empty($data)) {
	return;
}

$secret = recaptcha_v3_secret();
if (!empty($secret) && empty($data['gToken'])) {
	http_response_code(403);
	echo json_encode(['error' => 'no recaptcha']);

	return;
}

// Check recaptcha.
if (!empty($secret) && !check_recaptcha_token($data['gToken'])) {
	http_response_code(403);
	echo json_encode(['error' => 'wrong recaptcha']);

	return;
}

if (!empty($data['gToken'])) {
	unset($data['gToken']);
}

$message = '';

foreach ($data as $field => $value) {
	$message .= $field . ":\n" . $value . "\n\n";
}

$subject = 'The Cedars - Form Submission';

if (!empty($data['subject'])) {
	$subject = $data['subject'];
}

mail(form_mail_to(), $subject, $message, [
	'From' => 'website@the-cedars.org',
	'Reply-to' => $data['email'],
]);

$subject = 'The Cedars - Title Inquiry';

$title_inquiry = form_mail_title_inquiry();

if (!empty($title_inquiry) && !empty($data['inquiry']) && $data['inquiry'] === 'Title Company') {
	mail($title_inquiry, $subject, $message, [
		'From' => 'website@the-cedars.org',
		'Reply-to' => $data['email'],
	]);
}

echo json_encode(['data' => $data]);

return;
