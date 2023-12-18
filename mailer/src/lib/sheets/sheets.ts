import { GOOGLE_AUTH, SHEETID, type GoogleAuthKey } from '$lib/config.server';
import { JWT } from 'google-auth-library';
import { GoogleSpreadsheet } from 'google-spreadsheet';

interface SheetOptions {
	auth: GoogleAuthKey;
	defaultSheetId: string;
}

class SheetClass {
	serviceAccount: JWT | undefined = undefined;
	auth: GoogleAuthKey;
	defaultSheetId: string;

	constructor(options: SheetOptions) {
		this.auth = options.auth;
		this.defaultSheetId = options.defaultSheetId;
	}

	authenticate() {
		this.serviceAccount = new JWT({
			email: this.auth.client_email,
			key: this.auth.private_key,
			scopes: ['https://www.googleapis.com/auth/spreadsheets']
		});
	}

	async load(sheetId = this.defaultSheetId) {
		if (!this.serviceAccount) this.authenticate();

		const doc = new GoogleSpreadsheet(sheetId, this.serviceAccount!);
		await doc.loadInfo();
		const sheet = doc.sheetsByIndex[0];
		const rows = await sheet.getRows();

		return rows.map((row) => row.toObject());
	}
}

const Sheets = new SheetClass({ auth: GOOGLE_AUTH, defaultSheetId: SHEETID });

export default Sheets;
