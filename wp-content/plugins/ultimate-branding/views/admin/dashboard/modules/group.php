<div id="branda-dashboard-widget-<?php echo esc_attr( $group ); ?>" class="sui-box sui-box-close">
	<div class="sui-box-header">
    <h3 class="sui-box-title"><?php
	$mask = '<i class="sui-icon-%s" aria-hidden="true"></i>';
	if ( preg_match( '/^dashicons/', $info['icon'] ) ) {
		$mask = '<span class="dashicons %s"></span>';
	}
	printf( $mask, esc_attr( $info['icon'] ) );
	echo esc_html( $info['title'] );
?></h3>
	</div>
	<div class="sui-box-body">
		<p><?php echo esc_html( $info['description'] ); ?></p>
	</div>
	<table class="sui-table sui-table-flushed">
		<thead>
			<tr>
				<th class="sui-table--name"><?php esc_attr_e( 'Module', 'ub' ); ?></th>
				<th class="sui-table--status"><?php esc_attr_e( 'Status', 'ub' ); ?></th>
			</tr>
		</thead>
		<tbody>
<?php
foreach ( $data['modules'] as $id => $module ) {
$this->render( 'admin/dashboard/modules/one-row', array( 'id' => $id, 'module' => $module ) );
}
?>
		</tbody>
	</table>
</div>