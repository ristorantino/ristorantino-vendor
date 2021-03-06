<div data-role="page" id="mesas-edit">
    <div data-role="content">
        <h1 class="center">Detalle de <?php echo Configure::read('Mesa.tituloMesa'); ?></h1>

        <div class="mesas form col-md-4 ">

                <p>
                    <span class="mesa-created">
                        Creada: 
                        <?php echo $this->Time->nice($this->request->data['Mesa']['created']) ?>
                    </span>

                    <?php if (!empty($this->request->data['Mesa']['time_cerro'])) { ?>
                        <br />
                        <span class="mesa-cerro">
                        Fecha Facturación: 
                        <?php $this->Time->nice($this->request->data['Mesa']['time_cerro']); ?>
                        </span>
                    <?php } ?>

                    <?php if (!empty($this->request->data['Mesa']['time_cobro'])) { ?>
                        <br />
                        <span class="mesa-cobro">
                        Fecha Cobro: 
                        <?php $this->Time->nice($this->request->data['Mesa']['time_cobro']); ?>
                        </span>
                    <?php } ?>
                </p>



                <?php echo $this->Form->create('Mesa', array('id'=>'MesaForm')); ?>
                    <legend><?php __('Datos Generales'); ?></legend>
                    <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('estado_id');
                    echo $this->Form->input('numero', array('label' => __('Número de %s', Configure::read('Mesa.tituloMesa') ) ));
                    echo $this->Form->input('mozo_id', array('label'=>Configure::read('Mesa.tituloMozo')));

                    echo $this->Form->input('cliente_id', array('empty'=>'Sin Cliente'));
                    ?>


                    <legend><?php __('Totales de %s', Configure::read('Mesa.tituloMesa')); ?></legend>
                    <?php
                    echo $this->Form->input('checkin', array( 'type'=>'datetime'));
                    echo $this->Form->input('checkout', array( 'type'=>'datetime'));
                    
                    echo $this->Form->input('time_cerro', array( 'type'=>'date', 'Fecha de Facturación'));
                    echo $this->Form->input('time_cobro', array( 'type'=>'date', 'label'=>'Fecha de Cobro'));


                    //if ( Configure::read("Adicion.cantidadCubiertosObligatorio")) {
                        echo $this->Form->input('cant_comensales', array('label'=> __("Cantidad de %s", Inflector::pluralize( Configure::read('Mesa.tituloCubierto') ) )));
                    //}

                    echo $this->Form->input('observation', array());

                    echo $this->Form->input('total');
                    echo $this->Form->input('subtotal', array('label'=>'Total "verdadero", o sea, de los productos sumados en caso de haber aplicado un descuento, por ejemplo'));
                    


                    echo $this->Form->submit('Guardar Cambios', array('class'=>'btn btn-primary btn-lg'));


                    echo $this->Form->end();
                    
                    echo $this->Form->postLink(__('Borrar %s', Configure::read('Mesa.tituloMesa') )
                                    , array('action' => 'delete'
                                    , $this->Form->value('Mesa.id'))
                                    , array('class' => 'btn btn-danger pull-right  btn-lg')
                                    , sprintf('Seguro que querés borrar la Número # %s?', $this->Form->value('Mesa.numero'))); 

                    ?>
        </div>



        <div class="detallesmesa col-md-4">

            <?php  if ( !empty($mesa['Mesa']['cliente_id']) ) { ?>

            <h2><?php echo Configure::read('Mesa.tituloCliente') ?></h2>

            <dl>
            <?php
                    echo "<dt>Nombre</dt>";
                    echo "<dd>" . $mesa['Cliente']['nombre'] . "&nbsp;</dd>";

                    echo "<dt>Descuento</dt>";
                    $dto = (!empty($mesa['Cliente']['Descuento']['porcentaje'])) ? $mesa['Cliente']['Descuento']['porcentaje'] : "0";
                    echo "<dd>" . $dto . "% &nbsp;</dd>";


                    echo "<dt>Iva Resp.</dt>";
                    $dto = (!empty($mesa['Cliente']['IvaResponsabilidad']['name'])) ? $mesa['Cliente']['IvaResponsabilidad']['name'] : "";
                    echo "<dd>" . $dto . "&nbsp;</dd>";
                
            ?>
            </dl>
            <?php } ?>

            
            
            <h2>Comandas</h2>
            <?php echo $this->Html->link('Crear Comanda'
                , array('plugin'=>'comanda', 'controller'=>'DetalleComandas', 'action'=>'add', $this->request->data['Mesa']['id'])
                , array('class'=>'btn btn-success'));?>

            <div class="clearfix"></div>
            <hr />


            <div class="items_mesas">

            <?php
            $totalSumado = 0;
            foreach ($items as $comanda):
                ?>
                <div class="list-group-item">                
                <?php
                     echo $this->Html->link("Re-Imprimir"
                            , array('plugin'=>'comanda', 'controller' => 'comandas', 'action' => 'imprimir', $comanda['id'])
                            , array('class'=>'small')
                            );
                    echo " &nbsp;-&nbsp; ";
                    echo $this->Html->link("Editar"
                            , array('plugin'=>'comanda', 'controller' => 'comandas', 'action' => 'edit', $comanda['id'])
                            , array('class'=>'small')
                            );
                    echo " &nbsp;-&nbsp; ";
                    echo $this->Html->link(__('Delete')
                                        , array('plugin'=>'comanda', 'controller' => 'comandas', 'action'=>'delete', $comanda['id'])
                                        , array('class'=>'small')
                                        , sprintf(__('Are you sure you want to delete # %s?'), $comanda['id']));
                    
                    echo "<br>";
                    echo "<b>Comanda #" . $comanda['id']. "  (".date('H:i, d M',strtotime($comanda['created'])).")</b><br>";
                    if ($comanda['observacion']) {
                        echo "<cite>Observacion: ";
                        echo $comanda['observacion'] . "</cite>";
                    }
                    ?>

                

                <?php foreach ($comanda['DetalleComanda'] as $detalle) : ?>
                        <div  class="list-group-item small">
                        <?php echo "Cant Pedida: " . $detalle['cant'] . ($detalle['cant_eliminada'] != '0' ? " Sacada: " . $detalle['cant_eliminada'] : '') ?>
                            <br>
                            <?php 
                            if (!empty($detalle['observacion'] )) {
                                echo "Obs: " . $detalle['observacion']."<br>";
                            }

                            ?>
                           
                        


                            <span style="color: #AD0101; font-weight: normal; font-size: 120%; <?php if (($detalle['cant'] - $detalle['cant_eliminada']) == 0) echo "text-decoration: line-through;" ?> ">
                            <?php echo "Prod: " . (!empty($detalle['Producto']['name']) ? $detalle['Producto']['name'] : '') . " [p-u $ " . $detalle['Producto']['precio'] . "]" ?>
                            </span>

                             <?php
                             echo $this->Html->link("Editar"
                                    , array('plugin'=>'comanda','controller' => 'DetalleComandas', 'action' => 'edit', $detalle['id'])
                                    , array('class'=>'small')
                                    );
                             echo " - ";
                             echo $this->Html->link(__('Delete')
                                    , array('plugin'=>'comanda', 'controller' => 'DetalleComandas', 'action'=>'delete', $detalle['id'])
                                    , array('class'=>'small')
                                    , sprintf(__('Are you sure you want to delete # %s?'), $detalle['id']));
                            ?>


                                <?php
                                if (count($detalle['DetalleSabor']) > 0) {
                                    $primero = true;
                                    echo "<cite>";
                                    echo "(";
                                    foreach ($detalle['DetalleSabor'] as $sabor) {
                                        if (!$primero) {
                                            echo ", ";
                                        }
                                        $primero = false;
                                        echo $sabor['Sabor']['name'] . ($sabor['Sabor']['precio'] != '0' ? " [ $" . $sabor['Sabor']['precio'] . "]" : '');

                                        $totalSumado += ($detalle['cant'] - $detalle['cant_eliminada']) * $sabor['Sabor']['precio'];
                                    }
                                    echo ")";
                                    echo "</cite>";
                                }

                                $totalSumado += ($detalle['cant'] - $detalle['cant_eliminada']) * $detalle['Producto']['precio'];
                        ?>
                        </div>
                    <?php endforeach; ?>

                </div>

            <?php endforeach; ?>

            </div>

        </div>


        <div class="col-md-4">
            

            <div class="mesastotaledit">

                <h3>Subtotal <span class="money"><?php echo $this->Number->currency( $mesa['Mesa']['subtotal']) ?></span></h3>

                <?php
                $dto = empty($mesa['Cliente']['Descuento']['porcentaje']) ? 0 : $mesa['Cliente']['Descuento']['porcentaje'];
                if ($dto != '0') {
                    $dto = "(Dto: $dto%)";
                } else {
                    $dto = '';
                }

                ?>
                <h3>Total <span class="money"><?php echo $this->Number->currency( $mesa['Mesa']['total']) ?></span> <?php echo $dto ?></h3>
                

                <div class="clearfix"></div>

                <?php 
                $totPago = 0;
                foreach ($mesa['Pago'] as $pago) {
                    $totPago += $pago['valor'];
                }
                $faltaPagar = $mesa['Mesa']['total'] - $totPago;
                if ( $faltaPagar > 0 ) {
                    ?>
                        <h2 class="text-danger">Falta pagar <?php echo $this->Number->currency( $faltaPagar ) ?></h2>
                    <?php
                } else {
                    ?>
                        <h2 class="text-success">Pagado</h2>
                    <?php
                }
                ?>

            </div><!-- totales-->


            <div class="pagos">               
                <ul>
                <?php
                if ( !count($mesa['Pago']) ) {                    
                    ?>
                    <p class="alert alert-danger"><?php echo __( 'Esta %s aún no tiene pagos', Configure::read('Mesa.tituloMesa')) ?></p>
                    <?php
                }


                foreach ($mesa['Pago'] as $pago) {
                        ?>
                        <li>
                        <?php
                         echo  $pago['TipoDePago']['name'] . " - ";
                        $money = $this->Number->currency( $pago['valor'] );
                        echo $this->Html->link( $money, array('plugin'=>'mesa', 'controller'=>'pagos', 'action'=>'edit', $pago['id']));

                        echo " | ";

                        echo $this->Html->link( 'eliminar', array('plugin'=>'mesa', 'controller'=>'pagos', 'action'=>'delete', $pago['id'])
                                    , array('class' => '')
                                    , 'Seguro desea eliminar el pago?') ;
                    ?>
                    </li>
                    <?php
                    }
                    ?>

                </ul>

                 <?php
                echo $this->Html->link('Crear Nuevo Pago'
                            , array('plugin' => 'mesa', 'controller' => 'pagos', 'action' => 'addForMesa', $mesa['Mesa']['id'])
                            , array('class' => 'btn btn-success')
                        );
                ?>
            </div>
        </div>


    </div>

    <div class="clearfix"></div>
</div>