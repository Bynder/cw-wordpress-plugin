<div class="gc-auth-enabled">
	<p>
		<?php
		$message = __( 'It appears you have enabled <a href="http://www.htaccesstools.com/htaccess-authentication/">HTTP authentication</a> for this site.', 'content-workflow-by-bynder' );
		echo wp_kses_post( $message );
		?>
		<br>
		<?php esc_attr_e( 'Please enter the authentication username and password in order for this plugin to work.', 'content-workflow-by-bynder' ); ?>
	</p>
	<p class="description">
		<?php esc_attr_e( 'If you\'re not sure what this is, please contact your site adminstrator.', 'content-workflow-by-bynder' ); ?>
	</p>
</div>
