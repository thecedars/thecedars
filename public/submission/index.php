<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/class-dot-env.php';

$env_file = __DIR__ . '/../.env';
(new DotEnv($env_file))->load();

$json = file_get_contents( 'php://input' );
$data;

try {
	$data = json_decode( $json, true );
} catch ( Exception $e ) {
	// noop.
}

if ( empty( $data ) ) {
	return;
}

$secret = recaptcha_v3_secret();
if ( ! empty( $secret ) && empty( $data['gToken'] ) ) {
	http_response_code( 403 );
	echo json_encode( array( 'error' => 'no recaptcha' ) );

	return;
}

// Check recaptcha.
if ( ! empty( $secret ) && ! check_recaptcha_token( $data['gToken'] ) ) {
	http_response_code( 403 );
	echo json_encode( array( 'error' => 'wrong recaptcha' ) );

	return;
}

if ( ! empty( $data['gToken'] ) ) {
	unset( $data['gToken'] );
}

$message = '';

foreach ( $data as $field => $value ) {
	$message .= $field . ":\n" . $value . "\n\n";
}

mail(
	form_mail_to(),
	'The Cedars - Form Submission',
	$message,
	array(
		'From'     => 'website@the-cedars.org',
		'Reply-to' => $data['email'],
	)
);

$title_inquiry = form_mail_title_inquiry();

if (
	!empty($title_inquiry) &&
	!empty($data['inquiry']) &&
	$data['inquiry'] === 'Title Company'
) {
	mail(
		$title_inquiry,
		'The Cedars - Title Inquiry',
		$message,
		array(
			'From'     => 'website@the-cedars.org',
			'Reply-to' => $data['email'],
		)
	);
}

echo json_encode( array( 'data' => $data ) );

return;
