<?php

App::uses('RistoTenantAppModel', 'Risto.Model');

class TipoFactura extends RistoTenantAppModel {

	public $name = 'TipoFactura';
	

	/**
	 * Display field
	 *
	 * @var string
	 */
	public $displayField = 'name';


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
             'codename' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

    public $order = 'TipoFactura.name';    




    /**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		'IvaResponsabilidad' => array(
			'className' => 'Risto.IvaResponsabilidad',
			'foreignKey' => 'tipo_factura_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
    public $actsAs = array(
        'Search.Searchable',
        'Containable',
    );
    public $filterArgs = array(
        'name' => array('type' => 'like'),
    );

}
?>