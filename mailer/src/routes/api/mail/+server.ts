import { mail } from '$lib/utils/mail.js';
import { error, json } from '@sveltejs/kit';

export async function POST({ request }) {
	const { html, to, subject, attachment } = await request.json();

	if (!html) throw error(400, 'No html provided.');
	if (!to) throw error(400, 'No to provided.');
	if (!subject) throw error(400, 'No subject provided.');

	try {
		await mail({
			html,
			to: !Array.isArray(to) ? [to] : to,
			subject,
			attachments: attachment ? [attachment] : undefined
		});
	} catch (e) {
		if (e instanceof Error) {
			throw error(400, e.message);
		}
	}

	return json({ success: true });
}
