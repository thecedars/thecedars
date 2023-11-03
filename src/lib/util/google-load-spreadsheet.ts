import { JWT } from 'google-auth-library';
import { GoogleSpreadsheet } from 'google-spreadsheet';
import { googleAuthConfig } from './google-auth';

let serviceAccountAuth: JWT;

export async function googleLoadSpreadsheet(id = '') {
	if (!id) throw new Error('googleLoadSpreadsheet id is falsey');
	if (!serviceAccountAuth) {
		const creds = googleAuthConfig();

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
