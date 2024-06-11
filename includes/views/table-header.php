<th scope="col" class="gc-field-th sortable {{ data.sortDirection }} <# if ( '<?php echo esc_attr($this->get( 'sort_key' )); ?>' === data.sortKey ) { #>sorted <# } #>">
	<a href="#" data-id="<?php echo esc_attr($this->get( 'sort_key' )); ?>">
		<span><?php echo esc_html($this->get( 'label' )); ?></span><span class="sorting-indicator"></span>
	</a>
</th>
