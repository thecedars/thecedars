import React from 'react';

import Page from '../app/page';
import Form from '../form';

export default function ContactUS() {
	return (
		<Page title="Contact Us">
			<p>
				Our Mailing address:
				<br />
				The Cedars ⋅ P.O. Box 14571 ⋅ Shawnee Mission ⋅ KS. 66285-4571
			</p>

			<p>Fill in the form below to send us an email.</p>

			<p className="fw7">
				ATTN TITLE COMPANIES: Please provide the address of the
				property, seller's name, and buyer's name.
			</p>

			<Form />
		</Page>
	);
}
