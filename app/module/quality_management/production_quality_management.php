<?php

/**
 *
 * @author Marcin
 *
 */
namespace Module\Quality_management {

	/**
	 */
	use Module as Module;
	use Module\Quality_management as Quality_management;

	/**
	 *
	 * @author Marcin Pyrka
	 *
	 */
	class Production_quality_management extends Quality_management {

		/**
		 * @readwrite
		 */
		public $sheet;
		/**
		 *
		 * @param unknown $options
		 */
		public function __construct($options = array()) {
			/**
			 */
			parent::__construct ( $options );
		}
	}
}