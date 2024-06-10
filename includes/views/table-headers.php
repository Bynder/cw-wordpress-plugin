<?php foreach ( $this->get( 'headers' ) as $sort_key => $label ) : ?>
	<?php
	echo esc_html(new self(
		'table-header',
		array(
			'sort_key' => $sort_key,
			'label'    => $label,
		)
	));
	?>
	<?php
endforeach;
