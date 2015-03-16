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

class OrdersController extends AppController
{
	public $helpers = array('Html', 'Form', 'Js', 'Paginator');
	public $uses = array('Order', 'Link');
	public $components = array('Cookie', 'Paginator');

	/**************************************************************\
	|*                          Actions                           *|
	\**************************************************************/
	public function index($box='all')
	{
		$conditions = array();
		$sort = array('Order.id' => 'desc');
		if($box === 'in')
		{
			$conditions = array('OR' => array('Status.is_visible_in_box' => 'in', array('Status.special' => array('renew', 'peb'), 'renew_at <=' => date('Y-m-d'))));
			$sort = array('Order.priority' => 'asc') + $sort; //Priority should be first sort condition
		}
		elseif($box === 'out' || $box === 'trash')
			$conditions['Status.is_visible_in_box'] = $box;

		if($this->Auth->user('admin_level') == '2' || $this->Auth->user('admin_level') == '3')
			$conditions['Order.library_id'] = $this->Auth->user('library_id');
		elseif($this->Auth->user('admin_level') == '9')
			$conditions['Order.mail'] = $this->Auth->user('username');

		$this->paginate = array('conditions' => $conditions, 'order' => $sort, 'limit' => 25);
		
		$orders = $this->paginate('Order');

		$this->set('boxName', $box);
		$this->set('orders', $orders);
		$this->set('searchFields', $this->Order->getSearchFields());
	}

	//If search is from form : /search?field=XXX&value=YYY. If search is from link : /search/field/value
	public function search($field="", $value="")
	{
		if(empty($field) && isset($this->request->query['field']))
			$field = $this->request->query['field'];
		if(empty($value) && isset($this->request->query['value']))
			$value = $this->request->query['value'];

		$orders = array();
		if(!empty($field) && !empty($value))
		{
			$conditions = $this->Order->setupSearchConditions($field, $value);
			if($this->Auth->user('admin_level') == '9')
				$conditions['Order.mail'] = $this->Auth->user('username');
			$this->paginate = array('conditions' => $conditions, 'order' => array('Order.id' => 'desc'), 'limit' => 25); 
			$orders = $this->paginate('Order');
		}
		else
		{
			$this->paginate = array('conditions' => array('Order.id' => '0')); //Simulate an empty result. This way, paginator vars are set
			$orders = $this->paginate('Order');
			$this->Session->setFlash(__('Paramètres de recherche incorrects.'), 'default', array('class' => 'flash_error'));
		}

		$this->set('boxName', __('recherche'));
		$this->set('orders', $orders);
		$this->set('searchFields', $this->Order->getSearchFields());

		$this->render('index');
	}

	/*
	* Create new order if request method is post, otherwise shows creation form.
	*
	*/
	public function create()
	{
		//POST create() means check form and save it.
		if($this->request->is('post'))
		{
			//Setup cookie if necessary
			if(isset($this->request->data['Order']['cookie']) && $this->request->data['Order']['cookie'] == 1)
			{
				$this->setupCookie();
			}

			$this->request->data = $this->Order->setupDefaults($this->request->data);
			
			//Some informations about who ordered
			$this->request->data['Order']['referer'] = $this->referer();
			$this->request->data['Order']['ip'] = $this->request->clientIp();

			//Setup history
			$identifier = ($this->Auth->user('name') ? $this->Auth->user('name') : $this->request->clientIp());
			$this->request->data['Order']['history'] = __('Commande saisie par %s le %s ', array($identifier, $this->request->data['Order']['order_at']));

			//Fill doi or pmid field if necessary
			if(isset($this->request->data['tid']) && !empty($this->request->data['uid']) && ($this->request->data['tid'] == 'pmid' || $this->request->data['tid'] == 'doi'))
			{
				$this->request->data['Order'][$this->request->data['tid']] = str_replace(" ", "", $this->request->data['uid']);
			}

			$duplicate_id = $this->Order->is_duplicate($this->request->data);//Return order id if another article has similar metadata, else 0
			if($duplicate_id > 0)
			{
				$comment = "";
				if(isset($this->request->data['Order']['admin_comment']) && !empty($this->request->data['Order']['admin_comment']))
					$comment = $this->request->data['Order']['admin_comment'] . '\n';
				$this->request->data['Order']['admin_comment'] = $comment . __("Possible doublon de la commande %s", $duplicate_id);
			}

			//And finally save
			$this->Order->create();
			if($this->Order->save($this->request->data))
			{
				$this->request->data['Order']['id'] = $this->Order->id;
       			$this->Session->write('order_data', $this->Order->findById($this->Order->id));
				return $this->redirect(array('action' => 'confirmation'));
			}
		}

		//Else, show form with cookie value if exists
		if(!$this->request->data && $this->Cookie->check('FormInfo'))
		{
			$this->request->data['Order'] = $this->Cookie->read('FormInfo');
		}

		$this->request->data['uid'] = '';
		if(isset($_GET['pmid']))
		{
			$this->request->data['uid'] = $_GET['pmid'];
		}

		//And fill from openurl params
		$this->useOpenurlParams();

		$this->setupOptions();
	}

