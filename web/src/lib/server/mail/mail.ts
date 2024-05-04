import { SMTP_FROM, SMTP_HOST, SMTP_PASS, SMTP_PORT, SMTP_USER } from '$env/static/private';
import nodemailer from 'nodemailer';
import type { MailOptions } from 'nodemailer/lib/sendmail-transport';

export async function sendMail(options: {
	html: string;
	from: string;
	subject: string;
	to: string | string[];
}) {
	const { html, from, subject, to } = options;

	if (!SMTP_HOST) throw new Error('mail is missing process.env.' + SMTP_HOST);
	if (!SMTP_USER) throw new Error('mail is missing process.env.' + SMTP_USER);
	if (!SMTP_PASS) throw new Error('mail is missing process.env.' + SMTP_PASS);
	if (!SMTP_FROM) throw new Error('mail is missing process.env.' + SMTP_FROM);

	const transporter = nodemailer.createTransport({
		host: SMTP_HOST,
		port: parseInt(SMTP_PORT || '587'),
		auth: {
			user: SMTP_USER,
			pass: SMTP_PASS
		}
	});

	try {
		const settings: MailOptions = {
			from: 'The Cedars HOA <' + SMTP_FROM + '>',
			replyTo: from,
			to,
			html,
			subject: subject ?? 'Cedars Website Message'
		};

		await transporter.sendMail(settings);
	} catch (e) {
		const error = typeof e === 'object' ? e : {};
		const message = error && 'message' in error ? error.message : '';

		if (message) console.error(message);
	}
}
