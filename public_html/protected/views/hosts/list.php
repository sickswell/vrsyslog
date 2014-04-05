<?php $this->breadcrumbs=array('Hosts',);?>

<?php echo TbHtml::pageHeader('Hosts', 'log summary information'); ?>

<ul class="thumbnails">
	<?php foreach ($model['hosts_table'] as $row) { ?>
	<li class="span3">
		<div class="thumbnail">
    	<?php echo TbHtml::quote(TbHtml::link($row['FromHost'], array("/hosts/view&host=".$row['FromHost'])), array('source' => $row['Total'],'cite' => 'logs',)); ?>
		<?php 
			$danger = round((($row[0] + $row[1] + $row[2] + $row[3]) / $row['Total']) * 100);
			$warning = round(($row[4] / $row['Total']) * 100);
			$success = round(($row[5] / $row['Total']) * 100);
			$info = round((($row[6] + $row[7]) / $row['Total']) * 100);
			echo TbHtml::stackedProgressBar(array(
				array('color' => TbHtml::PROGRESS_COLOR_DANGER, 'width' => $danger),
				array('color' => TbHtml::PROGRESS_COLOR_WARNING, 'width' => $warning),
				array('color' => TbHtml::PROGRESS_COLOR_SUCCESS, 'width' => $success),
				array('color' => TbHtml::PROGRESS_COLOR_INFO, 'width' => $info),
			)); 
		?>
    	</div>
	</li>
	<?php } ?>
</ul>