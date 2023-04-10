import React from 'react';

import Page from '../app/page';
import Form from '../form';
import fields from './fields.json';

export default function Officers() {
	return (
		<Page title="Officers">
			<>
				<p>
					The 2023 Board of Directors consists of the following
					members.&nbsp;
					<a href="/contact-us">
						Please contact any Board Member with any questions or
						concerns.
					</a>
				</p>

				<p>
					Mark McPherson – President
					<br />
					Vann Martin – Vice President
					<br />
					Rob Metcalf – Treasurer
					<br />
					Judy Martin – Secretary
					<br />
					Jon Shipman&nbsp;– Website/Directory
					<br />
					Dwight McQuade – Landscaping
					<br />
					Monty Tranbarger – Member
					<br />
					Todd Pratt – Member
					<br />
					Mark Weber – Social Chair
				</p>

				<p>
					Be sure to check out the board meeting schedule. All
					meetings are open to the homeowners.
				</p>

				<p>
					<strong>
						For Title Company inquiries regarding dues status,
						please fill out the form below.
					</strong>
				</p>

				<Form {...{ fields }} />
			</>
		</Page>
	);
}