	public function confirmation()
	{
		if ($this->Session->check('order_data'))
		{
			$this->data = $this->Session->read('order_data');
			$this->Session->delete('order_data');
		}
		else
			$this->data = array();

		$this->set('data', $this->data);
	}

	public function details($id = null)
	{
		if(!$id)
			return $this->redirect(array('controller' => 'orders', 'action' => 'index', 'all'));

		$order = $this->Order->findById($id);
		if(!$order)
			return $this->redirect(array('controller' => 'orders', 'action' => 'index', 'all'));

		$this->set('order', $order);
		$this->set('emailLink', $this->Order->setupEmail($order, $this->Configuration->find('first')));

		$this->set('externalLinks', $this->setupExternalLinks($order));
	}

	public function edit($id)
	{
		if (!$id)
			return $this->redirect(array('controller' => 'orders', 'action' => 'index', 'all'));

		$order = $this->Order->findById($id);
		if (!$order)
			return $this->redirect(array('controller' => 'orders', 'action' => 'index', 'all'));

		if ($this->request->is(array('post', 'put')))
		{
			$this->Order->id = $id;
			$diffs = $this->findDiffs($this->Order->findById($id), $this->request->data);

			//Add differences in history
			$history = $order['Order']['history'];
			if(count($diffs) > 0)
				$history .= '<br />' . __('Commande modifiée par %s le %s', array($this->Auth->user('name'), date("y-m-d H:i:s"))) . ' [';

			foreach ($diffs as $diffField => $diffValue)
			{
				$diffField = str_replace('_id', '', $diffField);
				$history .= $diffField . '/';
			}
			if(count($diffs) > 0)
			{
				$history = substr($history, 0, strlen($history)-1) . ']';
				$this->request->data['Order']['history'] = $history;
			}

			//If status has changed and new status has special state sent or renew, we automcatically set sent/renew time
			if(isset($diffs['status_id']))
			{
				$newStatus = $this->Order->Status->findById($this->request->data['Order']['status_id']);
				if($newStatus['Status']['special'] == 'sent' && empty($this->request->data['Order']['sent_at']))
					$this->request->data['Order']['sent_at'] = date("Y-m-d H:i:s");
				elseif($newStatus['Status']['special'] == 'renew' && empty($this->request->data['Order']['renew_at']))
					$this->request->data['Order']['renew_at'] = date("Y-m-d", strtotime('+30 days'));
			}

			//Set pmid or doi field if necessary
			if(isset($this->request->data['tid']) && !empty($this->request->data['uid']) && ($this->request->data['tid'] == 'pmid' || $this->request->data['tid'] == 'doi'))
			{
				$this->request->data['Order'][$this->request->data['tid']] = $this->request->data['uid'];
			}

			if ($this->Order->save($this->request->data))
			{
				$this->Session->setFlash(__('La commande a été mise à jour.'));
				return $this->redirect(array('controller' => 'orders', 'action' => 'details', $id));
			}
			$this->Session->setFlash(__('Impossible d\'effectuer les modifications'), 'default', array('class' => 'flash_error'));
		}

		if (!$this->request->data)
		{
			$this->request->data = $order;
		}

		$this->setupOptions();
	}

