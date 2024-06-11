<span class="gc-status-column" data-id="{{ data.id }}" data-item="{{ data.item }}" data-mapping="{{ data.mapping }}">
<# if ( data.status.display_name ) { #>
	<div class="gc-item-status">
		<?php echo wp_kses_post(new self( 'underscore-data-status' )); ?>
	</div>
<# } else { #>
	&mdash;
<# } #>
</span>
<?php
	// echo "<# console.log( 'data', data ); #>";
