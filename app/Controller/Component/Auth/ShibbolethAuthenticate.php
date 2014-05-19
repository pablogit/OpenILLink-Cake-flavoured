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

	class ShibbolethAuthenticate extends BaseAuthenticate
	{
		public function authenticate(CakeRequest $request, CakeResponse $response)
		{
			$this->User = ClassRegistry::init('User');

			$email = (isset($_SERVER['Shib-InetOrgPerson-mail'])? strtolower($_SERVER['Shib-InetOrgPerson-mail']) : '');
			if(!empty($email))
			{
				$user = $this->User->find('first', array('conditions' => array('User.mail' => $email)));
				if(count($user) > 0) //A user with this email has been found
				{
					return $user['User'];
				}
				else //No user found. We log in as guest
				{
					return array('username' => $email, 'admin_level' => '9');
				}
			}

			//Default : refuse
			return false;
		}
	}
?>