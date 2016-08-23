<?php
App::uses('ComprasAppController', 'Compras.Controller');
/**
 * Pedidos Controller
 *
 */
class PedidosController extends ComprasAppController {


	public function index() {
		$pedidos = $this->Paginator->paginate();
		$this->set(compact('pedidos'));     

	}
	


	public function pendientes() {
		$pedidos = $this->Pedido->PedidoMercaderia->find('all', array(
			'conditions' => array(
					'PedidoMercaderia.pedido_id IS NULL'
				),
			'contain' => array(
				'Mercaderia'=> array('Proveedor', 'Rubro'=>'Proveedor'),
				'Pedido'=>array('User'),
				'UnidadDeMedida',
				),
			'order' => array('PedidoMercaderia.created'=>'DESC'),
		));

		$pedPorRubro = array();
		foreach ($pedidos as $p) {			
			$rubroId = !empty($p['Mercaderia']['Rubro']['id']) ? $p['Mercaderia']['Rubro']['id'] : 0;
			$pedPorRubro[$rubroId]['Rubro'] = $p['Mercaderia']['Rubro'];
			$pedPorRubro[$rubroId]['PedidoMercaderia'][] = $p;
		}
		$pedidos = $pedPorRubro;

		$this->set(compact('pedidos', 'pedidoEstados'));
	}



	public function form ( $id = null ) {
		if ( $this->request->is(array('post', 'put'))) {

			$pedidoLimpio = $this->Pedido->PedidoMercaderia->limpiarPedidosSinCant($this->request->data['PedidoMercaderia'] );
	 
	        if ( $pedidoLimpio ) {              
	       		$pedido = $this->request->data['Pedido'];
	       		$pedido['PedidoMercaderia'] = $pedidoLimpio;

	       		if ( $this->Pedido->saveAll($pedido) ) {

		                $this->Session->setFlash('Se ha guardado correctamente un nuevo pedido');
		                //ReceiptPrint::imprimirPedidoCompra($this->Pedido);
	            } else {
	                debug($pedidoLimpio);
	                debug($this->Pedido->validationErrors);
	                debug($this->Pedido->PedidoMercaderia->validationErrors);
	                debug($this->Pedido->PedidoMercaderia->Mercaderia->validationErrors);

	       			$this->Session->setFlash('Error, no se puedo guardar la Órden de Compra', 'Risto.flash_error');
	       		}
	        } else {
	            $this->Session->setFlash('Error, La Órden de Compra quedó vacía, o sea, no se seleccionaron cantidades', 'Risto.flash_error');
	        }
		} else if (!empty($id)){
			$this->Pedido->id = $id;
			$this->Pedido->contain(array(
					'Proveedor',
					'PedidoMercaderia'=>'Mercaderia',

				));
			$this->request->data = $this->Pedido->read();
			$pedidoMercaderias = array();
			foreach($this->request->data['PedidoMercaderia'] as $pm ) {
				$pedidoMercaderias[] = array(
					'PedidoMercaderia'=>$pm,
					'Mercaderia'	  =>$pm['Mercaderia']
					);
			}
		}



        $unidadDeMedidas = $this->Pedido->PedidoMercaderia->UnidadDeMedida->find('list');
        $mercaderias = $this->Pedido->PedidoMercaderia->Mercaderia->find('list');
        $proveedores = $this->Pedido->Proveedor->find('list');
        $mercaUnidades = $this->Pedido->PedidoMercaderia->Mercaderia->find('list', array('fields'=> array('id', 'unidad_de_medida_id')));
        $this->set(compact('mercaderias', 'unidadDeMedidas', 'mercaUnidades', 'proveedores', 'pedidoMercaderias'));
	}


	public function create () {
		$provs = $pedidoMercaderias = array();
		if ( $this->request->is(array('put', 'post')) ) {

			// filtrar los checkbox que vinieron vacios. 
			// seleccionar solo las mercaderias_id que tengan ID 
			$mercasId = array_filter( $this->request->data['Pedido']['mercaderia_id'], function( $item){
				return (boolean) $item;
			} );

			// buscar las mercaderias que vinieron seleccionadas
			$pedidoMercaderias = $this->Pedido->PedidoMercaderia->find('all', array(
				'conditions' => array(
						'PedidoMercaderia.id' => $mercasId
					),
				'contain' => array(
						'Mercaderia' => array(
							'Rubro.Proveedor',
							'Proveedor',
							'UnidadDeMedida',
							),
					),
				));

			// filtrar los proveedores involucrados
			$provs = $this->Pedido->PedidoMercaderia->getProveedoresInvolucrados($pedidoMercaderias);

			$this->request->data = null;
			if (!empty($provs)) {
				$this->request->data['Pedido']['proveedor_id'] = $provs[0];
			}
		}

		$proveedoresList = $this->Pedido->PedidoMercaderia->Mercaderia->Proveedor->find('list');
		if (empty($provs)) {
			$proveedores = $proveedoresList;
		} else {
			$recomendados = $this->Pedido->PedidoMercaderia->Mercaderia->Proveedor->find('list', array(
					'conditions' => array(
							"Proveedor.id" => $provs,
						)
				));
			$proveedores = array(
				'Recomendados' => $recomendados,
				'Todos' => $proveedoresList
				);
		}
		$unidadDeMedidas = $this->Pedido->PedidoMercaderia->UnidadDeMedida->find('list');
        $mercaderias = $this->Pedido->PedidoMercaderia->Mercaderia->find('list');
        $mercaUnidades = $this->Pedido->PedidoMercaderia->Mercaderia->find('list', array('fields'=> array('id', 'unidad_de_medida_id')));
        $this->set(compact('mercaderias', 'unidadDeMedidas', 'mercaUnidades', 'proveedores', 'pedidoMercaderias'));


        $this->render('form');
	}


	public function imprimir ( $id ) {
		$this->Pedido->id = $id;
		ReceiptPrint::imprimirPedidoCompra($this->Pedido);
		$this->Session->setFlash( __( "Se envió a imprimir la Órden de Compra #", $id ));
		$this->redirect($this->referer() );
	}

	public function view ( $id ) {
		$pedido = $this->Pedido->find('first', array(
			'conditions'=>array('Pedido.id'=>$id),
			'contain' => array(
				'PedidoMercaderia'=> array(
					'Mercaderia'=>array('Proveedor'),
					'UnidadDeMedida',
					'PedidoEstado',
					'Proveedor',
					)
				)
			));

		$this->set('pedido', $pedido);
	}


	public function delete($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for Órden de Compra', true));
            $this->redirect( $this->referer() );
        }
        if ($this->Pedido->delete($id)) {
            $this->Session->setFlash(__('Órden de Compra eliminada correctamente', true));
            if ( !$this->request->is('ajax') ) {
                $this->redirect($this->referer() );
            }
        }
        $this->Session->setFlash(__('La Órden de Compra no se puede eliminar. Reintente.', true));
        $this->redirect($this->referer() );
    }

}
