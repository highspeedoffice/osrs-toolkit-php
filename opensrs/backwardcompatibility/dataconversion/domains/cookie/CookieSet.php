<?php

namespace OpenSRS\backwardcompatibility\dataconversion\domains\cookie;

use OpenSRS\backwardcompatibility\dataconversion\DataConversion;
use OpenSRS\Exception;

class CookieSet extends DataConversion {
	// New structure for API calls handled by
	// the toolkit.
	//
	// index: field name
	// value: location of data to map to this
	//		  field from the original structure
	//
	// example 1:
	//    "cookie" => 'data->cookie'
	//	this will map ->data->cookie in the
	//	original object to ->cookie in the
	//  new format
	//
	// example 2:
	//	  ['attributes']['domain'] = 'data->domain'
	//  this will map ->data->domain in the original
	//  to ->attributes->domain in the new format
	protected $newStructure = array(
		'attributes' => array(
			"domain" => "data->domain",
			"reg_username" => "data->reg_username",
			"reg_password" => "data->reg_password",
			),
		);

	public function convertDataObject( $dataObject, $newStructure = null ) {
		$p = new parent();

		if(is_null($newStructure)){
			$newStructure = $this->newStructure;
		}

		$newDataObject = $p->convertDataObject( $dataObject, $newStructure );

		return $newDataObject;
	}
}