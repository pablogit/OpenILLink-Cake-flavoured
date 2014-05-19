<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'orders', 'action' => 'index', 'in'),
			'logoutRedirect' => array('controller' => 'orders', 'action' => 'create'),
			'authError' => 'Veuillez vous authentifier afin d\'accéder à la zone de gestion.',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'login'),
					'scope' => array('User.is_active' => 1)
					),
				'Guest',
				'Shibboleth'
				),
			'authorize' => array('Controller')
			)
		);

	public $uses = array('Configuration');


	/**************************************************************\
	|*                         Callbacks                          *|
	\**************************************************************/
	public function beforeFilter()
	{
		parent::beforeFilter();
		//Allow tu use configuration in each view (we use config infos in default layout)
		$config = $this->Configuration->find('first');
		$this->set('config', $config);
		$this->checkBrowserLanguage($config);
	}
	
	/*
	 * Read the browser language and sets the website language to it if available.
	 *
	 */
	protected function checkBrowserLanguage($config)
    {
		if($config['Configuration']['browser_language_detection'] && !$this->Session->check('Config.language'))
		{
			//checking the 1st favorite language of the user's browser
			$browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

			$this->Session->write('Config.language', $browserLanguage);
		}
    } 
}
