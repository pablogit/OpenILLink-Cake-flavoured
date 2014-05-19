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

	$nbPending = count($pendingPeb);
	echo '<div>' . __('Vous avez %s livre(s) emprunté(s) arrivant bientôt à échéance', $nbPending) . '</div><br />';

	foreach ($pendingPeb as $order)
	{
		echo '<div>' . __('N° de commande : %s', $order['Order']['id']) . '</div>';
		echo '<div>' . __('Emprunteur : %s, %s (%s)', $order['Order']['firstname'], $order['Order']['surname'], $order['Order']['mail']) . '</div>';
		echo '<div>' . __('Titre : %s', $order['Order']['journal_title']) . '</div>';
		echo '<div>' . __('Fournisseur : %s', $order['Origin']['name']) . '</div>';
		echo '<div>' . __('N° référence fournisseur : %s', $order['Order']['external_ref']) . '</div>';
		echo '<hr><br />';
	} 
?>