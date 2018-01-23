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
class CategoriesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

	public function index() 
	{		
		// get current user
		$user_id = $this->getUserId();	
		//$r = $this->Categories->getByUser(intval($user_id), 0, true);	

		//foreach($r as $rec)
		//{
			//dd($rec);
		//}
		
		$r = $this->Categories
			->find()
			->contain(['subcategories'])
			->order(['categories.name' => 'ASC']);
				
		//Debugger::dump($r);
		
		$this->set('records', $r);
	}
	
	public function view($id) 
	{				
		$r = $this->Category->read(null, $id);
		
		$this->set('record', $r);
	}	
	
    public function edit($id) 
	{
        $this->Category->id = $id;
		
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid Category record'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The Category has been saved'));
                return $this->redirect(array('action' => 'view/' . $id));				
            }
            $this->Session->setFlash(
                __('The Category record could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->Category->read(null, $id);
            unset($this->request->data['Category']['password']);
        }
    }
	
    public function add() 
	{
        if ($this->request->is('post')) 
		{
            $this->Category->create();

			$u = $this->Auth->user();
			$this->request->data['Category']['user_id'] = $u['id'];
						
            if ($this->Category->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The Category record has been saved'));
                return $this->redirect(array('action' => 'index'));
                //return $this->redirect(array('controller' => 'threads', 'action' => 'view/' . $parent_id));				
            }
            $this->Session->setFlash(
                __('The Category record could not be saved. Please, try again.')
            );
        }
    }
	
    public function delete($id) 
	{
        //$this->request->allowMethod('post');
		
        $this->Category->id = $id;
		
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid Category'));
        }
		
        if ($this->Category->delete()) {
            $this->Session->setFlash(__('Category deleted'));
            return $this->redirect(array('action' => 'index'));
        }
		
        $this->Session->setFlash(__('Category record was not deleted'));
		
        return $this->redirect(array('action' => 'index'));
    }
}
