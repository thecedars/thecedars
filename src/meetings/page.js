import React from 'react';

import Page from '../app/page';

export default function Meetings() {
	return (
		<Page title="Meetings">
			<>
				<p>
					Board meetings are open to all members of The Cedars Homes
					Association. Meetings begin at 7:00pm and run for about an
					hour.&nbsp;
					<a href="/contact-us">
						Please RSVP to the Board President if you plan to attend
					</a>
					. You will find a map to the location of the meeting by
					clicking on the meeting location below.
				</p>

				<h2>{YEAR} Meeting Schedule</h2>

				<h4>Monday Feb 3</h4>

				<p>Dwight McQuade</p>

				<h4>Monday Mar 2</h4>

				<p>Judy Martin</p>

				<h4>Monday Apr 4</h4>

				<p>Mark Weber</p>

				<h4>Monday May 4</h4>

				<p>Mark McPherson</p>

				<h4>Monday Aug 3</h4>

				<p>Monty</p>

				<h4>Monday Sep 7</h4>

				<p>Rob Metcalf</p>

				<h4>Monday Oct 5</h4>

				<p>Mark Weber</p>

				<h4>Thursday Nov 5</h4>

				<p>Annual Meeting</p>

				<h4>Monday Dec 7</h4>

				<p>Jon Shipman</p>
			</>
		</Page>
	);
}

const YEAR = new Date().getFullYear();
