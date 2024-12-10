( function( api ) {

	// Extends our custom "shoes-store" section.
	api.sectionConstructor['shoes-store'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );