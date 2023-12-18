import { Mail } from '$lib/mail';
import { error, json } from '@sveltejs/kit';

export async function POST({ request }) {
	const { html, to, subject, attachment } = await request.json();

	if (!html) error(400, 'No html provided.');
	if (!to) error(400, 'No to provided.');
	if (!subject) error(400, 'No subject provided.');

	try {
		await Mail.send({
			html,
			to: !Array.isArray(to) ? [to] : to,
			subject,
			attachments: attachment ? [attachment] : undefined
		});
	} catch (e) {
		if (e instanceof Error) {
			error(400, e.message);
		}
	}

	return json({ success: true });
}
