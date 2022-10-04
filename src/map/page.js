import React from 'react';

import Page from '../app/page';

export default function Map() {
	return (
		<Page title="Street Map">
			<>
				<p>
					We’ve created a street map showing the homes belonging to
					the Cedars Homes Association. Homes are represented with a
					circle and a house number. The color of the circle
					represents the street the home is on. For an example, the
					orange is Greenwood Cir., the baby blue is Oakview Cir.
				</p>

				<img src="/images/map.jpg" alt="map" className="db w-100" />
			</>
		</Page>
	);
}
