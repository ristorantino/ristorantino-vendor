<?php

App::uses('ClassRegistry', 'Utility');
App::uses('Printaitor', 'Printers.Utility');

class FiscalPrint 
{

	private static function __getFiscalPrinterId () {
		return Configure::read('Printers.fiscal_id');       
	}



	/**
	*
	*
	*
	*
	*
	**/
	public static function  cierre( $type = "x"){
		if ( strtolower( $type ) == 'z' ) {
			$viewname = 'cierre_z';
		} else {
			$viewname = 'cierre_x';
		}

		$send = Printaitor::send(array(),
				self::__getFiscalPrinterId(),
				$viewname // user vista comandas.ctp
			);

		return $send;
	}



	/**
	*
	*	@param $numero_ticket
	*	@param @importe
	*	@param @tipo
	*	@param @descripcion
	*
	*
	*
	**/
	public static function imprimirNotaDeCredito ( $numero_ticket, $importe, $tipo, $descripcion, $cliente = array() ) {
        
		$send = Printaitor::send(array(
				'numero_ticket' => $numero_ticket,
				'importe' => $importe,
				'tipo_factura' => $tipo,
				'descripcion' => $descripcion,
				'cliente' => $cliente,
				),
				self::__getFiscalPrinterId(),
				'nota_de_credito' // user vista comandas.ctp
			);

		return $send;
	}



	/**
	*
	*
	*
	*
	*
	**/
	public static function imprimirTicketMesa ( $mesaId ) {
		$Mesa = ClassRegistry::init('Mesa.Mesa');

        $send = Printaitor::send( $Mesa->getFullDataForTicket( $mesaId ),
				self::__getFiscalPrinterId(),
				'ticket' // user vista comandas.ctp
			);

        return $send;
	}
}
