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

	App::uses('BaseAuthenticate', 'Controller/Component/Auth');

	class GuestAuthenticate extends BaseAuthenticate
	{
		public function authenticate(CakeRequest $request, CakeResponse $response)
		{
			if(isset($request->data['User']))
			{
				$login = $request->data['User']['login'];
				$password = $request->data['User']['password'];
				if(substr(hash('md5', strtolower($login)), 0, 8) === $password)
					return array('username' => $login, 'admin_level' => '9');
			}
			return false;
		}
	}
?>