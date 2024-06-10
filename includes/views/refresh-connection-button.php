<?php
$data = array(
	'redirectUrl' => $this->get( 'redirect_url' ),
);
wp_localize_script('redirect_script', 'redirectData', $data);
?>
<small><a href="<?php echo esc_url($this->get( 'flush_url' )); ?>" class="button dashicons dashicons-controls-repeat gc-refresh-connection" title="<?php esc_attr_e( 'Refresh data from Content Workflow?', 'content-workflow-by-bynder' ); ?>"></a></small>
