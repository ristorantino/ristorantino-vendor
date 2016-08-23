<?php
App::uses('ComprasAppModel', 'Compras.Model');
/**
 * PedidoMercaderia Model
 *
 * @property Pedido $Pedido
 * @property PedidoEstado $PedidoEstado
 * @property MedidaUnidad $MedidaUnidad
 */
class PedidoMercaderia extends ComprasAppModel {


	public $order = array('PedidoMercaderia.created'=>'DESC');


	public $actsAs = array( 'Containable', 'Search.Searchable');



	public $filterArgs = array(		
        'pedido_id' => array(
            'type' => 'value',    
            ),
        'mercaderia_id' => array(
            'type' => 'value',
            ),
        'pedido_estado_id' => array(
            'type' => 'value',
            ),
        'unidad_de_medida_id' => array(
            'type' => 'value',
            ),
        'proveedor_id' => array(
            'type' => 'value',
            'field' => 'Mercaderia.proveedor_id'
            ),
        'created_by' => array(
            'type' => 'value',
            'field' => 'Pedido.created_by'
            ),
        );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'pedido_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pedido_estado_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'medida_unidad_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cantidad' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pedido' => array(
			'className' => 'Compras.Pedido',
			'foreignKey' => 'pedido_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Proveedor' => array(
			'className' => 'Account.Proveedor',
			'foreignKey' => 'proveedor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PedidoEstado' => array(
			'className' => 'Compras.PedidoEstado',
			'foreignKey' => 'pedido_estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UnidadDeMedida' => array(
			'className' => 'Compras.UnidadDeMedida',
			'foreignKey' => 'unidad_de_medida_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Mercaderia' => array(
			'className' => 'Compras.Mercaderia',
			'foreignKey' => 'mercaderia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	/**
	 * filtrar los proveedores involucrados retornando un listado de ID's
	 * 
	 * 
	 * @param array $pedidoMercaderias array del find de PedidoMercaderia
	 * @return array con un list de id's de proveedores
	 * 
	 **/
	public function getProveedoresInvolucrados( $pedidoMercaderias ) {
		$provs = [];
		foreach ($pedidoMercaderias as $pm) {
			if ( !empty($pm['Mercaderia']['Proveedor']['id']) ) {
				$provs[] = $pm['Mercaderia']['Proveedor']['id'];

			}
			if ( !empty($pm['Mercaderia']['Rubro']['Proveedor']) ) {
				foreach ($pm['Mercaderia']['Rubro']['Proveedor'] as $rubro) {
					$provs[] = $rubro['id'];
				}
			}
		}
		return $provs;
	}


	/**
	 * 
	 * 
	 * 	Limpiar los pedidos recibidos con formulario
	 * 
	 * 
	 * 
	 **/
	public function limpiarPedidosSinCant ( $pedidoMercaderias ) {
		$pedidoLimpio = array();
		foreach ( $pedidoMercaderias as $pedido ) {
            if ( $pedido['cantidad'] ) {
                $mercaderia = array(
                    'id'   => empty($pedido['mercaderia_id']) ? null : $pedido['mercaderia_id'],
                    'name' => $pedido['mercaderia'],
                    'unidad_de_medida_id' => $pedido['unidad_de_medida_id'],
                    );

                if ($pedido) {
                    $pedido['Mercaderia'] = $mercaderia;
                }
                $pedidoLimpio[] = array(
                    'PedidoMercaderia' => $pedido,
                    );
            }
        }

        return $pedidoLimpio;
	}
}
