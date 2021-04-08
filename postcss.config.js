module.exports = {
	map: {
		inline: false
	},
	parser: false,
	plugins: [
		require( 'postcss-partial-import' )( {} ),
		require( 'postcss-advanced-variables' )(),
		require( 'postcss-map-get' )(),
		require( 'postcss-nested' )(),
		require( 'postcss-sort-media-queries' )( {
			sort: 'mobile-first'
		} ),
		require( 'postcss-assets' )( {
			loadPaths: [ 'src/images/' ]
		} ),
		require( 'autoprefixer' )(),
		require( 'cssnano' )()
	]
};
