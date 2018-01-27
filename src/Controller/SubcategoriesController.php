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
class SubcategoriesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	public function index() 
	{		
		//Debugger::dump($this);exit;
		$user_id = $this->getUserId();
		
		//$r = $this->Subcategories->getByUser(intval($user_id), 0, true);
		
		$r = $this->Subcategories
			->find()
			->contain(['categories'])
			->order(['Subcategories.name' => 'ASC']);
		
		foreach($r as $rec)
		{
			//dd($rec);
		}

		$this->set('records', $r);
	}
	
	public function view($id) 
	{				
		$r = $this->Subcategory->read(null, $id);
		
		$this->set('record', $r);
	}	
	
    public function edit($id) 
	{
        $this->Subcategory->id = $id;
		
		$user_id = $this->getUserId();
		
        if (!$this->Subcategory->exists()) {
            throw new NotFoundException(__('Invalid Subcategory record'));
        }
				
        if ($this->request->is('post') || $this->request->is('put')) 
		{
			$this->request->data['Subcategory']['parent_id'] = $this->request->data['Subcategory']['category'];
			//debug($this->request->data);die;
            if ($this->Subcategory->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The Subcategory has been saved'));
                return $this->redirect(array('action' => 'index'));				
            }
            $this->Session->setFlash(
                __('The Subcategory record could not be saved. Please, try again.')
            );
        } 
		else 
		{
            $this->request->data = $this->Subcategory->read(null, $id);
			$this->setSelectList(new Category, $user_id);
        }
    }
	
    public function add() 
	{
		$u = $this->Auth->user();
		$user_id = $u['id'];
	
        if ($this->request->is('post')) 
		{
            $this->Subcategory->create();

			// add user
			$this->request->data['Subcategory']['user_id'] = $user_id;						
			$this->request->data['Subcategory']['parent_id'] = 	$this->request->data['Subcategory']['category'];
						
            if ($this->Subcategory->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The Subcategory record has been saved'));
                return $this->redirect(array('action' => 'index'));
                //return $this->redirect(array('controller' => 'threads', 'action' => 'view/' . $parent_id));				
            }
            $this->Session->setFlash(
                __('The Subcategory record could not be saved. Please, try again.')
            );
        }
		else
		{
			$this->setSelectList(new Category, $user_id);
		}
    }
	
    public function delete($id) 
	{
        //$this->request->allowMethod('post');
		
        $this->Subcategory->id = $id;
		
        if (!$this->Subcategory->exists()) {
            throw new NotFoundException(__('Invalid Subcategory'));
        }
		
        if ($this->Subcategory->delete()) {
            $this->Session->setFlash(__('Subcategory deleted'));
            return $this->redirect(array('action' => 'index'));
        }
		
        $this->Session->setFlash(__('Subcategory record was not deleted'));
		
        return $this->redirect(array('action' => 'index'));
    }
}
