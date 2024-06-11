<th scope="row" class="gc-check-column">
	<label class="screen-reader-text" for="cb-select-{{ data.id }}"><?php esc_html_e( 'Select Another Item', 'content-workflow-by-bynder' ); ?></label>
	<input id="cb-select-{{ data.id }}" type="checkbox" <# if ( data.checked ) { #>checked="checked"<# } #> name="import[]" value="{{ data.id }}">
</th>
<td class="gc-status-column">
	<?php echo wp_kses_post(new self( 'underscore-data-status' )); ?>
</td>
<td>
	<a href="<?php esc_url($this->get( 'url' )); ?>item/{{ data.item }}" target="_blank">{{ data.itemName }}</a>
</td>
<td>
	<?php echo wp_kses_post(new self( 'underscore-data-updated' )); ?>
</td>
<td>
	<?php echo wp_kses_post(new self( 'underscore-data-mapping-name' )); ?>
</td>
<td class="gc-item-wp-post-title">
	<# if ( data.editLink ) { #><a href="{{{ data.editLink }}}"><# } #>
	<# if ( '&mdash;' === data.post_title ) { #>
		&mdash;
	<# } else { #>
		{{{ data.post_title }}}
	<# } #>
	<# if ( data.editLink ) { #></a><# } #>
</td>
<?php
	// echo "<# console.log( 'data', data ); #>";
