

<div class="theme-table-row">
	%HEADER%
</div>

<?php foreach($rows as $row): ?>
<div class="theme-table-row">
		<div class="theme-table-cell" style="text-align:center; width:10px"><?php echo WidgetHelper::checkbox_row($row->id) ?></div>
		%ROWS%
</div>
<?php endforeach; ?>