	public function delete($id)
	{
		if ($this->request->is('get'))
		{
			throw new MethodNotAllowedException();
		}

		$order = $this->Order->findById($id);
		if (!$order)
			return $this->redirect(array('action' => 'index'));

		if ($this->Order->delete($id))
		{
			$this->Session->setFlash(__('La commande "%s" a été supprimée.', $id));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression de la commande'), 'default', array('class' => 'flash_error'));
		}

		return $this->redirect(array('action' => 'index'));
	}

	public function emptyTrash()
	{
		if($this->Order->deleteAll(array('Status.is_visible_in_box' => 'trash')))
		{
			$this->Session->setFlash(__('La boite poubelle a été vidée.', $id));
		}
		else
		{
			$this->Session->setFlash(__('Erreur lors de la suppression des éléments de la boite poubelle'), 'default', array('class' => 'flash_error'));
		}

		return $this->redirect(array('controller' => 'admin', 'action' => 'index'));		
	}

	public function forms($formName, $id)
	{
		$order = $this->Order->findById($id);
		$this->set('order', $order);
		$this->set('formName', $formName);
	}

	public function resolve()
	{
		if ($this->request->is('ajax'))
		{
			$identificator = "";
			$configuration = $this->Configuration->find('first');
			if($this->request->data['tid'] == 'pmid')
			{
				$identificator = empty($configuration['Configuration']['library_email'])?'aa@bb.com':$configuration['Configuration']['library_email']; //An email address is required. If no is setup, we use a default address
			}
			elseif($this->request->data['tid'] == 'doi')
			{
				if(!empty($configuration['Configuration']['crossref_username']))
				{
					$identificator = $configuration['Configuration']['crossref_username'] . ':' . $configuration['Configuration']['crossref_password'];
				}
				else
				{
					$identificator = $configuration['Configuration']['crossref_email'];
				}
			}

			$proxy = '';
			if($configuration['Configuration']['is_proxy_active'] && !empty($configuration['Configuration']['proxy_url']) && !empty($configuration['Configuration']['proxy_port']))
				$proxy = $configuration['Configuration']['proxy_url'] . ':' . $configuration['Configuration']['proxy_port'];
			$proxyAuth = '';
			if($configuration['Configuration']['is_proxy_active'] && !empty($configuration['Configuration']['proxy_username']) && !empty($configuration['Configuration']['proxy_password']))
				$proxyAuth = $configuration['Configuration']['proxy_username'] . ':' . $configuration['Configuration']['proxy_password'];

			$results = $this->Order->fetchContent($this->request->data['tid'], $this->request->data['uid'], $proxy, $proxyAuth, $identificator);
			$this->data = $results;
			$this->layout = 'ajax';
		}
	}

	public function resolveFromLDAP()
	{
		if ($this->request->is('ajax'))
		{
			$results = $this->getLDAPinfos($this->request->data['sn'], $this->request->data['fn']);
			if(count($results) == 1)
			{
				$this->data = $results[0];
			}
			else
			{
				$options = array();
				for($i = 0; $i < count($results); $i++)
					$options[$i] = $results[$i]['surname'] . ' ' . $results[$i]['firstname'] . ' | ' . $results[$i]['service'];
				$this->set('options', $options);
				$this->set('results', $results);
			}
			$this->set('services', $this->getServicesWithDpt());
			$this->layout = 'ajax';
		}
	}

	public function windowsLoginLookup()
	{
		if ($this->request->is('ajax'))
		{
			$results = $this->getLDAPinfos('', '', $this->request->data['login']);
			if(count($results) == 1)
			{
				$this->data = $results[0];
			}
			$this->set('services', $this->getServicesWithDpt());
			$this->layout = 'ajax';
			$this->render('resolveFromLDAP');
		}	
	}

	/**************************************************************\
	|*                       Authorization                        *|
	\**************************************************************/
	public function isAuthorized($user = null)
	{
		if($this->Auth->user('id'))
		{
			//Allow all actions for logged users admin_level
			if($this->action === 'delete' || $this->action === 'emptyTrash')
			{
				return ($this->Auth->user('admin_level') == '1' || $this->Auth->user('admin_level') == '2');
			}
			
			return true;
		}
		//Guest
		if($this->Auth->user('username') != "")
		{
			if($this->action === 'index')
			{
				$this->request->params['pass'][0] = 'guest'; //Always redirect to guest box
				return true;
			}
			elseif($this->action === 'details' || $this->action === 'search')
				return true;
		}

		// Default deny
		return false;
	}

