<?php 

if ( !isset($pmId) ){
	throw new CakeException("debe pasar un pmId como parametro para este elemento");
} 




// llenar el this->data para el formulario
$style = '';
if ( $pmId  != '{X}') {
    $style = "display: none";   
}

?>

<div class="row row-mercaderia">

    <div class="col-md-4 col-xs-4">


	<?php 
    if ( isset( $id ) ) {
        echo $this->Form->hidden('PedidoMercaderia.'.$pmId.'.id', array(
                                'value' => $id,
            ));
    }

	echo $this->Form->hidden('PedidoMercaderia.'.$pmId.'.mercaderia_id', array(
                            'id' => 'pedido-mercaderia-id-'.$pmId,
                            'value' => !empty($mercaderia_id) ? $mercaderia_id : null,
        ));


    echo $this->Form->input('PedidoMercaderia.'.$pmId.'.mercaderia', array(
        'value' => !empty($mercaderia) ? $mercaderia : null,
        'label' => false,
        'type' => 'text',
        'class' => 'form-control typeahead addmore',
        'div' => array('class'=>'form-group has-feedback'),
        'data-options' => json_encode($unidadDeMedidas),
        'data-dom-id' => '#pedido-mercaderia-id-'.$pmId,
        'data-unidad-medida-id' => '#PedidoMercaderia'.$pmId.'UnidadDeMedidaId',
        'data-url' => Router::url(array('controller'=>'Mercaderias','action'=>'index', 'ext' => 'json')),
        'autocomplete' => 'off',
        'placeholder' => 'Mercadería',
        'data-toggle' => "tooltip",
        'title' => 'Se creará una nueva Mercadería',
        'data-placement' => "bottom",
        'after' => '<span style="display:none" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
              <span style="display:none" class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>

        '

    ));

    ?>
  
    </div>


	<div class="col-md-2 col-xs-2">

        <?php echo $this->Form->input('PedidoMercaderia.'.$pmId.'.cantidad', array(
                            'value' => !empty($cantidad) ? $cantidad : null,
                            'required' => false,
                            'class' => 'form-control',
                            'label' => false,
                            'placeholder' => 'Cantidad'
        )); ?>
    </div>
	<div class="col-md-2 col-xs-3">

    <?php 
    echo $this->Form->input('PedidoMercaderia.'.$pmId.'.unidad_de_medida_id', array(
        'value' => !empty($unidad_de_medida_id) ? $unidad_de_medida_id : null,
        'label' => false,
    ));

    ?>
    </div>


	
	<div class="col-md-4 col-xs-3">
        <?php echo $this->Form->input('PedidoMercaderia.'.$pmId.'.observacion', array(
                                            'value' => !empty($observacion) ? $observacion : null,
                                            'type'=>'text', 
                                            'placeholder'=>'Obervación', 
                                            'label'=>false)); ?>
                        
    </div>
</div>


<?php   
if ( $pmId  == '{X}') {
	$this->start('script');
		echo $this->Html->script('/compras/js/pedidos/add');
	$this->end();
}
?>