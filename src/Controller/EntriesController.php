<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\ServerRequest;

/**
 * Entries Controller
 *
 * @property \App\Model\Table\EntriesTable $Entries
 */
class EntriesController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		
        $this->Auth->allow(['populate']);
        $this->Auth->allow(['timer']);
        $this->Auth->allow(['timer2']);
    }
	
	public function isAuthorized($user)
	{
		// Admin can access every action
		if ($user['user_type'] === USERTYPE_ADMIN)
		{
			return true;
		}
		else
		{
			//$this->Flash->error('Admin Function not available');
			//return $this->redirect('/');
			return true;
		}
	}	

	protected function isDev()
	{
		return($_SERVER['REMOTE_ADDR'] == '127.0.0.1');
	}
	
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($filter=0, $expand = false)
    {
		$search = '';
		$userId = null;
		if ($this->IsLoggedIn())
		{
			$userId = $this->Auth->user()['id'];
		}
		else
		{
			return $this->redirect(['controller' => 'pages', 'action' => 'about']);
		}
			
		//debug($this->Auth->user); die;
		
		// clean the inputs
		$filter = intval($filter);
		$this->set('showBody', $expand);
		
        if (false && $this->request->is('get')) 
		{
		}
        else if ($this->request->is('post')) 
		{
			$filter = 0;
			$search = preg_replace("/[^:a-zA-Z0-9 .]+/", "", $this->request->data['search']);
			//debug($search);die;
			
			$this->request->session()->write('Filter.search', $search);
			$this->request->session()->write('Filter.type', 0);
		}
		else
		{
			if ($filter > 0 && $filter <= 20)
			{
				$this->request->session()->write('Filter.type', $filter);
				$this->request->session()->write('Filter.search', '');
			}
		}
		
		if ($filter > 20) // clear filter and show all
		{
			$filter = 0;
			$search = '';
			$this->request->session()->write('Filter.search', $search);
			$this->request->session()->write('Filter.type', $filter);
		}
		else 
		{
			if (strlen($search) == 0)
				$search = $this->request->session()->read('Filter.search');
				
			if ($filter == 0)
				$filter = intval($this->request->session()->read('Filter.type'));
		}
		
		if (false && strlen($tag) > 0 && ctype_alpha($tag)) // not used yet
		{
			$entries = $this->Entries->getByTag($tag);
			
			$this->set('entries', $entries);
			$this->set('_serialize', ['entry']);

			$count = sizeof($entries);
			$this->set('recordCount', $count);

			//Debugger:dump($entry);die;
			$this->render('indexTag');
		}
		else
		{			
			//$this->Flash->success(__('This is a test flash message.'));

			if (strlen($search) > 0) // search by text
			{
				$entries = $this->Entries
					->find()
					->where(
					['user_id =' => $userId,
						'OR' => [
								'title like ' => "%$search%",
								"description like " => "%$search%",
								"description_esp like " => "%$search%",
							]
						]
					)
					->orwhere(
					['type =' => TYPEPUBLIC,
						'OR' => [
								'title like ' => "%$search%",
								"description like " => "%$search%",
								"description_esp like " => "%$search%",
							]
						]
					)
					->order(['created' => 'DESC']);											
			}
			else if ($filter > 0)
			{
				if ($filter == TYPE5) // sort Title by Alpha for Public 
				{
					$entries = $this->Entries
						->find()
						->where(['type =' => $filter])
						//->andWhere(['user_id =' => $userId])
						->order(['title' => 'ASC']);
				}
				else
				{
					$entries = $this->Entries
						->find()
						->where(['user_id =' => $userId])
						->andWhere(['type =' => $filter])
						->order(['created' => 'DESC']);
				}
								
				if (false && $filter == TYPE6) // show body with FAQ's 
				{
					$this->set('showBody', true);
					$this->viewBuilder()->template('indexalt');
				}
			}
			else
			{
				//die('here1');
				$entries = $this->Entries
					->find()
					->where(['user_id =' => $userId])
					//->orWhere(['type =' => TYPEPUBLIC])
					->order(['created' => 'DESC']);							
			}
				
			//$query = $this->Entries->find('popular')->where(['author_id' => 1]);
			//$Entries = $this->paginate($query);
			$this->paginate = [
					'order' => ['Entries.type' => 'asc', 'Entries.created' => 'desc'],
					'limit' => 1000,
					'maxLimit' => 1000,
				];  
				
			$entries = $this->paginate($entries);
				
			$count = sizeof($entries);
			//Debugger:dump($records);

			$this->set(compact('entries'));
			$this->set('_serialize', ['entries']);
			$this->set('recordCount', $count);
			$this->set('search', $this->request->session()->read('Filter.search'));
		}
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->getRecord($id);
		if ($article == null)
		{
			$this->Flash->error(__('Entry not found'));
			return $this->redirect(['action' => 'index']);
		}
		
		if ($this->isDoubleView($article))
		{
			// double view: 'view'
		}
		else
		{
			$this->viewBuilder()->template('viewone');
		}		

        $this->set('article', $article);
        $this->set('_serialize', ['article']);
    }
 
    /**
     * Gen method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function gen($id = null)
    {
        $article = $this->getRecord($id);
		if ($article == null)
		{
			$this->Flash->error(__('Entry not found'));
			return $this->redirect(['action' => 'index']);
		}
		//debug($article);
		
		// if double-view
		if ($this->isDoubleView($article))
		{
			if ($article->type !== TYPETEMPLATES)
			{
				$template = $this->Entries
					->find()
					->where(['user_id =' => $this->Auth->user()['id']])
					->andWhere(['type =' => TYPETEMPLATES])
					->first();
				
				if ($template)
				{
					$description = $this->merge($template->description, $article->description, /* style = */ true);			
					$description2 = $this->merge($template->description_esp, $article->description_esp, /* style = */ true);

					$descriptionCopy = $this->merge($template->description, $article->description);			
					$descriptionCopy2 = $this->merge($template->description_esp, $article->description_esp);
				}
				else
				{
					$description = $this->merge('', $article->description);			
					$description2 = $this->merge('', $article->description_esp);
					
					$descriptionCopy = $description;
					$descriptionCopy2 = $description2;
				}

				$this->set('description', $description);
				$this->set('description2', $description2);
				$this->set('descriptionCopy', $descriptionCopy);
				$this->set('descriptionCopy2', $descriptionCopy2);								
			}
			else
			{
				// show template as a view
				$this->viewBuilder()->template('view');
				$this->view($id);
			}			
		}	
		else
		{
			// all other types are single view
			$this->viewBuilder()->template('viewone');
			$this->view($id);
		}
		
        $this->set('article', $article);
        $this->set('_serialize', ['article']);
    }
	
    /**
     * Gen method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function get($lang)
    {
		$article = $this->Entries
			->find()
			->where(['user_id =' => $this->Auth->user()['id']])
			->andWhere(['type =' => TYPETEMPLATES])
			->first();
		
		$this->viewBuilder()->autoLayout(false);
        $this->set('lang', $lang);
        $this->set('article', $article);
        $this->set('_serialize', ['article']);
    }
	
	private function merge($template, $description, $style = false)
	{
		$body = trim($description);
		if (mb_strlen($body) == 0)
			$body = '(' . strtoupper(__('Empty Body')) . ')';
		
		if (mb_strlen($template) > 0)
		{
			if ($style)
				$body = BODYSTYLE . $body . ENDBODYSTYLE;
				
			$description = nl2br(str_replace("{{body}}", $body, trim($template))) . '<br/>';
		}
		else
		{
			$description = nl2br($body) . '<br/>';
		}
	
		return $description;
	}
	
	private function merge1($template, $description)
	{
		$text = '';
		
		$tarray = array();
		if ($template == null)
		{
			$tarray[0] = nl2br(trim($description)) . '<br/>';
		}
		else
		{			
			$t = explode("\r\n", $template);
			//Debugger:dump($t);die;

			for($i = 0; $i < count($t); $i++)
			{
				$key = '{{}}';
				preg_match('{{[0-9]}}', $t[$i], $matches, PREG_OFFSET_CAPTURE);
				if (count($matches) == 1)
				{
					$tarray[$t[$i]] = $this->getOptions($t, $i);
					$i += (count($tarray[$t[$i]]));
				}
				else if ($t[$i] == '{{body}}')
				{
					$tarray[$t[$i]] = nl2br(trim($description)) . '<br/>';
				}
				else if (strlen(trim($t[$i])) != 0)
				{
					$tarray[$t[$i]] = $t[$i];
				}
			}
		}
		
		//debug($tarray);
		$description = array();
		foreach($tarray as $t)
		{
			if (is_array($t))
			{
				//$description[] = $t[0] . '<br/><br/>';
				$description[] = $t;
			}
			else
			{
				//debug($t);
				$description[] = $t . '<br/>';				
			}
		}
		return $description;
	}
	
	private function getOptions($t, $i)
	{
		$a = array();
		
		//debug($t[$i]);
		$cnt = 0;
		for($j = $i; $j < count($t); $j++)
		{
			if ($t[$j] == $t[$i])
				continue;
			if ($t[$j] == '')
				break;
							
			$a[$cnt++] = $t[$j];
		}
		
		return $a;
	}

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Entries->newEntity();
        if ($this->request->is('post')) 
		{
			$this->request->data['user_id'] = $this->Auth->user()['id'];
            $article = $this->Entries->patchEntity($article, $this->request->data);
			//debug($this->request->data);die;
			
            if ($this->Entries->save($article)) 
			{
                $this->Flash->success(__('The entry has been saved.'));
				
				if ($this->request->data['stay'])
					return $this->redirect(['action' => 'edit/' . $article->id]);
				else
					return $this->redirect(['action' => 'gen/' . $article->id]);
            } 
			else 
			{
                $this->Flash->error(__('The entry could not be saved. Please, try again.'));
            }
        }
		
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add2()
    {
		//$this->viewBuilder()->template('add');
		
        $article = $this->Entries->newEntity();
        if ($this->request->is('post')) {
		
			$this->request->data['user_id'] = $this->Auth->user()['id'];
            $article = $this->Entries->patchEntity($article, $this->request->data);
			//debug($this->request->data);die;
			
            if ($this->Entries->save($article)) 
			{
                $this->Flash->success(__('The entry has been saved.'));
                return $this->redirect(['action' => 'edit/' . $article->id]);
            } 
			else 
			{
                $this->Flash->error(__('The entry could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

	public function populate($user_id)
	{
		$this->popCopy($user_id, TYPETEMPLATES, 'Template');
		$this->popCopy($user_id, TYPEEMAIL, 'Message');
		return $this->redirect("/");
	}
	
	private function popCopy($user_id, $type, $desc)
	{
		$record = $this->Entries
			->find()
			->where(['type' => $type])
			->andWhere(['user_type' => USERTYPE_ADMIN])
			->contain(['Users'])
			->first();
			
		if ($record)
		{	
			$recordNew = $this->Entries->newEntity();
					
			// set the data
			$recordNew['user_id'] = $user_id;
			$recordNew['created'] = date('Y-m-d'); 
			$recordNew['modified'] = date('Y-m-d'); 
			$recordNew['title'] = 'First Message';
			$recordNew->description = $record->description;
			$recordNew->description_esp = $record->description_esp;
			$recordNew->type = $record->type;
		
			//debug($recordNew);die;

			if ($this->Entries->save($recordNew)) 
			{			
				//$this->Flash->success(__('Default ' . $desc . ' has been created.'));
			}
		}
		else
		{
			$this->Flash->error(__('Default Template not found'));
		}
	}
	
	public function copy($id = 0) 
	{				
        if ($this->request->is('post') || $this->request->is('put')) 
		{
			$record = $this->Entries->newEntity();
			
			// set user id
			$this->request->data['user_id'] = $this->Auth->user()['id'];

			// set to current date
			$this->request->data['created'] = date('Y-m-d'); 
			
			$record = $this->Entries->patchEntity($record, $this->request->data);
 			//Debuger:dump($record);die;

            if ($this->Entries->save($record)) 
			{			
                $this->Flash->success(__('The Entry has been copied.'));
				
				if ($this->request->data['stay'])
					return $this->redirect(['action' => 'edit/' . $record->id]);
				else
					return $this->redirect(['action' => 'gen/' . $record->id]);
            }
            $this->Flash->error(
                __('The Entry could not be copied. Please, try again.')
            );
        }
		else 
		{
			$article = $this->getRecord($id);
			if ($article == null)
			{
				$this->Flash->error(__('Entry not found'));
				return $this->redirect(['action' => 'index']);
			}
		
			$this->set(compact('article'));
			$this->set('_serialize', ['article']);
        }
	}	

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$article = $this->getRecord($id);
		
		if ($article == null)
		{
			$this->Flash->error(__('Entry not found or entry not public'));
			return $this->redirect(['action' => 'index']);
		}
		else
		{
			if ($this->isAdmin())
			{
				if ($this->isReadOnly($article))
					$this->Flash->error(__('NOT YOUR ENTRY, BE CAREFUL!.'));
			}
			else if ($this->isReadOnly($article))
			{
				$this->Flash->error(__('Not your entry, Copy first and then edit.'));
				return $this->redirect(['action' => 'view/' . $article->id]);
			}
		}
		
        if ($this->request->is(['patch', 'post', 'put'])) {
		
            $article = $this->Entries->patchEntity($article, $this->request->data);
			//echo $article; die;
            if ($this->Entries->save($article)) 
			{
                $this->Flash->success(__('The entry has been updated.'));
				
				if (array_key_exists('stay', $this->request->data) && $this->request->data['stay'])
					return $this->redirect(['action' => 'edit/' . $article->id]);
				else
					return $this->redirect(['action' => 'gen/' . $article->id]);				
            } 
			else 
			{
                $this->Flash->error(__('The entry could not be updated. Please, try again.'));
            }
        }
		
		if ($this->isDoubleView($article))
		{
			// use edit double by default: 'edit'
		}
		else
		{
			// use edit single
			$this->viewBuilder()->template('editone');
		}

        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $article = $this->getRecord($id);
		if ($article == null)
		{
			$this->Flash->error(__('Entry not found'));
			return $this->redirect(['action' => 'index']);
		}
		else if ($this->isReadOnly($article))
		{
			$this->Flash->error(__('Not your entry, cannot delete.'));
			return $this->redirect(['action' => 'view/' . $article->id]);
		}
		
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
			//$this->request->allowMethod(['post', 'delete']);
			$article = $this->Entries->get($id);
			if ($this->Entries->delete($article)) {
				$this->Flash->success(__('The entry has been deleted.'));
			} else {
				$this->Flash->error(__('The entry could not be deleted. Please, try again.'));
			}

			return $this->redirect(['action' => 'index']);
       }
		
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);	
    }
		
	public function saveEmail($debug = false) 
	{
		$flash = '';
		$errors = '';
		$count_trx = 0;
		$this->autoRender = false;
		
		// To connect to imap server on port 993
		//sbw $mbox = imap_open("{imap.gmail.com:993/imap/ssl}INBOX", "sbwilkinson1", "Rooster714-");
		$mbox = imap_open("{imap.mail.yahoo.com:993/imap/ssl}Sent", "sbwilkinson", "Rooster714-");
		//echo 'mbox = ' . $mbox;die;

		$count = 0;
		if ($mbox != NULL)
		{
			$count = imap_num_msg($mbox); 
			//echo 'num = ' . $num;//die;
			
			if (false) // un-false to show folder list
			{
				$folders = imap_list($mbox, "{imap.mail.yahoo.com:993/imap/ssl}", "*");
				echo "<ul>";
				foreach ($folders as $folder) {
					$folder = str_replace("{imap.gmail.com:993/imap/ssl}", "", imap_utf7_decode($folder));
					$folder = imap_utf7_decode($folder);
					echo '<li><a href="mail.php?folder=' . $folder . '&func=view">' . $folder . '</a></li>';
				}
				echo "</ul>";			
			}
			
			//$headers = imap_headers($mbox);

			//if ($headers == false) // no email found
			{
				//die("Imap Headers call failed");
			}
			//else
			{
				//foreach ($headers as $val)
				$num = 9999;
				$count_trx = 0;
				for ($i = 1; $i <= $num; $i++)
				{
					set_time_limit(90) or die('couldnt set time limit');
					
				    $uid = imap_uid($mbox, $i);

					$header = imap_header($mbox, $i);
					$toInfo = $header->to[0];
					$fromInfo = $header->from[0];
					$replyInfo = $header->reply_to[0];

					//Debugger:dump($toInfo);die;

					$details = array(
						"fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
							? $fromInfo->mailbox . "@" . $fromInfo->host : "",
						"fromName" => (isset($fromInfo->personal))
							? $fromInfo->personal : "",
						"toAddr" => (isset($toInfo->mailbox) && isset($toInfo->host))
							? $toInfo->mailbox . "@" . $toInfo->host : "",
						"toName" => (isset($toInfo->personal))
							? $toInfo->personal : "",
						"replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
							? $replyInfo->mailbox . "@" . $replyInfo->host : "",
						"replyName" => (isset($replyTo->personal))
							? $replyto->personal : "",
						"subject" => (isset($header->subject))
							? $header->subject : "",
						"udate" => (isset($header->udate))
							? $header->udate : ""
					);
					
					if (!isset($details['toName']) || strlen($details['toName'] == 0))
						$details['toName'] = $details['toAddr']; 
						
					//Debugger:dump($details);
					//die;
					
					$body_raw = $this->getBody($uid, $mbox);
					$body_raw = str_replace(">", "", $body_raw);
					$body_raw = str_replace("<", "", $body_raw);
					
					if (strlen($body_raw) == 0 || mb_strlen($body_raw) == 0)
						die('empty body');
					
					//$body_raw = imap_body($mbox, $i);
					//echo '<p>' . $body_raw . '</p>';
					//die;
					//break;

					$article = $this->Entries->newEntity();
					
					$data = [
						//'title' => $header->from[0] . ': ' . $header->subject,
						'title' => $details['toName'] . ': ' . $details['subject'],
						'description' => $body_raw,
						];
					$article = $this->Entries->patchEntity($article, $data);
					
					//Debugger:dump($article);die;
					
					//if ($this->Entries->save($article)) 
					{
						//$this->Flash->success(__('The email has been saved.'));

						//return $this->redirect(['action' => 'index']);
						
						{
						  imap_mail_move($mbox, $i, '_sbw');
						  imap_expunge($mbox);
						} 						
					} 
					//else 
					{
						//$this->Flash->error(__('The email could not be saved. Please, try again.'));
					}

					$count_trx++;
				}
			}

			imap_close($mbox);
		}
		else
		{
			$errors .= 'Unable to open email';
		}
							
		if (strlen($errors > 0))
		{
			$flash = 'Errors: ' . $errors;
			echo 'flash=' . $flash . CRLF;
		}
		else
		{
			$flash = 'No Email Transactions Found';
			
			if ($count_trx > 0)
				$flash = 'Transactions added from Email: ' . $count_trx . ' of ' . $count;
		}
			
        $this->Flash->success(__($flash));
		
		if ($debug)
		{
			echo 'flash=' . $flash;
			echo "<br/><br/><a href='/transactions/index?mon=curr'>Return to Transactions</a>";
			die;
		}
		
		return $this->redirect(array('controller' => 'entries', 'action' => 'index', '?mon=curr'));
	}
	
    /**
     * View method
     */
    public function start()
    {
    }

    /**
     * View method
     */
    public function schedule()
    {
    }
	
    public function timer()
    {
		$this->viewBuilder()->layout('');		
    }	

    public function timer2()
    {
		$this->viewBuilder()->layout('');		
    }	
	
	protected function getBody($uid, $imap) 
	{
		$body = $this->get_part($imap, $uid, "TEXT/HTML");
		// if HTML body is empty, try getting text body
		if ($body == "") {
			$body = $this->get_part($imap, $uid, "TEXT/PLAIN");
		}
		return $body;
	}

	protected function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) 
	{
		if (!$structure) 
		{
			   $structure = imap_fetchstructure($imap, $uid, FT_UID);
		}
		if ($structure) {
			if ($mimetype == $this->get_mime_type($structure)) {
				if (!$partNumber) {
					$partNumber = 1;
				}
				
				$text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
				
				//echo $structure->encoding; die;
				
				switch ($structure->encoding) 
				{
					case 3: return imap_base64($text);
					case 4: return imap_qprint($text);
					default:
							//return iconv($text);
							return iconv("ISO-8859-1", "UTF-8", $text);
			   }
		   }

			// multipart 
			if ($structure->type == 1) {
				foreach ($structure->parts as $index => $subStruct) {
					$prefix = "";
					if ($partNumber) {
						$prefix = $partNumber . ".";
					}
					$data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
					if ($data) {
						return $data;
					}
				}
			}
		}
		return false;
	}

	protected function get_mime_type($structure) 
	{
		$primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

		if ($structure->subtype) {
		   return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		}
		return "TEXT/PLAIN";
	}

	protected function isMyRecord($record)
	{
		$ret = false;
		
		if ($record) 
		{
			if ($record->user_id === $this->Auth->user()['id'])
			{			
				$ret = true;
			}
		}
		
		return $ret;
	}
	
	protected function isDoubleView($record)
	{
		return ($record != null && ($record->type == TYPEEMAIL || $record->type == TYPETEMPLATES || $record->type == TYPECANNED || $record->type == TYPESTEPS));
	}

	protected function isReadOnly($record)
	{
		if ($this->isMyRecord($record))
			return false;
		else
			return true;
	}
	
	protected function getRecord($id)
	{
		$record = $this->Entries
			->find()
			->where(['id' => $id /*, 'user_id' => $this->Auth->user()['id']*/ ])
			->first();
			
		if (!$record)
		{
			return null;
		}
		else if ($record->user_id === $this->Auth->user()['id'])
		{
			return $record;
		}
		else if ($record->type === TYPEPUBLIC)
		{
			return $record;
		}
		else
		{
			return null;
		}
	}
}

?>