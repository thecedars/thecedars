import fs from 'node:fs';

import appRoot from 'app-root-path';
import { JWT } from 'google-auth-library';
import { GoogleSpreadsheet } from 'google-spreadsheet';

let serviceAccountAuth: JWT;

export async function googleLoadSpreadsheet(id = '') {
	if (!id) throw new Error('googleLoadSpreadsheet id is falsey');
	if (!serviceAccountAuth) {
		const file = await fs.promises.readFile(appRoot + '/auth.json');
		const creds = JSON.parse(file.toString());

		serviceAccountAuth = new JWT({
			email: creds.client_email,
			key: creds.private_key,
			scopes: ['https://www.googleapis.com/auth/spreadsheets']
		});
	}

	const doc = new GoogleSpreadsheet(id, serviceAccountAuth);
	await doc.loadInfo();
	const sheet = doc.sheetsByIndex[0];
	const rows = await sheet.getRows();

	return rows.map((row) => row.toObject());
}
