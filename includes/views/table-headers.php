<?php foreach ( $this->get( 'headers' ) as $sort_key => $label ) : ?>
	<?php
	echo wp_kses_post(new self(
		'table-header',
		array(
			'sort_key' => $sort_key,
			'label'    => $label,
		)
	));
	?>
	<?php
endforeach;
