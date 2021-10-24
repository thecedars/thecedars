/* eslint-disable no-console */

const archiver = require( 'archiver' );
const fs = require( 'fs' );
const path = require( 'path' );
const glob = require( 'glob' );
const themeFolder = 'the-cedars';

const excludes = [
	'_bundle.js',
	'.gitlab-ci.yml',
	'.DS_Store',
	'.env',
	'.eslintrc',
	'.git',
	'.gitattributes',
	'.github',
	'.gitignore',
	'.stylelintrc.json',
	'.travis.yml',
	'.map',
	'.md',
	'.zip',
	'composer.json',
	'composer.lock',
	'node_modules',
	'package-lock.json',
	'package.json',
	'phpcs.xml.dist',
	'README.md',
	'sass',
	'webpack.config.js',
	'yarn.lock',
	'plugins',
	path.join( 'js', 'src' ),
];

const blockFiles = glob.sync( path.normalize( 'js/blocks/**/*.*' ), {} );
blockFiles.forEach( ( f ) => {
	if ( ! f.includes( '.json' ) ) {
		excludes.push( path.normalize( f ) );
	}
} );

function start() {
	const zip = archiver( 'zip', {
		zlib: { level: 9 },
	} );

	const output = fs.createWriteStream(
		path.resolve( `${ themeFolder }.zip` )
	);

	zip.pipe( output );

	traverseDirectoryTree( process.cwd() );

	zip.finalize();

	output.on( 'close', function () {
		console.log(
			`Created ${ path.resolve(
				`${ themeFolder }.zip`
			) } of ${ zip.pointer() } bytes`
		);
	} );

	/**
	 * Recursively traverse the directory tree and append the files to the archive.
	 *
	 * @param {string} directoryPath - The path of the directory being looped through.
	 */
	function traverseDirectoryTree( directoryPath ) {
		const files = fs.readdirSync( directoryPath );
		for ( const i in files ) {
			if ( files[ i ] !== `${ themeFolder }.zip` ) {
				const currentPath = path.normalize(
					directoryPath + '/' + files[ i ]
				);
				const stats = fs.statSync( currentPath );
				const relativePath = path.relative(
					process.cwd(),
					currentPath
				);
				if ( stats.isFile() && ! excludes.includes( relativePath ) ) {
					zip.file( currentPath, {
						name: path.join( themeFolder, relativePath ),
					} );
				} else if (
					stats.isDirectory() &&
					! excludes.includes( relativePath )
				) {
					traverseDirectoryTree( currentPath );
				}
			}
		}
	}
}

start();
