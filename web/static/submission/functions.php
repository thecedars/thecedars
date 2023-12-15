<?php

/**
 * Function to check the recaptcha.
 *
 * @param string $token Google Recaptcha token to test.
 * @return boolean If successful.
 */
function check_recaptcha_token($token) {
	$body = [
		'secret' => recaptcha_v3_secret(),
		'response' => $token,
		'remoteip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',
	];

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($body));
	curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$jsonresponse = curl_exec($verify);
	$results = json_decode($jsonresponse, true);

	if (isset($results['success']) && true === $results['success']) {
		return true;
	}

	return false;
}

/**
 * Google Secret.
 *
 * @return string
 */
function recaptcha_v3_secret() {
	return getenv('RECAPTCHA_SECRET_KEY');
}

/**
 * Form To Email.
 *
 * @return string
 */
function form_mail_to() {
	return getenv('FORM_TO');
}

/**
 * Title Inquiry Email.
 *
 * @return string
 */
function form_mail_title_inquiry() {
	return getenv('TITLE_INQUIRY');
}
