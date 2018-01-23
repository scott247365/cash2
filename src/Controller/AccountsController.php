<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 
namespace App\Controller;

use App\Controller\AppController;

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class AccountsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function beforeFilter(\Cake\Event\Event $event)
    {
		parent::beforeFilter($event);
	}
	
	// this is the logged-in front page / summary page
	public function home($showAll = false) 
	{
		$showAll = (strlen($showAll) > 0 && $showAll === 'all');
		
		if (!$this->Auth->loggedIn())	
            return $this->redirect(array('controller' => 'pages', 'action' => 'home'));				
		
		// get current user
		$user_id = $this->getUserId();
		
		//
		// get account balances
		//
		$r = $this->Account->getSummary($user_id);
		$this->set('records', $r);
				
		//
		// get monthly netto
		//
		$t = new Transaction;
		$netto = $t->getNetto($user_id, $maxDate, $showAll);
		$this->set('netto', $netto);
		$this->set('maxDate', $maxDate);
		
		//
		// get annual totals
		//
		$annual = $t->getAnnualTotals($user_id);
		$this->set('annual', $annual);
		
		// find month max net for graph scaling
		$max = 0.0;
		//Debugger::dump($annual);exit;
		
		// get max netto number to scale the graph from
		foreach($netto as $rec)
		{
			if ($rec['date'] != 'YTD')
			{
				$f = abs(floatval($rec['net']));
				
				if ($f > $max)
					$max = $f;
			}
		}
		$this->set('maxgraph', $max);

		// get netto ytd
		$nettoytd = $netto['ytd']['net'];
		$this->set('nettoytd', $nettoytd);	
			
		//
		// get expenses for breakdown
		//
		
		$date = $this->getCurrMonth(5); // with 5 day buffer
		$smonth = getDate($date)['month'];
		$month = getDate($date)['mon'];	
		$year = intval(date('Y'));
		//echo $month; die;
		$expenses = $t->getExpenses($user_id, $month, $year);
		$this->set('expenses', $expenses);
		$this->set('smonth', $smonth);
		//die($smonth);
	}

	public function hidden() 
	{			
		return $this->redirect(array('action' => 'index', 'hidden'));				
	}
	
	public function index($options = '') 
	{
		if ($options == 'hidden')
			$r = $this->Accounts->getByUser($this->getUserId(), /* parent_id = */ 0, /* sort= */ 2);
		else
			$r = $this->Accounts->getVisible($this->getUserId(), /* parent_id = */ 0, /* sort= */ 1);
		
		$total = 0.0;
		foreach($r as $rec)
		{
			$total += floatval($rec['Account']['balance']);
		}
				
		$this->set('records', $r);
		$this->set('total', $total);
	}
	
	public function view($id) 
	{				
		$r = $this->Account->read(null, $id);
		
		$account_type = intval($r['Account']['account_type']);
		$account_type_name = 'unknown';
		
		if ($account_type == 1)
			$account_type_name = 'Debit';
		else if ($account_type == 2)
			$account_type_name = 'Credit';
		else if ($account_type == 3)
			$account_type_name = 'Other';
		
		$r['Account']['account_type_name'] = $account_type_name;
		
		$this->set('record', $r);
	}	
	
    public function edit($id) 
	{
        $this->Account->id = $id;
				
        if (!$this->Account->exists()) 
		{
            throw new NotFoundException(__('Invalid Account'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) 
		{		
			//$hidden = array_key_exists('checkboxhidden', $this->request->data);
			$this->request->data['Account']['hidden'] = $this->request->data['hidden'];
			unset($this->request->data['hidden']);
			//Debugger::dump($this->request->data);die;
			
            if ($this->Account->save($this->request->data)) 
			{
				$user_id = $this->getUserId();
				$t = new Transaction;
				$balance = $t->getAccountBalance($user_id, $id);
				$this->Account->updateBalance2($user_id, $id, $balance);
				//Debugger::dump($balance);exit;
			
                $this->Session->setFlash(__('The Account has been saved'));
                return $this->redirect(array('action' => 'index'));				
            }
            $this->Session->setFlash(
                __('The Account could not be saved. Please, try again.')
            );
        } 
		else 
		{
            $this->request->data = $this->Account->read(null, $id);
            unset($this->request->data['Account']['password']);
			
			$hidden = $this->request->data['Account']['hidden'];
			$this->set('hidden', $hidden);					
        }
    }
	
    public function add() 
	{
        if ($this->request->is('post')) 
		{
            $this->Account->create();
					
			$user_id = $this->getUserId();
			
			$this->request->data['Account']['user_id'] = $user_id;
					
            if ($this->Account->save($this->request->data)) 
			{		
				//$this->Account->updateBalance($this->getUserId(), $id);
			
                $this->Session->setFlash(__('The Account has been created: ' . $this->request->data['Account']['name']));

                return $this->redirect(array('action' => 'home'));
            }
            $this->Session->setFlash(
                __('The Account could not be created. Please, try again.')
            );
        }
    }
	
	public function delete($id) 
	{
        //$this->request->allowMethod('post');
		$user_id = $this->getUserId();
        $this->Account->id = $id;
		
        $this->request->data = $this->Account->read(null, $id);			
		
        if (!$this->Account->exists()) {
            throw new NotFoundException(__('Invalid Transaction'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Account->delete()) 
			{			
				$this->Session->setFlash(__('Account deleted: ' . $this->request->data['Account']['name']));
				return $this->redirect(array('action' => 'index?filter'));
			}
			
			$this->Session->setFlash(__('Account was not deleted'));
			
			return $this->redirect(array('action' => 'index?filter'));
		}
		else
		{	
			$this->set('record', $this->request->data);
			
		}
    }
	
    public function deleteOrig($id) 
	{
        //$this->request->allowMethod('post');
		
        $this->Account->id = $id;
		
        if (!$this->Account->exists()) {
            throw new NotFoundException(__('Invalid Account'));
        }
		
        if ($this->Account->delete()) {
            $this->Session->setFlash(__('Account deleted'));
            return $this->redirect(array('action' => 'index'));
        }
		
        $this->Session->setFlash(__('Account was not deleted'));
		
        return $this->redirect(array('action' => 'index'));
    }
	
	
	
	
    public function transfer($id) 
	{
        if ($this->request->is('post')) 
		{
            $this->Account->create();
					
			$user_id = $this->getUserId();
			
			$this->request->data['Account']['user_id'] = $user_id;
					
            if ($this->Account->save($this->request->data)) 
			{		
                $this->Session->setFlash(__('The Account has been saved'));

                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('The Account could not be saved. Please, try again.')
            );
        }
    }	
}
