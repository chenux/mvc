
<?php AppHelper::add_resource('www/js/modules/%MODULE%/%CONTROLLER%.js', 'js') ?>
<?php AppHelper::add_resource('www/css/modules/%MODULE%/%CONTROLLER%.css', 'css') ?>

<?php echo WidgetHelper::window('%MODULE%_form', '%MODULE%-window-form') ?>
<?php echo WidgetHelper::window('%MODULE%_show', '%MODULE%-window-show') ?>

<div class="%MODULE%-index module-index" id="module_%MODULE%">

	<!-- Mensaje principal -->
	<!-- <div id="message_%MODULE%" style="display: none;"></div> -->

	<!-- Caja para los filstros -->
	<div id="box_filters_%MODULE%" class="module-filters">

		<form id="filters_%MODULE%" method="post">
			<?php echo HTMLHelper::hidden('module', '%MODULE%') ?>
			<?php echo HTMLHelper::hidden('controller', '%CONTROLLER%') ?>
			<?php echo HTMLHelper::hidden('action', 'table') ?>
			<?php echo HTMLHelper::hidden('page', $request->get('page', 1)) ?>
		</form>

	</div>

	<div class="theme-module-right">
		<!-- Caja para los botones -->
		<div class="theme-module-toolbar">
			<div class="theme-module-buttons" id="mod_tool_%MODULE%">
				<?php echo WidgetHelper::button_add() ?>
				<?php echo WidgetHelper::button_edit() ?>
				<?php echo WidgetHelper::button_remove() ?>
			</div>
			<div class="theme-clearfix"></div>
		</div>
		<div>

		<!-- Caja para la tabla -->
		<div class="theme-table-box">

			<h1 style="margin-left: 30px;">Todo</h1>
			<div class="theme-table-scroll">
				<div id="table_%MODULE%" class="theme-table"></div>
				<?php echo WidgetHelper::spinner('table_%MODULE%') ?>
				<div id="message_service_%MODULE%" style="display: none; text-align: center"></div>
			</div>

		</div>
	</div>
</div>
