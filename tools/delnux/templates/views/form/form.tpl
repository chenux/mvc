<div class="theme-window-toolbar">
	<div class="theme-window-title"><?php echo $title ?></div>
	<div class="theme-window-buttons" id="win_tool_%MODULE%"">
		<?php echo WidgetHelper::button_save() ?>
		<?php echo WidgetHelper::button_cancel() ?>
		<div class="theme-clearfix"></div>
	</div>
	<div class="theme-clearfix"></div>
</div>

<form id="form_%MODULE%" action="#">

	<?php echo HTMLHelper::hidden('module', '%MODULE%') ?>
	<?php echo HTMLHelper::hidden('action', $action) ?>
	<?php echo HTMLHelper::hidden('controller', '%CONTROLLER%') ?>
	<?php echo HTMLHelper::hidden('id', $row->id) ?>

	<div class="form-table" >
%INPUTS%
	</div>

</form>