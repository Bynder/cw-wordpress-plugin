<hr>
<div class="gc-profile">
	<img src="<?php $this->output( 'avatar' ); ?>" class="gc-avatar">
	<div>
		<h3 class="gc-hello"><?php printf( esc_html__( 'Hello %s!', 'content-workflow' ), $this->get( 'first_name' ) ); ?></h3>
		<div><?php $this->output( 'message' ); ?></div>
	</div>
</div>
<hr>
<p><?php printf( __( 'For more information: <a href="%s" target="_blank">https://www.bynder.com/en/products/content-workflow/</a>.', 'content-workflow' ), 'https://www.bynder.com/en/products/content-workflow/' ); ?></p>
