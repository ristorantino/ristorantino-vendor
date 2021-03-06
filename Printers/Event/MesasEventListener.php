<?php

App::uses('CakeEventListener', 'Event');
App::uses('Printaitor', 'Printers.Utility');
App::uses('FiscalPrint', 'Printers.Utility');
App::uses('ReceiptPrint', 'Printers.Utility');


/**
 * Nodes Event Handler
 *
 * @category Event
 * @package  Croogo.Nodes.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class MesasEventListener implements CakeEventListener {

/**
 * implementedEvents
 */
	public function implementedEvents() {
		return array(
			'Mesa.print' => array(
				'callable' => 'onMesaPrint',
				//'passParams' => true,
			),			
			'Mesa.AfterCerrada' => array(
				'callable' => 'onMesaCerrada',
				//'passParams' => true,
			),			
		);
	}


	public function onMesaCerrada( CakeEvent $event ) {
		$mesa_id = $event->subject()->id;
		$data = $event->data;

		if ( Configure::read( 'Mesa.imprimePrimeroRemito') == 0 ) {
			return FiscalPrint::imprimirTicketMesa( $event->subject() );
		} else {
			return ReceiptPrint::imprimirTicketMesa( $event->subject() );
		}
	}


	public function onMesaPrint( CakeEvent $event ) {
		$mesa_id = $event->subject()->id;		
		return FiscalPrint::imprimirTicketMesa( $event->subject() );
	}

}