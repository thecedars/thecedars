import {
	MAILGUN_API_KEY,
	MAILGUN_DOMAIN,
	SMTP_HOST,
	SMTP_USER,
	SMTP_PASS,
	SMTP_FROM,
	SMTP_PORT,
	SHEETID,
	GOOGLE_AUTH as googleAuth
} from '$env/static/private';

export interface GoogleAuthKey {
	type: string;
	project_id: string;
	private_key_id: string;
	private_key: string;
	client_email: string;
	client_id: string;
	auth_uri: string;
	token_uri: string;
	auth_provider_x509_cert_url: string;
	client_x509_cert_url: string;
}

export const GOOGLE_AUTH = JSON.parse(googleAuth) as GoogleAuthKey;

export * from './config';

export {
	MAILGUN_API_KEY,
	MAILGUN_DOMAIN,
	SMTP_HOST,
	SMTP_USER,
	SMTP_PASS,
	SMTP_FROM,
	SMTP_PORT,
	SHEETID
};
