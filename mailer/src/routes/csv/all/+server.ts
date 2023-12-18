import { Sheets } from '$lib/sheets';

export async function GET() {
	const sheet = await Sheets.loadByTitle('Billing Merge List');
	const header = Object.keys(sheet[0]);
	const headerText = '"' + header.join('","') + '"\n';

	let csvText = headerText;

	for (const row of sheet) {
		const rowArr = Object.values(row);
		csvText += '"' + rowArr.join('","') + '"\n';
	}

	const returnResponse = new Response(csvText);
	returnResponse.headers.set('content-type', 'text/csv');

	return returnResponse;
}
