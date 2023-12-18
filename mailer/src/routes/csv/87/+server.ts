import { Sheets } from '$lib/sheets';
import { homesAlong87 } from '../homes-along-87';

export async function GET() {
	const sheetRaw = await Sheets.loadByTitle('Billing Merge List');
	const sheet = sheetRaw.filter(
		(sh) =>
			homesAlong87.includes(sh.rStreetNumber) &&
			(sh.rStreetName === 'W. 86th Terr' || sh.rStreetName === 'Greenwood Ln')
	);

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
