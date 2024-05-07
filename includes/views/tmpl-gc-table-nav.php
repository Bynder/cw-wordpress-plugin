<div class="tablenav-pages one-page">
	<span class="displaying-num"><span class="gc-item-count">{{ data.count }}</span> <?php _e( 'items', 'content-workflow' ); ?></span>
	<# if ( data.selected ) { #>
	<strong class="selected-num">| <span class="gc-item-count">{{ data.selected }}</span> <?php _e( 'selected', 'content-workflow' ); ?></strong>
	<# } #>
</div>
<br class="clear">
