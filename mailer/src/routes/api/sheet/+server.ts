import { SHEETID } from '$env/static/private';
import { googleLoadSpreadsheet } from '$lib/utils/google-load-spreadsheet.js';
import { error, json } from '@sveltejs/kit';

export async function GET({ url }) {
	const sheetId = url.searchParams.get('sheetId') ?? SHEETID;

	if (!sheetId) {
		throw error(400, 'No sheet id provided.');
	}

	const sheet = await googleLoadSpreadsheet(sheetId);

	return json(sheet);
}
