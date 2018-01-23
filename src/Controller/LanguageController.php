<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\Event;
use Cake\View\Helper\SessionHelper;
use Cake\I18n\I18n;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class LanguageController extends AppController
{
    /**
     * Set new language in session
     *
     * @return void
     */
	public function index($language = null)
	{
		$success = false;
		if (mb_strlen($language) > 0)
		{
			$success = true;
			
			I18n::locale($language); // ie: de_DE
			
			$this->request->session()->write('Settings.Language', $language);
			
			if ($success) {
				$this->Flash->success(__('Language has been set to') . ': ' . $language);
				//return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
				return $this->redirect('/');
			} 	
			else
			{
				$this->Flash->error(__('Language could not be set'));
				return $this->redirect('/');
			}
		}
		else
		{
			$this->Flash->error(__('Invalid language specified'));
			return $this->redirect('/');
		}
	}

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		
        $this->Auth->allow(['index']);
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }
}
