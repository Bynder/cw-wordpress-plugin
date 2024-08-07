<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<# if ( data.statuses.length ) { #>
<select class="gc-default-mapping-select gc-select2" data-column="gc_status" data-id="{{ data.id }}" name="gc_status">
	<option data-color="" data-description=""
	<# if ( ! data.status.id ) { #>selected="selected"<# } #> value=""><?php esc_html_e( 'Unchanged', 'content-workflow-by-bynder' ); ?></option>
	<# _.each( data.statuses, function( status ) { #>
	<option data-color="{{ status.color }}" data-description="{{ status.description }}"
	<# if ( status.id === data.status.id ) { #>selected="selected"<# } #> value="{{ status.id }}">{{ status.display_name
	}}</option>
	<# }); #>
</select>
<# } else { #>
<span data-id="{{ data.id }}" data-item="{{ data.item }}" data-mapping="{{ data.mapping }}">
		<?php esc_html_e( 'N\A', 'content-workflow-by-bynder' ); ?>
	</span>
<# } #>
<?php
// echo "<# console.log( 'data', data ); #>";
