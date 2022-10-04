import React from 'react';

import Page from '../app/page';

export default function Info() {
	return (
		<Page title="Info">
			<>
				<h2>{YEAR} Annual Dues</h2>

				<p>
					{YEAR} annual dues are payable by February 15, {YEAR}.
					Please mail your check to:
					<br />
					The Cedars Homes Association
					<br />
					P.O. Box 14571
					<br />
					Lenexa, KS. 66285-4571
					<br />
					You may <a href="/contact-us">email</a> us with any
					questions.
				</p>

				<h2>{YEAR} Budget</h2>

				<p>
					<a href="/budget-2022">
						Click here to view the detailed budget.
					</a>
				</p>

				<h2 id="trash">The Cedars – Trash and Recycling</h2>

				<img src="/images/kc-disposal.jpg" alt="" className="db" />

				<h3>Lenexa Special Trash Programs</h3>

				<h4>Bulky Item Pickup</h4>

				<p>
					Bulky items include televisions, couches, chairs, tables,
					mattress, beds, frames, furniture – anything but appliances
					and construction debris such as rocks or dirt.
				</p>

				<p>
					Note: Appliances or items with motors in them are not
					included. Contact&nbsp;
					<a href="http://recyclespot.org">recyclespot.org</a>
					&nbsp;for disposing of appliances.
				</p>

				<p>
					The city provides&nbsp;
					<a href="http://www.ci.lenexa.ks.us/publicworks/dumpster_program.html">
						Dumpster Weekends
					</a>
					&nbsp;for Lenexa’s citizens as an opportunity to bring
					material they wish to dispose of at the city’s Public Works
					Operations facility at 7700 Cottonwood (enter from 79th
					Street, across from Mill Creek Elementary School) from 8
					a.m. – 5 p.m.
				</p>
			</>
		</Page>
	);
}

const YEAR = new Date().getFullYear();
