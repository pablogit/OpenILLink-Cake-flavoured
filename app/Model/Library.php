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

class Library extends AppModel
{
	public $useTable = 'libraries';
	public $hasMany = 'Order';

	public $validate = array(
		'name' => array(
			'rule' => 'notEmpty',
		)
	);

	public function beforeSave($options = array())
	{
		$library = $this->findById($this->id);

		if (!empty($this->data['Library']['default']) && $this->data['Library']['default'] == 1)
		{
			$this->updateAll(array('default' => '0'), array('default' => '1'));
		}

		if($library && $library['Library']['default'] == 1 && $this->data['Library']['default'] == 0) //editing library
		{
			//Is default and trying to remove default value. Not authorized. The way to remove default is to set another one as default.
			return false;
		}
		
		return true;
	}

	public function beforeDelete($cascade = true)
	{
		$library = $this->findById($this->id);
		if($library['Library']['default'] == 1)
		{
			return false;
		}

		return true;
	}
}

?>