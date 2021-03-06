<?php $this->element("Risto.layout_modal_edit", array('title'=>'Categoria'));?>

<div class="categorias index content-white">

    <?php echo $this->Html->link(__('Crear %s', __('Categoria')), array('admin'=>true,'plugin'>'productos', 'controller'=> 'categorias', 'action'=>'edit'), array('class'=>'btn btn-success btn-lg pull-right btn-add')); ?>

    <h2><?php echo __('Categorias');?></h2>

<div class="row">
<?php echo $this->Form->create('Categoria', array('url' => array('controller' => 'categorias', 'action' => 'index'))); ?>

<div class="col-xs-6 col-sm-6 col-md-6"> <?php echo $this->Form->input('name', array('placeholder' => 'Nombre de la categoria', 'class' => 'form-control', 'label' => false)); ?> </div>

<div class="col-xs-6 col-sm-6 col-md-6"> <?php echo $this->Form->end(array('label' => 'Buscar', 'class' => 'btn btn-primary')); ?> </div>

</div>
    

    <?php echo $this->Html->link('Reordenar Alfabeticamente',array('action'=>'reordenar'), array('class'=>'btn btn-sm btn-warning'));?>

    <br>


    <table class="table">
        <th><?php echo __('#ID'); ?></th>
        <th><?php echo __('Imagen'); ?></th>
        <th><?php echo __('Nombre'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
        <?php
        foreach($categorias as $catId => $catName){
        ?>
        <tr>
            <td><?php echo "#$catId";?></td>
            <td>
                <?php

                if( !empty($imagenes[$catId])) {
                        echo $this->Html->imageMedia( $imagenes[$catId],array('height'=>'64px;'));
                }
                ?>
            </td>
            <td><?php echo "$catName";?></td>
            <td class="actions btn-group" align="left">
                <?php echo $this->Html->link(__('Editar'), array('action'=>'edit', $catId), array('class'=>'btn btn-default btn-edit')); ?>
                <?php echo $this->Html->link(__('Borrar'), array('action'=>'delete', $catId), array('class'=>'btn btn-danger'), null, sprintf(__('Seguro que querés borrar la categoria # %s?'), $catName)); ?>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>
