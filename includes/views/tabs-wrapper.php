<div class="gc-template-tab-group">

	<h5 class="nav-tab-wrapper gc-nav-tab-wrapper">
	<?php foreach ( $this->get( 'tabs' ) as $tab_id => $tab ) : ?>
		<a href="#<?php echo esc_attr( $tab['id'] ); ?>" class="nav-tab <?php echo esc_attr( $tab['nav_class'] ?? '' ); ?>"><?php echo esc_html($tab['label']); ?></a>
	<?php endforeach; ?>
	</h5>

	<?php $this->output( 'before_tabs_wrapper' ); ?>

	<?php foreach ( $this->get( 'tabs' ) as $tab_id => $tab ) : ?>
		<fieldset class="gc-template-tab <?php echo esc_attr($tab['tab_class'] ?? ''); ?>" id="<?php echo esc_attr( $tab['id'] ); ?>">
		<legend class="screen-reader-text"><?php echo esc_html($tab['label']); ?></legend>
		<?php echo esc_html($tab['content']); ?>
		</fieldset>
	<?php endforeach; ?>

	<?php $this->output( 'after_tabs_wrapper' ); ?>

</div>
