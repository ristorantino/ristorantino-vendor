<?php

/**
 * Afip Web Services exception - usado para recibir errores de la afip
 *
 * @package       Cake.Error
 */
class AfipWsException extends CakeException {

	protected $_messageTemplate = 'Error del WS Afip: %s';

//@codingStandardsIgnoreStart
	public function __construct($message, $code = 404) {
		parent::__construct($message, $code);
	}
//@codingStandardsIgnoreEnd

}