<div class="printers index">
	<div class="users index">
    <h2><?php echo __('Printers'); ?></h2>
    <div class="btn-group pull-right">
    <?php echo $this->Html->link(__('New printer', true), array('action'=>'add'), array('class'=>'btn btn-success btn-lg')); ?>
    </div>
	<table class="table">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('alias'); ?></th>
			<th><?php echo $this->Paginator->sort('driver'); ?></th>
			<th><?php echo $this->Paginator->sort('driver_model'); ?></th>
			<th><?php echo $this->Paginator->sort('output'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($printers as $printer): ?>
	<tr>
		<td><?php echo h($printer['Printer']['id']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['name']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['alias']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['driver']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['driver_model']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['output']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['created']); ?>&nbsp;</td>
		<td><?php echo h($printer['Printer']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $printer['Printer']['id']), array('class'=>'btn btn-default')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $printer['Printer']['id']), array('class'=>'btn btn-default')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $printer['Printer']['id']), array('class'=>'btn btn-default'), __('Are you sure you want to delete # %s?', $printer['Printer']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Printer'), array('action' => 'add')); ?></li>
	</ul>
</div>