	/**************************************************************\
	|*                         Callbacks                          *|
	\**************************************************************/
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('create', 'resolve', 'confirmation', 'windowsLoginLookup');
	}

	/**************************************************************\
	|*                      Private methods                       *|
	\**************************************************************/
	private function getLDAPinfos($surname="", $firstname="", $username="")
	{
		$values = array(array('firstname' => $firstname, 'surname' => $surname));

		$config = $this->Configuration->find('first');

		$address = $config['Configuration']['ldap_url'];
		$port = $config['Configuration']['ldap_port'];
		$rdn = $config['Configuration']['ldap_rdn'];
		$password = $config['Configuration']['ldap_password'];
		$base_dn = $config['Configuration']['ldap_base_dn'];

		if($config['Configuration']['is_ldap_active'])
		{
			$ds=ldap_connect($address, $port);
			if($ds)
			{
				ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
				$r=ldap_bind($ds, $rdn, $password);
				$filter = "(&(sn=".$surname . "*)(givenName=".$firstname."*)(samaccountname=".$username."*))";
				$attributes = array('sn', 'givenname', 'mail', 'physicaldeliveryofficename', 'department');
				$sr=@ldap_search($ds, $base_dn, $filter, $attributes, 0, 20);

				if(ldap_count_entries($ds,$sr) > 0)
				{
					$info = ldap_get_entries($ds, $sr);
					$servicesWithDpt = $this->getServicesWithDpt();
					for ($i=0; $i<$info["count"]; $i++)
					{
						$values[$i]['firstname'] = $info[$i]['givenname'][0];
						$values[$i]['surname'] = $info[$i]['sn'][0];
						$values[$i]['mail'] = (isset($info[$i]['mail'])?$info[$i]['mail'][0]:'');
						if(isset($info[$i]['physicaldeliveryofficename']))
							$srvcWithDpt = $info[$i]['physicaldeliveryofficename'][0] . (!empty($info[$i]['department'])?' (' . $info[$i]['department'][0] . ')':'');
						else
							$srvcWithDpt = '';
						$id = array_search($srvcWithDpt, $servicesWithDpt);
						$values[$i]['service'] = $srvcWithDpt;
						$values[$i]['service_id'] = $id==False?'':$id;
					}
				}
				ldap_close($ds);
			}
		}

    	return $values;
	}

	private function useOpenurlParams()
	{
		if(!isset($_GET))
			return;

		$fields = array(
			'id' 		=> 'uid',
			'genre' 	=> 'doc_type',
			'aulast' 	=> 'authors',
			'issn' 		=> 'isxn',
			'isbn' 		=> 'isxn',
			'title' 	=> 'journal_title',
			'atitle' 	=> 'article_title',
			'volume'	=> 'volume',
			'issue'		=> 'issue',
			'pages'		=> 'pages',
			'date'		=> 'year'
			);

		if(!isset($this->request->data['Order']))
			$this->request->data['Order'] = array();

		foreach ($fields as $openUrlField => $dataField)
		{
			if(isset($_GET[$openUrlField]))
			{
				$this->request->data['Order'][$dataField] = $_GET[$openUrlField];
			}
		}
	}

	private function setupExternalLinks($order)
	{
		$externalLinks = array();

		switch ($order['Order']['doc_type'])
		{
			case 'article':
				if(!empty($order['Order']['article_title']))
					$externalLinks['atitle'] = $this->Link->find('all', array('conditions' => array(
						'is_search_atitle' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				if(!empty($order['Order']['pmid']))
					$externalLinks['pmid'] = $this->Link->find('all', array('conditions' => array(
						'is_search_pmid' => '1',
						'is_active' => '1',
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				//No break => issn/journal title links are also retrieved 
			case 'preprint':
			case 'journal':
				if(!empty($order['Order']['isxn']))
				{
					$externalLinks['issn'] = $this->Link->find('all', array('conditions' => array(
						'is_search_issn' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				}
				if(!empty($order['Order']['journal_title']))
				{
					$externalLinks['ptitle'] = $this->Link->find('all', array('conditions' => array(
						'is_search_ptitle' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				}
				break;
			case 'bookitem':
				if(!empty($order['Order']['article_title']))
					$externalLinks['chtitle'] = $this->Link->find('all', array('conditions' => array(
						'is_search_atitle' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				//No break => isbn/book title links are also retrieved 
			case 'book':
			case 'thesis':
				if(!empty($order['Order']['isxn']))
				{
					$externalLinks['isbn'] = $this->Link->find('all', array('conditions' => array(
						'is_search_isbn' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				}
				if(!empty($order['Order']['journal_title'])) //Book title is in same field as journal journal
				{
					$externalLinks['btitle'] = $this->Link->find('all', array('conditions' => array(
						'is_search_btitle' => '1', 
						'is_active' => '1', 
						'library_id' => array(0, $order['Order']['library_id'])
						)));
				}
				break;
		}

		foreach ($externalLinks as $linkType => &$linkGroup)
		{
			foreach ($linkGroup as &$link)
			{
				$link['Link']['url'] = str_replace("XISSNX", urlencode($order['Order']['isxn']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XISBNX", urlencode($order['Order']['isxn']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XPMIDX", urlencode($order['Order']['pmid']), $link['Link']['url']);
				if($linkType == 'atitle' || $linkType == 'chtitle')
				{
					$link['Link']['url'] = str_replace("XTITLEX", urlencode($order['Order']['article_title']), $link['Link']['url']);
				}
				else
				{
					$link['Link']['url'] = str_replace("XTITLEX", urlencode($order['Order']['journal_title']), $link['Link']['url']);
				}
			}
			unset($link);
		}
		unset($linkGroup);

		$orderLinks = $this->Link->find('all', array('conditions' => array(
			"OR" => array(
				'is_order_ext' => '1', 
				'is_order_form' => '1'),
			'is_active' => '1', 
			'library_id' => array(0, $order['Order']['library_id'])
		)));

		$config = $this->Configuration->find('first');

		foreach ($orderLinks as &$link)
		{
			if($link['Link']['is_openurl'] == '1')
			{
				$linkurl = $link['Link']['url'];
				$pos = strpos($linkurl, "?");
				if ($pos === false)
					$linkurl = $linkurl . "?" . $config['Configuration']['openurl_sid'];
				else
					$linkurl = $linkurl . "&" . $config['Configuration']['openurl_sid'];
				if (!empty($order['Order']['doi']))
					$linkurl .= "&id=doi:" . urlencode ($order['Order']['doi']);
				if (!empty($order['Order']['pmid']))
					$linkurl .= "&id=pmid:" . urlencode ($order['Order']['pmid']);
				$linkurl .= "&genre=" . urlencode ($order['Order']['doc_type']);
				$linkurl .= "&aulast=" . urlencode ($order['Order']['authors']);
				$linkurl .= "&issn=" . $order['Order']['isxn'];
				$linkurl .= "&eissn=" . $order['Order']['eissn'];
				$linkurl .= "&isbn=" . $order['Order']['isxn'];
				$linkurl .= "&title=" . urlencode($order['Order']['journal_title']);
				$linkurl .= "&atitle=" . urlencode ($order['Order']['article_title']);
				$linkurl .= "&volume=" . urlencode ($order['Order']['volume']);
				$linkurl .= "&issue=" . urlencode ($order['Order']['issue']);
				$linkurl .= "&pages=" . urlencode ($order['Order']['pages']);
				$linkurl .= "&date=" . urlencode ($order['Order']['year']);
				$link['Link']['url'] = $linkurl;
			}
			elseif($link['Link']['is_order_form'] == '1')
				$link['Link']['url'] .= '/' . $order['Order']['id'];
			else
			{
				$link['Link']['url'] = str_replace("XSIDX",urlencode($config['Configuration']['openurl_sid']),$link['Link']['url']); //Config is needed here
				$link['Link']['url'] = str_replace("XPIDX",urlencode ($order['Order']['id']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XDOIX",urlencode ($order['Order']['doi']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XPMIDX",urlencode ($order['Order']['pmid']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XGENREX",urlencode ($order['Order']['doc_type']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XAULASTX",urlencode ($order['Order']['authors']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XISSNX",urlencode ($order['Order']['isxn']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XEISSNX",urlencode ($order['Order']['eissn']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XISBNX",urlencode ($order['Order']['isxn']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XTITLEX",urlencode ($order['Order']['journal_title']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XATITLEX",urlencode ($order['Order']['article_title']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XVOLUMEX",urlencode ($order['Order']['volume']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XISSUEX",urlencode ($order['Order']['issue']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XPAGESX",urlencode ($order['Order']['pages']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XDATEX",urlencode ($order['Order']['year']), $link['Link']['url']);
				$link['Link']['url'] = str_replace("XNAMEX",urlencode ($order['Order']['surname'] . ", " . $order['Order']['firstname']), $link['Link']['url']);				
			}
		}
		unset($link);

		$externalLinks['orderLinks'] = $orderLinks;

		return $externalLinks;
	}

	private function setupOptions()
	{
		//Status
		$this->set('status', $this->Order->Status->find('list', array('fields' => array('Status.id', 'Status.title'))));

		//Origins (current library origins + other libraries)
		$this->set('origins', $this->getOrigins());

		//Services
		$this->set('services', $this->getServicesWithDpt());

		$this->set('libraries', $this->Order->Library->find('list', array('fields' => array('Library.id', 'Library.name'))));

		$this->set('configuration', $this->Configuration->find('first'));

		$defaultStatus = $this->Order->Status->find('first', array('conditions' => array('special' => 'new')));
		$this->set('defaultStatus', $defaultStatus['Status']['id']);
	}

	private function getServicesWithDpt()
	{
		$servicesWithoutDepartments = $this->Order->Service->find('all');
		$services = array();

		$ip = $this->request->clientIp();
		foreach ($servicesWithoutDepartments as $s)
		{
			if(!$this->Auth->user('admin_level')) //If admin_level isn't set, it's a guest. We only show services available for ip mask
			{
				$isVisible = false;
				foreach ($s['IpRange'] as $ipRange)
				{
					$isVisible |= $this->cidr_match($ip, $ipRange['mask']);
				}
				if(!$isVisible)
					continue;
			}

			$name = $s['Service']['name'];
			if($s['Service']['department'] != "" || $s['Service']['faculty'] != "")
			{
				$name .= ' (';
				if($s['Service']['department'] == "")
				{
					$name .= $s['Service']['faculty'];
				}
				elseif ($s['Service']['faculty'] == "")
				{
					$name .= $s['Service']['department'];
				}
				else
				{
					$name .= $s['Service']['department'] . '/' . $s['Service']['faculty'];
				}
				$name .= ')';
			}
			$services[$s['Service']['id']] = $name;
		}

		asort($services); //Services are sorted by name
		return $services;
	}

	private function getOrigins()
	{
		$commonOrigins = $this->Order->Origin->find('list', array(
			'fields' => array('Origin.id', 'Origin.name'),
			'conditions' => array('Origin.library_id' => '0'))
		);
		$originOptions = array(__('localisations communes') => $commonOrigins);

		if(isset($this->request->data['Order']['library_id']))
		{
			$selfOrigins = $this->Order->Origin->find('list', array(
				'fields' => array('Origin.id', 'Origin.name'),
				'conditions' => array('Origin.library_id' => $this->request->data['Order']['library_id']))
			);

			if(!empty($selfOrigins))
			{
				$originOptions['localisations propres'] = $selfOrigins;
			}
		}

		return $originOptions;
	}

	private function setupCookie()
	{
		$this->Cookie->write('FormInfo', array(
			'surname' => $this->request->data['Order']['surname'],
			'firstname' => $this->request->data['Order']['firstname'],
			'service_id' => $this->request->data['Order']['service_id'],
			'mail' => $this->request->data['Order']['mail'],
			'tel' => $this->request->data['Order']['tel'],
			'address' => $this->request->data['Order']['address'],
			'zip' => $this->request->data['Order']['zip'],
			'locality' => $this->request->data['Order']['locality'],
			'deliver_type' => $this->request->data['Order']['deliver_type']
			), true, '1 year');
	}

	private function findDiffs($oldData, $newData)
	{
		$diffFields = array();
		foreach ($newData['Order'] as $newField => $newValue)
		{
			if($oldData['Order'][$newField] != $newValue)
				$diffFields[$newField] = $newValue;
		}

		return $diffFields;
	}

	private function cidr_match($ip, $cidr)
	{
		list($subnet, $mask) = explode('/', $cidr);

		if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1)) == ip2long($subnet))
		{ 
			return true;
		}

		return false;
	}
}

?>