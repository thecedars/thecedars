import React, { lazy, Suspense, useMemo } from 'react';

import { Route, Routes } from 'react-router-dom';

import Footer from './footer.js';
import Header from './header.js';
import myRoutes from './routes.json';

export default function App() {
	const myRoutesExpanded = useMemo(() => {
		let _r = [];

		for (const route of myRoutes) {
			_r.push(route);

			if (route.children) {
				for (const child of route.children) {
					_r.push(child);
				}
			}
		}

		_r = _r.filter((x, i) => _r.map((t) => t.path).indexOf(x.path) === i);

		return _r;
	}, []);

	return (
		<>
			<Header />
			<div className="main lh-copy relative z-1 flex-auto flex items-center justify-center">
				<div className="w-100 mw8 ph3 center">
					<Routes>
						{myRoutesExpanded.map((r) => {
							const Component = lazy(() =>
								import(
									`../${r.component.toLowerCase()}/page.js`
								)
							);

							return (
								<Route
									key={r.path}
									path={r.path}
									element={
										<Suspense fallback={null}>
											<Component />
										</Suspense>
									}
								/>
							);
						})}
					</Routes>
				</div>
			</div>
			<Footer />
		</>
	);
}
