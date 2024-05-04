import { sendMail } from '$lib/server/mail';
import { fail } from '@sveltejs/kit';
import { env } from '$env/dynamic/private';
import { dev } from '$app/environment';

export const actions = {
	async default({ request }) {
		const data = await request.formData();
		const inquiry = getFormDataAsString(data, 'inquiry');
		const address = getFormDataAsString(data, 'address');
		const seller = getFormDataAsString(data, 'seller');
		const buyer = getFormDataAsString(data, 'buyer');
		const email = getFormDataAsString(data, 'email');
		const phone = getFormDataAsString(data, 'phone');
		const message = getFormDataAsString(data, 'message');

		if (!message) return fail(400, { error: 'No message provided.' });
		if (!email) return fail(400, { error: 'No email provided.' });
		if (!inquiry) return fail(400, { error: 'No inquiry provided.' });

		const isTitleInquiry = inquiry === 'Title Company';

		const mergedMessage = `Inquiry: ${inquiry}
Address: ${address}
Seller: ${seller}
Buyer: ${buyer}
Email: ${email}
Phone: ${phone}
Message: \n\n${message}`;

		let to: string | string[] = '';
		const fallBackTo = env.FORM_TO ?? 'board@the-cedars.org';

		if (dev) {
			to = 'webmaster@the-cedars.org';
		} else if (isTitleInquiry && env.TITLE_INQUIRY) {
			to = [env.TITLE_INQUIRY, fallBackTo];
		} else {
			to = fallBackTo;
		}

		try {
			await sendMail({
				to,
				html: mergedMessage.split('\n').join('<br />'),
				from: email,
				subject: isTitleInquiry ? 'The Cedars - Title Inquiry' : 'The Cedars - Form Submission'
			});
		} catch (e) {
			if (e instanceof Error) {
				return fail(500, { error: e.message });
			}
		}

		return { error: null, success: 'Thank you for your submission' };
	}
};

function getFormDataAsString(formData: FormData, key: string): string {
	return formData.get(key) ? formData.get(key) + '' : '';
}
