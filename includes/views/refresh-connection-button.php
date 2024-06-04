<?php
wp_enqueue_script('redirect_script', GATHERCONTENT_URL . 'assets/js/src/components/redirect.js', array(), '1.0', true);

$data = array(
	'redirectUrl' => $this->get( 'redirect_url' ),
);
wp_localize_script('redirect_script', 'redirectData', $data);
?>
<small><a href="<?php $this->output( 'flush_url', 'esc_url' ); ?>" class="button dashicons dashicons-controls-repeat gc-refresh-connection" title="<?php esc_attr_e( 'Refresh data from Content Workflow?', 'content-workflow' ); ?>"></a></small>
