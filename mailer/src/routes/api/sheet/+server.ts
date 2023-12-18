import { SHEETID } from '$lib/config.server';
import { Sheets } from '$lib/sheets';
import { error, json } from '@sveltejs/kit';

export async function GET({ url }) {
	const sheetId = url.searchParams.get('sheetId') || SHEETID;

	if (!sheetId) {
		error(400, 'No sheet id provided.');
	}

	const sheet = await Sheets.load(sheetId);

	return json(sheet);
}
