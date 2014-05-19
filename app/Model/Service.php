<?php
// ***************************************************************************
// ***************************************************************************
// ***************************************************************************
// OpenIllink is a web based library system designed to manage 
// ILL, document delivery and OpenURL links
// 
// Copyright (C) 2014, Cyril Sester
// 
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
// 
// ***************************************************************************
// ***************************************************************************
// ***************************************************************************

class Service extends AppModel
{
	public $belongsTo = array('Library');
	public $hasAndBelongsToMany = array('IpRange');

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		),
	);

	public function beforeValidate($options = array())
	{
		if (!isset($this->data['IpRange']['IpRange']) || empty($this->data['IpRange']['IpRange']))
		{
			$this->invalidate('non_existent_field'); // fake validation error on Service
			$this->IpRange->invalidate('IpRange', 'veuillez sélectionner au moins une plage IP');
		}
		return true;
	}
}

?>