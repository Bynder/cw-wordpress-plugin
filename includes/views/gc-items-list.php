<a href="#" class="gc-reveal-items dashicons-before dashicons-arrow-right description <?php echo esc_attr($this->get( 'class')); ?>"><?php esc_html_e( 'Sample of Items', 'content-workflow-by-bynder' ); ?> </a>
<ul class="<?php echo esc_attr($this->get( 'class')); ?> gc-reveal-items-list hidden">
	<?php foreach ( $this->get( 'items' ) as $item ) : ?>
	<li><a href="<?php echo esc_url($this->get( 'item_base_url')); ?><?php echo esc_attr( $item->id ); ?>" target="_blank"><?php echo esc_attr( $item->name ); ?></a></li>
	<?php endforeach; ?>
</ul>
