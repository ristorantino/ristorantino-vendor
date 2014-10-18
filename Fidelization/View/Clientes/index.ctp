<div class="clientes index">
	<?php echo $this->Html->link(__('Crear Nuevo %s', Configure::read('Mesa.tituloCliente')), array('action'=>'add'), array('class'=>'btn btn-success btn-lg pull-right')) ?>
	<h2><?php echo Inflector::pluralize( Configure::read('Mesa.tituloCliente')) ?></h2>


	<div class"">
	<hr />
	<h4>Buscador</h4>
	<?php echo $this->Form->create('Cliente', array('formStyle'=>'inline')) ?>
            <?php echo $this->Form->input('codigo', array('placeholder'=>'Código')); ?>
            <?php echo $this->Form->input('nombre', array('required' => false, 'placeholder'=>'Nombre')); ?>
            <?php echo $this->Form->input('mail', array('placeholder'=>'Mail')); ?>
            <?php echo $this->Form->input('tipo_documento_id', array('required' => false, 'options'=>$tipoDocumentos)); ?>
            <?php echo $this->Form->input('nrodocumento', array('placeholder'=>'Nº Documento')); ?>
            <?php echo $this->Form->input('telefono', array('placeholder'=>'Teléfono')); ?>
            <?php echo $this->Form->input('iva_responsabilidad_id', array('required' => false, 'options'=>$ivaResponsabilidades)); ?>
            <?php echo $this->Form->input('descuento_id', array('options' =>$descuentos)); ?>
            <?php echo $this->Form->input('domicilio', array('placeholder'=>'Domicilio')); ?>
            <?php echo $this->Form->submit('Buscar', array('class'=>'btn btn-primary')); ?>
    <?php echo $this->Form->end() ?>
    <hr />
	</div>


	<table class="table">
            
            <thead>                

                <tr>
                    
                    
                    <th><?php echo $this->Paginator->sort('codigo'); ?></th>
                    <th><?php echo $this->Paginator->sort('nombre'); ?></th>
                    <th><?php echo $this->Paginator->sort('mail'); ?></th>
                    <th><?php echo $this->Paginator->sort('tipo_documento_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('nrodocumento'); ?></th>
                    <th><?php echo $this->Paginator->sort('telefono'); ?></th>
                    <th><?php echo $this->Paginator->sort('iva_responsabilidad_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('descuento_id'); ?></th>
                    <th><?php echo $this->Paginator->sort('domicilio'); ?></th>

                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
            </thead> 

            <tbody>
	<?php foreach ($clientes as $cliente): ?>
	<tr>
		<td><?php echo h($cliente['Cliente']['codigo']); ?></td>
		
		
		<td><?php echo h($cliente['Cliente']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['mail']); ?>&nbsp;</td>

		<td>
			<?php echo $this->Html->link($cliente['TipoDocumento']['name'], array(
				'plugin' => 'risto',
			'controller' => 'tipo_documentos', 'action' => 'view', $cliente['TipoDocumento']['id'])); ?>
		</td>

		<td><?php echo h($cliente['Cliente']['nrodocumento']); ?>&nbsp;</td>


		<td><?php echo h($cliente['Cliente']['telefono']); ?>&nbsp;</td>

		<td>
			<?php echo $this->Html->link($cliente['IvaResponsabilidad']['name'], array(
					'plugin' => 'risto',
					'controller' => 'iva_responsabilidades', 'action' => 'view', $cliente['IvaResponsabilidad']['id'])); ?>
		</td>

		<td>
			<?php echo $this->Html->link($cliente['Descuento']['name'], array('controller' => 'descuentos', 'action' => 'view', $cliente['Descuento']['id'])); ?>
		</td>
		
		<td><?php echo h($cliente['Cliente']['domicilio']); ?>&nbsp;</td>
		

		
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cliente['Cliente']['id']), array('class'=>'btn btn-default')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cliente['Cliente']['id']), array('class'=>'btn btn-default'), __('Are you sure you want to delete # %s?', $cliente['Cliente']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
