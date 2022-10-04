import React, { useState } from 'react';

import PropTypes from 'prop-types';
import { GiHamburgerMenu } from 'react-icons/gi';
import { NavLink } from 'react-router-dom';

import { ReactComponent as Logo } from './logo.svg';
import myRoutes from './routes.json';

export default function Header() {
	const [menuOpened, setMenuOpen] = useState(false);

	return (
		<div className="w-100 mw8-l ph3-l center">
			<div className="dn-l bg-black white pl2 pt2 shadow-5">
				<GiHamburgerMenu
					className="db pointer pb2"
					size="1.75em"
					onClick={() => setMenuOpen(!menuOpened)}
				/>

				{menuOpened && (
					<div>
						{myRoutes.map((r) => {
							if (!r.title) {
								return null;
							}
							return <MenuItem key={r.path} item={r} />;
						})}
					</div>
				)}
			</div>

			<div className="dn db-l">
				<div className="flex items-center justify-between w-100">
					<div>
						<NavLink to="/">
							<Logo className="mw4 h2 h-auto db" />
						</NavLink>
					</div>

					<div className="relative z-2 dn db">
						<div>
							<div className="flex items-center justify-between nowrap">
								{myRoutes.map((r) => {
									if (!r.title) {
										return null;
									}
									return <MenuItem key={r.path} item={r} />;
								})}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
}

function MenuItem({ item }) {
	const [hover, setHover] = useState(false);
	const [opened, setOpen] = useState(false);

	return (
		<div
			className="relative z-1"
			onMouseEnter={() => setHover(true)}
			onMouseLeave={() => setHover(false)}
		>
			<div className="flex items-center">
				<NavLink
					to={item.path}
					className="db-l dn no-underline pv2 pv4-l ph3-l color-inherit"
				>
					<span className="db">{item.title}</span>
				</NavLink>

				<NavLink
					to={item.path}
					className="dn-l db no-underline pv2 pv4-l ph3-l color-inherit"
					onClick={(evt) => {
						if (!opened && item.children?.length > 0) {
							evt.preventDefault();
							setOpen(!opened);
						}
					}}
				>
					<span className="db">{item.title}</span>
				</NavLink>
			</div>

			{!!item.children && opened && (
				<div className="db dn-l">
					{item.children.map((x) => {
						if (!x.title) {
							return null;
						}

						return <Child key={x.path} item={x} />;
					})}
				</div>
			)}

			{!!item.children && hover && (
				<div className="dn db-l absolute-l z-1 nt3-l">
					<div className="bg-white shadow-4-l">
						{item.children.map((x) => {
							if (!x.title) {
								return null;
							}

							return <Child key={x.path} item={x} />;
						})}
					</div>
				</div>
			)}
		</div>
	);
}

MenuItem.propTypes = {
	item: PropTypes.object.isRequired,
};

function Child({ item }) {
	if (!item.title) {
		return null;
	}

	let TagComponent = 'a';
	const TagProps = {};

	if (!item.path.includes('#')) {
		TagComponent = NavLink;
		TagProps.to = item.path;
	} else {
		TagProps.href = item.path;
	}

	return (
		<div className="relative z-1">
			<div className="flex items-center">
				<TagComponent
					{...TagProps}
					className="bg-animate no-underline pa2 pr4-l db color-inherit"
				>
					<span className="db">{item.title}</span>
				</TagComponent>
			</div>
		</div>
	);
}

Child.propTypes = {
	item: PropTypes.object.isRequired,
};
