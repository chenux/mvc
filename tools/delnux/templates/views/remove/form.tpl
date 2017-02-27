<div class="theme-window-toolbar">
	<div class="theme-window-title"><?php echo $title ?></div>
    <div class="theme-window-buttons" id="win_tool_service">
        <?php echo WidgetHelper::button_remove() ?>
        <?php echo WidgetHelper::button_cancel() ?>
    	<div class="theme-clearfix"></div>
    </div>
    <div class="theme-clearfix"></div>
</div>


<form id="form_%MODULE%" action="#">

	<?php echo HTMLHelper::hidden('module', '%MODULE%') ?>
	<?php echo HTMLHelper::hidden('action', 'delete') ?>
	<?php echo HTMLHelper::hidden('controller', '%CONTROLLER%') ?>
	<?php echo HTMLHelper::hidden('id', $row->id) ?>

	<div class="form-table">
		<div class="form-table-row">
			<div class="form-table-cell">¿Está seguro que quiere borrar el siguiente elemtno?</div>
		</div>
		<div class="form-table-row">
			<div class="form-table-cell"><?php echo $row->id ?></div>
		</div>
	</div>

</form>

