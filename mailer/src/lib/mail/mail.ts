import { SMTP_FROM, SMTP_HOST, SMTP_PASS, SMTP_PORT, SMTP_USER } from '$lib/config.server';
import nodemailer from 'nodemailer';
import type IMail from 'nodemailer/lib/mailer';
import type { MailOptions } from 'nodemailer/lib/sendmail-transport';

interface MailClassOptions {
	from: string;
	host: string;
	pass: string;
	port: string;
	user: string;
}

function isFile(file: FormDataEntryValue): file is File {
	return file instanceof File;
}

class MailClass {
	from: string;
	host: string;
	pass: string;
	port: string;
	user: string;

	constructor(options: MailClassOptions) {
		this.from = options.from;
		this.host = options.host;
		this.pass = options.pass;
		this.port = options.port;
		this.user = options.user;
	}

	async send(options: {
		html: string;
		to: string[];
		subject: string;
		attachments?: FormDataEntryValue[];
	}) {
		const { html, to, subject, attachments } = options;

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

		const maskedTo =
			!Array.isArray(to) || to.length === 1 ? 'webmaster@the-cedars.org' : 'board@the-cedars.org';

		const chunkSize = 90;
		const list = [...Array(Math.ceil(to.length / chunkSize))].map(() => to.splice(0, chunkSize));

		for (const bcc of list) {
			try {
				const settings: MailOptions = {
					from: 'The Cedars HOA <' + SMTP_FROM + '>',
					replyTo: 'board@the-cedars.org',
					to: maskedTo,
					bcc,
					html: html ?? '<div>Placeholder message</div>',
					subject: subject ?? 'Cedars HOA Email Tool'
				};

				if (attachments?.length) {
					const mailAttachments: IMail.Attachment[] = [];
					for (const attachment of attachments) {
						if (isFile(attachment) && attachment.size > 0) {
							mailAttachments.push({
								filename: attachment.name,
								content: Buffer.from(await attachment.arrayBuffer())
							});
						}
					}

					if (mailAttachments.length) settings.attachments = mailAttachments;
				}

				await transporter.sendMail(settings);
			} catch (e) {
				const error = typeof e === 'object' ? e : {};
				const message = error && 'message' in error ? error.message : '';

				if (message) console.error(message);
			}
		}
	}
}

const Mail = new MailClass({
	from: SMTP_FROM,
	host: SMTP_HOST,
	pass: SMTP_PASS,
	port: SMTP_PORT,
	user: SMTP_USER
});

export default Mail;
