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

class Status extends AppModel
{
	public $useTable = 'status';

		public $validate = array(
		'title' => array(
			'notEmpty' => array(
				'rule'	=> 'notEmpty'),
			'unique'   => array(
				'rule'	=> 'isUnique',
				'message' => 'Un statut porte déjà ce nom.')
		),
		'help' => array(
			'rule' => 'notEmpty',
		),
		'color' => array(
			'rule' => 'notEmpty',
		)
	);

	public function getSpecialStates()
	{
		$specials = array(
			'new' => __('Nouvelle commande'),
			'sent' => __('Commande envoyée'),
			'paid' => __('Commande soldée'),
			'renew' => __('Commande à renouveler'),
			'reject' => __('Commande rejetée'),
			'tobevalidated' => __('Commande à valider'),
			'peb' => __('Livre en PEB'),
			);

		return $specials;
	}
}

?>