<div class="sui-dialog sui-fade-in" tabindex="-1" id="<?php echo esc_attr( $dialog_id ); ?>" aria-hidden="true">
	<div class="sui-dialog-overlay" data-a11y-dialog-hide=""></div>
	<div class="sui-dialog-content sui-bounce-in" aria-labelledby="dialogTitle" aria-describedby="dialogDescription" role="dialog">
		<div class="sui-box" role="document">
			<div class="sui-box-header sui-block-content-center">
				<h3 class="sui-box-title">
					<span class="branda-new"><?php esc_html_e( 'Add Text Widget', 'ub' ); ?></span>
					<span class="branda-edit"><?php esc_html_e( 'Edit Text Widget', 'ub' ); ?></span>
				</h3>
				<div class="sui-actions-right">
					<button data-a11y-dialog-hide="" type="button" class="sui-dialog-close branda-dashboard-widgets-add-cancel" aria-label=""></button>
				</div>
			</div>
			<div class="sui-box-body">
				<div class="sui-tabs sui-tabs-flushed">
					<div data-tabs="">
						<div class="branda-first-tab active"><?php esc_html_e( 'General', 'ub' ); ?></div>
						<div><?php esc_html_e( 'Visibility', 'ub' ); ?></div>
					</div>
					<div data-panes="">
                        <div class="active <?php echo esc_attr( $dialog_id ); ?>-pane-general">
<div class="sui-form-field branda-general-title">
    <label for="branda-dashboard-widgets-title" class="sui-label"><?php esc_html_e( 'Title', 'ub' ); ?></label>
    <input id="branda-dashboard-widgets-title" type="text" name="branda[title]" value="" data-required="required" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'Enter text widget title here…', 'ub' ); ?>" />
    <span class="hidden"><?php esc_html_e( 'This field can not be empty!', 'ub' ); ?></span>
</div>
<div class="sui-form-field branda-general-content">
    <label for="branda-dashboard-widgets-content-{{data.id}}" class="sui-label"><?php esc_html_e( 'Content', 'ub' ); ?></label>
<?php
$id = $dialog_id.'-content';
$args = array(
	'textarea_name' => 'branda[content]',
	'textarea_rows' => 9,
	// 'textarea_placeholder' => esc_attr_e( 'Add your text widget content here…', 'ub' ),
	'teeny' => true,
);
wp_editor( '', $id, $args );
?>
</div>
                        </div>
						<div class="<?php echo esc_attr( $dialog_id ); ?>-pane-visibility"></div>
					</div>
				</div>
				<input type="hidden" name="branda[id]" value="new" />
				<input type="hidden" name="branda[nonce]" value="" />
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost branda-cancel" type="button" data-a11y-dialog-hide=""><?php esc_html_e( 'Cancel', 'ub' ); ?></button>
				<button class="sui-button branda-dashboard-widgets-save branda-save" type="button">
					<span class="sui-loading-text">
						<span class="branda-new"><i class="sui-icon-check"></i><?php esc_html_e( 'Add', 'ub' ); ?></span>
						<span class="branda-edit"><?php esc_html_e( 'Update', 'ub' ); ?></span>
					</span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
</div>
