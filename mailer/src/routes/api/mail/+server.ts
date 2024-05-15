import { Mail } from '$lib/mail';
import { error, json } from '@sveltejs/kit';

export async function POST({ request }) {
	const formdata = await request.formData();
	const html = formdata.get('html');
	const to = formdata.getAll('to');
	const subject = formdata.get('subject');

	if (!html) error(400, 'No html provided.');
	if (!to?.length) error(400, 'No to provided.');
	if (!subject) error(400, 'No subject provided.');

	try {
		await Mail.send({
			html: html + '',
			to: !Array.isArray(to) ? [to + ''] : to.map((t) => t + ''),
			subject: subject + '',
			attachments: formdata.getAll('attachment')
		});
	} catch (e) {
		if (e instanceof Error) {
			error(400, e.message);
		}
	}

	return json({ success: true });
}
