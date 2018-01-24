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
use App\Model\Table\CategoriesTable;

define("CRLF", "<br/>");

// chase
define("EMAIL_CHASE_ID", 35);
define("EMAIL_CHASE_ACCOUNT", '2117');

// cap gray
define("EMAIL_CAPGRAY_ID", 31);
define("EMAIL_CAPGRAY_ACCOUNT", '6403');

// cap blue
define("EMAIL_CAPBLUE_ID", 10);  
define("EMAIL_CAPBLUE_ACCOUNT", '5043');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class TransactionsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();	
	
	private function getSafeInt($tag, $default = 0)
	{
		$ret = intval(isset($_GET[$tag]) ? $_GET[$tag] : $default);
		
		return $ret;
	}
	
	private function getSafeString($tag, $default = '')
	{
		$ret = isset($_GET[$tag]) ? $_GET[$tag] : $default;
		
		if ($ret != '' && !ctype_alpha($ret))
		{
			//die("not alpha: " . $ret);
			$ret = '';
		}
		
		return $ret;
	}
	
	// query string: ?cat=8&sub=20&acc=10&month=3&par=14&sort=2&allDates=1
	public function index() 
	{
		$useStartMonth = false;
		$useSessionFilter = false;

		$parent_id = 0;
		$sort = 2;
		$month = NULL;
		$year = NULL;
		$cat = NULL;
		$sub = NULL;
		$desc = NULL;
		$allDates = false;

		//Debugger::dump();
				
		//dd(count($this->request->query));
				
		if (count($this->request->query) > 0)
		{
			$allDates = (isset($this->request->query['allDates']));
			
			if (count($this->request->query) == 1 && isset($this->request->query['filter']))
			{
				$useSessionFilter = true;
			}
			else
			{
				if (isset($this->request->query['mon']))
				{
					$month = $_GET['mon'];
					if ($month == 'curr')
					{
						$useSessionFilter = false;
						$date = $this->getCurrMonth(0); // if first 5 days of month, return previous month
						$month = intval(date('m'));
						$year = intval(date('Y'));
						$useStartMonth = true;
					}
				}
				
				$parent_id 	= $this->getSafeInt('par');
				$month 		= $this->getSafeInt('mon');
				$year 		= $this->getSafeInt('year');
				$sort 		= $this->getSafeInt('sort', 2);
				$cat 		= $this->getSafeInt('cat');
				$sub 		= $this->getSafeInt('sub');
				$desc 		= $this->getSafeString('desc');
				
				/* UNSAFE
				$parent_id = intval(isset($_GET['par']) ? $_GET['par'] : 0);
				$month = isset($_GET['mon']) ? $_GET['mon'] : '';
				$year = isset($_GET['year']) ? $_GET['year'] : 0;
				$sort = isset($_GET['sort']) ? $_GET['sort'] : 2;
				$cat = isset($_GET['cat']) ? $_GET['cat'] : 0;
				$sub = isset($_GET['sub']) ? $_GET['sub'] : 0;
				$desc = isset($_GET['desc']) ? $_GET['desc'] : '';
				UNSAFE */
				
				$useStartMonth = false;
				if ($month == 'curr')
				{
					$date = $this->getCurrMonth(0); // if first 5 days of month, return previous month
					$month = intval(date('m'));
					$year = intval(date('Y'));
					$useStartMonth = true;
				}
				
				// save the filter in the session
				$session = $this->request->session();
				$session->write('Trans.month', $month); 
				
				$this->request->session()->write('Trans.month', $month);
				$this->request->session()->write('Trans.year', $year);
				$this->request->session()->write('Trans.cat', $cat);
				$this->request->session()->write('Trans.sub', $sub);
				$this->request->session()->write('Trans.account', $parent_id);
				$this->request->session()->write('Trans.desc', $desc);
			}
		}
 
		if ($useSessionFilter)
		{
			$month = $this->request->session()->read('Trans.month');
			$year = $this->request->session()->read('Trans.year');
			$cat = $this->request->session()->read('Trans.cat');
			$sub = $this->request->session()->read('Trans.sub');
			$parent_id = $this->request->session()->read('Trans.account');
			$desc = $this->request->session()->read('Trans.desc');
		}

		if ($allDates)
		{
			$month = NULL;
			$year = NULL;
		}
		
		$this->set('account_id' , $parent_id);
		$this->set('month' , $month);
		$this->set('year' , $year);
		$this->set('sort' , $sort);
		$this->set('cat' , $cat);
		$this->set('sub' , $sub);
		$this->set('desc' , $desc);

		//Debugger::dump($_GET);
	
		//
		// get the transaction records
		//
		$user_id = $this->getUserId();
		$r = $this->Transactions->getByUser(intval($user_id), $parent_id, $sort, $month, $cat, $sub, $useStartMonth, $year, $desc);
		$this->set('records', $r);
				
		//
		// get the balance
		//
		$user_id = $this->getUserId();			
		if (false && intval($parent_id) > 0) // OLD: get total 
		{
			$this->set('total', $this->Transactions->getAccountBalance($user_id, $parent_id));
		}
		
		// NEW: add up the listed transactions
		$total = 0.0;
		foreach($r as $rec)
		{
			$total += floatval($rec['Transaction']['amount']);
		}
		$this->set('total', $total);
		
		//
		// load the category dropdown menu
		//
		$this->set('categories', $this->Transactions->Categories->getSelectList($user_id, 'All Categories'));

		//
		// load the month link list
		//
		$monthLinks = $this->getMonthLinks();
		$this->set('monthLinks', $monthLinks);
		//debug($monthLinks);//die;
	}
	
	private function getMonthLinks() 
	{				
		$monthLinks = array();
		for ($i = 11; $i >= 0; $i--)
		{
			$date = mktime(0, 0, 0, date("m") - $i, 1, date("Y"));
			$month = date('M', $date);
			$monthIx = date('m', $date);
			$year = date('Y', $date);
			
			//Debugger::dump($i . ': ' . $month . '-' . $year);
			$monthLinks[$month] = array('month' => intval($monthIx), 'year' => intval($year));
		}	
		
		return $monthLinks;
	}
		
	public function view($id) 
	{				
		$r = $this->Transactions->read(null, $id);
		
		$this->set('record', $r);
	}	
	
    public function edit($id) 
	{
        $this->Transactions->id = $id;
		
        if (!$this->Transactions->exists()) 
		{
            throw new NotFoundException(__('Invalid Transaction record'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) 
		{		
			if (intval($this->request->data['Transaction']['type']) == 1)
			{
				$amount = floatval($this->request->data['Transaction']['amount']);
				$this->request->data['Transaction']['amount'] = -$amount;
			}
		
            if ($this->Transactions->save($this->request->data)) 
			{
				$account = new Account();
				$account->updateBalance($this->getUserId(), $this->request->data['Transaction']['parent_id']);
				
                $this->request->session()->setFlash(__('The Transaction has been saved'));
				
                //return $this->redirect(array('controller' => 'accounts', 'action' => 'home'));
				return $this->redirect(array('action' => 'index?filter'));
            }
			
            $this->request->session()->setFlash(__('The Transaction record could not be saved. Please, try again.'));
        } 
		else 
		{
            $this->request->data = $this->Transactions->read(null, $id);			
			
			// fix the amount
            $amount = abs(floatval($this->request->data['Transaction']['amount']));
			$this->request->data['Transaction']['amount'] = $amount;
				
            unset($this->request->data['Transaction']['password']);
			
			$user_id = $this->request->data['Transaction']['user_id'];
			
			$sub = new Subcategory;
			$records = $sub->getCategories($user_id, $this->request->data['Transaction']['category']);
			$subs = Array();
			
			$subs['0'] = '(none)';
			
			foreach($records as $rec)
				$subs[$rec['Subcategory']['id']] = $rec['Subcategory']['name'];
				
			//Debugger::dump($subs);
			$this->set('subcategories', $subs);
			$this->setSubJump($user_id);
			
			$this->setSelectList(new Account, $user_id);
			$this->setSelectList(new Category, $user_id);			
        }
    }
	
    public function add($parent_id = 0) 
	{
		$user_id = $this->getUserId();
				
        if ($this->request->is('post')) 
		{
            $this->Transactions->create();
				
			// add user
			$this->request->data['Transaction']['user_id'] = $user_id;
			
			if (intval($this->request->data['Transaction']['type']) == 1)
			{
				$amount = floatval($this->request->data['Transaction']['amount']);
				$this->request->data['Transaction']['amount'] = -$amount;
			}
			
			//Debugger::dump($this->request->data);die;
			
            if ($this->Transactions->save($this->request->data)) 
			{
				$account = new Account();
				$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			
                $this->request->session()->setFlash(__('The Transaction record has been saved'));
				
				$repeat = (array_key_exists('checkboxsaveandadd', $this->request->data) && $this->request->data['checkboxsaveandadd'] == 1);
				
				if ($repeat)
					return $this->redirect(array('action' => 'add/' . $parent_id));
				else
					return $this->redirect(array('action' => 'index?filter'));
            }
            $this->request->session()->setFlash(
                __('The Transaction record could not be saved. Please, try again.')
            );
        }
		else
		{
			$this->request->data['Transaction']['date'] = date('Y-m-d'); 
			$this->request->data['Transaction']['type'] = 1; // default to debit
			
			//$parent_id
			$this->setSelectList(new Account, $user_id, '(Select Account)');
			$this->set('selected_parent', $parent_id);
			
			$this->set('subcategories', array('(Select Subcategory)'));			
			$this->setSelectList(new Category, $user_id, '(Select Category)');			
			$this->setSubJump($user_id);
		}
    }

   public function checkEmailYahooNOTUSED($debug = false) 
	{
		$flash = '';
		$errors = '';
		$count_trx = 0;
		$this->autoRender = false;
		
		// To connect to imap server on port 993
		$mbox = imap_open("{imap.mail.yahoo.com:993/imap/ssl}Sent", "username goes here", "password goes here");

		if ($mbox != NULL)
		{
			$num = imap_num_msg($mbox); 
			
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
				$count = 0;
				//foreach ($headers as $val)
				$num = 2;
				for ($i = 1; $i <= $num; $i++)
				{
				    $uid = imap_uid($mbox, $i);

					$body_raw = $this->getBody($uid, $mbox);
					echo '<p>' . $body_raw . '</p>';
					//die;
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
			echo CRLF . 'flash=' . $flash . CRLF;
		}
		else
		{
			$flash = 'No Email Transactions Found';
			
			if ($count_trx > 0)
				$flash = 'Transactions added from Email: ' . $count_trx;
		}
			
		$this->request->session()->setFlash(__($flash));
		
		if ($debug)
		{
			echo CRLF . 'flash=' . $flash;
			echo "<br/><br/><a href='/transactions/index?mon=curr'>Return to Transactions</a>";
			die;
		}
		
		return $this->redirect(array('controller' => 'transactions', 'action' => 'index', '?mon=curr'));
	}
	
	public function getBody($uid, $imap) {
		$body = $this->get_part($imap, $uid, "TEXT/HTML");
		// if HTML body is empty, try getting text body
		if ($body == "") {
			$body = $this->get_part($imap, $uid, "TEXT/PLAIN");
		}
		return $body;
	}

	public function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false) {
		if (!$structure) {
			   $structure = imap_fetchstructure($imap, $uid, FT_UID);
		}
		if ($structure) {
			if ($mimetype == $this->get_mime_type($structure)) {
				if (!$partNumber) {
					$partNumber = 1;
				}
				$text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
				switch ($structure->encoding) {
					case 3: return imap_base64($text);
					case 4: return imap_qprint($text);
					default: return $text;
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

	public function get_mime_type($structure) {
		$primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

		if ($structure->subtype) {
		   return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
		}
		return "TEXT/PLAIN";
	}	

	public function getAccountId($account)
	{
		$accountId = EMAIL_CAPGRAY_ID;

		if ($account === EMAIL_CHASE_ACCOUNT)
			$accountId = EMAIL_CHASE_ID;
		else if ($account === EMAIL_CAPGRAY_ACCOUNT)
			$accountId = EMAIL_CAPGRAY_ID;
		else if ($account === EMAIL_CAPBLUE_ACCOUNT)
			$accountId = EMAIL_CAPBLUE_ID;
			
		return $accountId;
	}	
    	
    public function checkEmail($debug = false) 
	{
		$dataSource = ConnectionManager::getDataSource('default');
		$email_account = $dataSource->config['email_account'];
		$email_password = $dataSource->config['email_password'];
		//die($email_password);

		$debug = false;
		
		$flash = '';
		$errors = '';
		$count_trx = 0;
		$this->autoRender = false;
		
		// To connect to imap server on port 993
		$mbox = imap_open("{imap.gmail.com:993/imap/ssl}INBOX", $email_account, $email_password);
		//echo 'mbox = ' . $mbox;die;

		if ($mbox != NULL)
		{
			$num = imap_num_msg($mbox); 
			//echo 'num = ' . $num;//die;

			//if there is a message in your inbox
			if( $num > 0 )
			{
				//read that mail recently arrived
				//echo imap_qprint(imap_body($imap, $num));
				//die;
			}

			$headers = imap_headers($mbox);

			if ($headers == false) // no email found
			{
				$flash = "No Email Messages Found";
				//die($flash);
				$this->request->session()->setFlash(__($flash));				
				return $this->redirect(array('controller' => 'transactions', 'action' => 'index', '?mon=curr'));
			}
			else
			{
				$count = 0;
				foreach ($headers as $val) 
				{
					$count++;
					$date = NULL;
					$amount = 0.0;
					$desc = '';
					$add = false;
					$accountId = 0;
					
					if ($this->checkCapital($mbox, $count, $val, $date, $amount, $desc, $accountId, $debug))
					{
						$add = true;
					}
					else if ($this->checkChase($mbox, $count, $val, $date, $amount, $desc, $accountId, $debug))
					{
						$add = true;
					}
					else if ($this->checkManual($mbox, $count, $val, $date, $amount, $desc, $accountId, $debug))
					{
						$add = true;
					}
					else
					{
					}
					
					if ($add)
					{
						if ($debug)
						{
							echo 'date=' . $date->format('Y-m-d'). CRLF; 
							echo 'amount=' . $amount . CRLF; 
							echo 'desc=' . $desc . CRLF; 
						}
												
						if ($this->addExternal($date, $amount, $desc, $accountId, $debug))
						{
							$count_trx++;

							if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
							{
								// don't delete the email message during dev
							}
							else
							{
								// delete the transaction email
								//die('delete');
								
								if ($debug)
								{
									// don't delete emails during dev
								}
								else
								{
									//die('do not do: imap_delete');
									imap_delete($mbox, $count);
								}
							}

							if ($debug) // only do one at a time
							{
								break;
							}
						}
					}
					else
					{
						// delete all other emails since they've already been forwarded
						imap_delete($mbox, $count);
					}
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
				$flash = 'Transactions added from Email: ' . $count_trx;
		}
			
		$this->request->session()->setFlash(__($flash));
		
		if ($debug)
		{
			echo 'flash=' . $flash;
			echo "<br/><br/><a href='/transactions/index?mon=curr'>Return to Transactions</a>";
			die;
		}
		
		return $this->redirect(array('controller' => 'transactions', 'action' => 'index', '?mon=curr'));
	}
	
	public function checkManual($mbox, $count, $val, &$date, &$amount, &$desc, $debug) 
	{
		$debug = false;
		
		$rc = false; 
		$subject = 'cash';
					
		$pos = strpos($val, $subject);
										
		$sample = "8/5:Haircut:12.35";
		
		if ($pos !== false && $pos == 44) 
		{
			//die('val=' . $val . ', pos=' . $pos);
			
			$rc = true; // transaction found
			//echo 'pos = ' . $pos . CRLF;
						
			// get the body
			$body_raw = imap_body($mbox, $count);
						
			$body_start = 'cash:';
			$pos = strpos($body_raw, $body_start);
			//echo 'pos=' . $pos . CRLF;
			if ($pos === false)
			{
				die('parse: start key not found in body raw: ' . CRLF . $body_raw);
			}
						
			$body_raw = substr($body_raw, $pos + strlen($body_start), 20);
			
			$parts = explode(':', $body_raw);
			
			if ($debug)
				Debugger::dump($parts);
			
												
			// get the amount
			$amount = preg_replace("/[\n\r]/", " ", $parts[2]);
			$amount = explode(" ", $amount); // split on spaces to leave just the amount part
			
			if ($debug)
				Debugger::dump($amount);
				
			$amount = floatval(trim($amount[0], '$'));
			$amount = -$amount;
			
						
			// get the date
			$date = DateTime::createFromFormat('m/d', $parts[0]);
			if ($date == NULL)
			{
				die("Date conversion failed, from text: " . $date);
			}
									
			// get the description
			$desc = $parts[1];
						
			if ($debug)
			{
				echo 'pos=' . $pos . ', val=' . $val . CRLF;
				echo 'body=' . $body_raw . CRLF;
				echo 'desc=' . $desc . CRLF; 
				echo 'amount=' . $amount . CRLF; 
				echo 'date=' . $date->format('Y-m-d') . CRLF; 
				//die('*** end of debug ***');
			}

			//echo 'Record:' . $account_raw . '::' . $amount . '::' . $date->format('Y-m-d') . '::' . $desc;die;
		}
		
		return $rc;
	}
	
	public function checkCapital($mbox, $count, $val, &$date, &$amount, &$desc, &$accountId, $debug)
	{
		if ($debug)
		{
			echo CRLF . '*** DEBUG, checkCapital() ***' . CRLF;
		}
		
		$rc = false; 
		$subject = 'A new transaction was';
					
		$pos = strpos($val, $subject);
										
		$sample = "A purchase was charged to your account. RE: Account ending in 6789 SCOTT, As requested, we're notifying you that on SEP 30, 2016, at USA*CANTEEN VENDING, a pending authorization or purchase in the amount of $1.00 was placed or charged on your Capital One VISA SIGNATURE account.";
				
		if ($pos !== false && $pos == 44) 
		{
			$rc = true; // transaction found
			//echo 'pos = ' . $pos . CRLF;
						
			// get the body
			$body_raw = imap_body($mbox, $count);
						
			$pos = strpos($body_raw, substr($sample, 0, 30));
			//echo 'pos=' . $pos . CRLF;
			if ($pos === false)
			{
				echo 'body raw = ' . $body_raw . CRLF;
				echo 'sample = ' . substr($sample, 0, 30) . CRLF;
				die('*** DEBUG, parse: info text not found in body raw ***');
			}
						
			$body_raw = substr($body_raw, $pos, strlen($sample));
												
			// get the amount
			$amount = $this->parseTag($body_raw, 'purchase in the amount of ', 10, 0); 
			$amount = floatval(trim($amount, '$'));
			$amount = -$amount;
						
			// get the date
			$date_raw = $this->parseTag($body_raw, 'notifying you that on ', 12, -1); 
			$date2 = str_replace(',', '', $date_raw);
			$date = DateTime::createFromFormat('M d Y', $date2);
			if ($date == NULL)
			{
				die("Date conversion failed, from text: " . $date2);
			}
									
			// get the account number, last four digits
			$account = $this->parseTag($body_raw, 'RE: Account ending in ', 4, -1); 
			$accountId = $this->getAccountId($account);

			// get the description
			$desc = $this->parseTag($body_raw, $date_raw . ', at ', 30, -1); 
			$pieces = explode(',', $desc);
			$desc = $pieces[0];
						
			if ($debug)
			{
				echo 'pos=' . $pos . ', val=' . $val . CRLF;
				echo 'body=' . $body_raw . CRLF;
				echo 'account=' . $account . CRLF; 
				echo 'accountId=' . $account . CRLF; 
				echo 'desc=' . $desc . CRLF; 
				//die('*** end of debug ***');
			}
			
			//echo 'Record:' . $account_raw . '::' . $amount . '::' . $date->format('Y-m-d') . '::' . $desc;
		}
		
		return $rc;
	}
	
	public function checkChase($mbox, $count, $val, &$date, &$amount, &$desc, &$accountId, $debug) 
	{
		$rc = false; 
		$subject = 'Your Single Transaction';
					
		$pos = strpos($val, $subject);
					
		$sample = "This is an Alert to help you manage your credit card account ending in 2117.  As you requested, we are notifying you of any charges over the amount of (\$USD) 0.01, as specified in your Alert settings. A charge of (\$USD) 80.20 at WAL-MART #2516 has been authorized on 04/03/2017 11:02:20 PM EDT.";

		//echo '<br/>' . $val . '<br/>pos=' . $pos; die;
		if ($pos !== false && $pos == 44) 
		{
			$rc = true; // transaction found
			//echo 'pos = ' . $pos . CRLF;
						
			// get the body
			$body_raw = imap_body($mbox, $count);
						
			$pos = strpos($body_raw, substr($sample, 0, 76));
			if ($pos === false)
			{
				echo $body_raw . CRLF;
				die('parse: info text not found in body raw');
			}
			//echo 'pos=' . $pos . CRLF;die;
						
			$body_raw = substr($body_raw, $pos, strlen($sample));
												
			// get the amount
			$amount = $this->parseTag($body_raw, 'A charge of ($USD) ', 10, 0); 
			$amount = floatval(trim($amount, '$'));
			$amount = -$amount;
						
			// get the date
			$date_raw = $this->parseTag($body_raw, 'has been authorized on ', 10, -1); 
			$date2 = str_replace(',', '', $date_raw);
			//echo '|' . $date2 . '|';
			$date = DateTime::createFromFormat('m/d/Y', $date2);
			//debug($date);die;
			if ($date == NULL)
			{
				die("Date conversion failed, from text: " . $date2);
			}
									
			// get the account number, last four digits
			$account = $this->parseTag($body_raw, 'account ending in ', 4, -1); 
			$accountId = $this->getAccountId($account);

			// get the description
			$desc = $this->parseTag($body_raw, 'A charge of ($USD) ', 30, -1); 
			$pieces = explode(' ', $desc);
			//debug($pieces);
			$desc = $pieces[2];
			if ($pieces[3] !== 'has')
				$desc .= ' ' . $pieces[3];
						
			if ($debug)
			{
				echo 'pos=' . $pos . ', val=' . $val . CRLF;
				echo 'body=' . $body_raw . CRLF;
				echo 'account=' . $account . CRLF; 
				echo 'accountId=' . $account . CRLF; 
				//die('*** end of debug ***');
			}

			//echo 'Record::' . $account . '::' . $amount . '::' . $date->format('Y-m-d') . '::' . $desc . '<BR/>';
		}
		
		return $rc;
	}
		
	public function parseTag($text, $tag, $length, $wordIndex) 
	{
		$pos = strpos($text, $tag);
		$target = substr($text, $pos + strlen($tag), $length);
		//debug($target);
		if ($wordIndex >= 0)
		{
			$words = explode(" ", $target);	
			$target = $words[$wordIndex];
		}
		
		return $target;
	}
	
    public function addExternal($date, $amount, $desc, $accountId, $debug) 
	{ 	
		$rc = false;
		
		$this->Transactions->create();

		$user_id = $this->getUserId();
	
		$this->request->data['Transaction']['user_id'] = $user_id;
		$this->request->data['Transaction']['date'] = $date->format('Y-m-d'); 
		$this->request->data['Transaction']['amount'] = $amount;
			
		// remove all non-alphas from desc
		$desc = preg_replace("/(\W)+/", " ", $desc);
		$trx = $this->Transactions->getByTag($desc);

		// set account
		$this->request->data['Transaction']['parent_id'] = $accountId;
		
		// copy from first transaction from this vendor
		if ($trx != NULL)
		{		
			$this->request->data['Transaction']['subcategory'] = $trx[0]['Transaction']['subcategory'];
			$this->request->data['Transaction']['category'] = $trx[0]['Transaction']['category'];
			$this->request->data['Transaction']['description'] = $trx[0]['Transaction']['description'];
			$this->request->data['Transaction']['notes'] = '';
			$this->request->data['Transaction']['type'] = $trx[0]['Transaction']['type'];
		}
		else // create first record from this vendor, using defaults
		{
			// default to food::groceries
			$this->request->data['Transaction']['subcategory'] = 2; // food
			$this->request->data['Transaction']['category'] = 2;	// groceries
			$this->request->data['Transaction']['description'] = ucfirst(strtolower(strtok($desc, " ")));			
			$this->request->data['Transaction']['notes'] = $desc;
			$this->request->data['Transaction']['type'] = 1;
		}
		
		//Debugger::dump($this->request->data);		
		
		if ($this->Transactions->save($this->request->data)) 
		{
			$account = new Account();
			$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			$rc = true;
		}
		else
		{
			Debugger::dump($this->request->data);
			die;
		}
		
		return $rc;
    }	
	
	public function delete($id) 
	{
        //$this->request->allowMethod('post');
		$user_id = $this->getUserId();
		
        $this->Transactions->id = $id;
        $this->request->data = $this->Transactions->read(null, $id);			
		
        if (!$this->Transactions->exists()) {
            throw new NotFoundException(__('Invalid Transaction'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) 
		{
			if ($this->Transactions->delete()) 
			{
				$account = new Account();
				$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			
				$this->request->session()->setFlash(__('Transaction deleted'));
				return $this->redirect(array('action' => 'index?filter'));
			}
			
			$this->request->session()->setFlash(__('Transaction record was not deleted'));
			
			return $this->redirect(array('action' => 'index?filter'));
		}
		else
		{
            $this->request->data = $this->Transactions->read(null, $id);			
			
			// fix the amount
            $amount = abs(floatval($this->request->data['Transaction']['amount']));
			$this->request->data['Transaction']['amount'] = $amount;
				
            unset($this->request->data['Transaction']['password']);
			
			$user_id = $this->request->data['Transaction']['user_id'];
			
			$sub = new Subcategory;
			$records = $sub->getCategories($user_id, $this->request->data['Transaction']['category']);
			$subs = Array();
			
			$subs['0'] = '(none)';
			
			foreach($records as $rec)
				$subs[$rec['Subcategory']['id']] = $rec['Subcategory']['name'];
				
			//Debugger::dump($subs);
			$this->set('subcategories', $subs);
			$this->setSubJump($user_id);
			
			$this->setSelectList(new Account, $user_id);
			$this->setSelectList(new Category, $user_id);			
		}
    }
	
    public function transfer($parent_id = 0) 
	{
		$user_id = $this->getUserId();
		
        if ($this->request->is('post')) 
		{
            $this->Transactions->create();
		
			$accountFrom = $this->request->data['Transaction']['account_from'];
            unset($this->request->data['Transaction']['account_from']);
			
			$accountTo = $this->request->data['Transaction']['account_to'];
            unset($this->request->data['Transaction']['account_to']);
			
			$amount = floatval($this->request->data['Transaction']['amount']);

			$this->request->data['Transaction']['user_id'] = $user_id;
			$this->request->data['Transaction']['category'] = 9; //sbw fix me hardcoded
			$this->request->data['Transaction']['description'] = 'Transfer';
			
			//
			// save FROM account transaction
			//
			$this->request->data['Transaction']['parent_id'] = $accountFrom;
			$this->request->data['Transaction']['amount'] = -$amount;
			$this->request->data['Transaction']['type'] = 1; // debit
			
			//Debugger::dump($this->request->data);exit;
			
            if ($this->Transactions->save($this->request->data)) 
			{
				$account = new Account();
				$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			
				//
				// save TO account transaction
				//
				$this->Transactions->create();
				
				$this->request->data['Transaction']['parent_id'] = $accountTo;
				$this->request->data['Transaction']['amount'] = $amount;
				$this->request->data['Transaction']['type'] = 2; // credit
				
				if ($this->Transactions->save($this->request->data)) 
				{
					$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
						
					$this->request->session()->setFlash(__('The Transfer has been saved'));
				
					return $this->redirect(array('action' => 'index'));
				}
				else
				{
					$this->request->session()->setFlash(__('The Transfer failed, bad "TO" account'));
				}
            }
			else
			{
				$this->request->session()->setFlash(__('The Transfer failed, bad "From" account'));
			}
        }
		else
		{
			$this->request->data['Transaction']['date'] = date('Y-m-d'); 
			
			$accountFrom = new Account;
			$select = $accountFrom->getSelectList($user_id, '');
			$this->set('accountFrom', $select);
			$this->set('selected_parent', $parent_id);

			$accountTo = new Account;
			$select = $accountTo->getSelectList($user_id, '');
			$this->set('accountTo', $select);
			$this->set('selected_parent', $parent_id);
		}
    }	
	
	 public function expenses($month = 0, $year = 0) 
	{
		$user_id = $this->getUserId();

		$month = intval($month);
		if ($month == 0)
			$month = intval(date('m'));

		$year = intval($year);
		if ($year == 0)
			$year = intval(date('Y'));
		
		//
		// get expenses for breakdown
		//
	
		if ($month == 0)
		{
			$date = $this->getCurrMonth(0);
			$month = getDate($date)['mon'];	
			$expense = array();
			while ($month > 0)
			{
				$expenses = $this->Transactions->getExpenses($user_id, $month, $year);	
				
				if (!empty($expenses))
					break;
					
				$month--;
			}
			
			$date = $this->getMonth($month);
			$smonth = getDate($date)['month'];
		}
		else
		{
			$date = $this->getMonth($month);
			$smonth = getDate($date)['month'];
			$expenses = $this->Transactions->getExpenses($user_id, $month, $year);
		}
		//Debugger::dump($expenses[0]); //die;
		
		$this->set('expenses', $expenses);
		$this->set('smonth', $smonth);
		$this->set('month', $month);
		$this->set('year', $year);

		// get month menu links
		$monthLinks = $this->getMonthLinks();
		$this->set('monthLinks', $monthLinks);

	}
	
	public function dupe($id = 0) 
	{		
		$user_id = $this->getUserId();

        if ($this->request->is('post') || $this->request->is('put')) 
		{			
            $this->Transactions->create();
				
			// add user
			$this->request->data['Transaction']['user_id'] = $user_id;
			
			if (intval($this->request->data['Transaction']['type']) == 1)
			{
				$amount = floatval($this->request->data['Transaction']['amount']);
				$this->request->data['Transaction']['amount'] = -$amount;
			}
			
            if ($this->Transactions->save($this->request->data)) 
			{
				$account = new Account();
				$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			
                $this->request->session()->setFlash(__('The Transaction record has been saved'));
				
				//$repeat = array_key_exists('checkboxsaveandadd', $this->request->data);
				//if ($repeat)
				//	return $this->redirect(array('action' => 'add/' . $parent_id));
				//else
				return $this->redirect(array('action' => 'index?filter'));
            }
            $this->request->session()->setFlash(
                __('The Transaction record could not be saved. Please, try again.')
            );
        }
		else 
		{
			$this->Transactions->id = $id;
			
			if (!$this->Transactions->exists()) 
			{
				throw new NotFoundException(__('Invalid Transaction record'));
			}

            $this->request->data = $this->Transactions->read(null, $id);			
			
			// fix the amount
            $amount = abs(floatval($this->request->data['Transaction']['amount']));
			$this->request->data['Transaction']['amount'] = $amount;
				
			// set to current date
			$this->request->data['Transaction']['date'] = date('Y-m-d'); 
									
            unset($this->request->data['Transaction']['password']);
			
			$user_id = $this->request->data['Transaction']['user_id'];
			
			$sub = new Subcategory;
			$records = $sub->getCategories($user_id, $this->request->data['Transaction']['category']);
			$subs = Array();
			
			$subs['0'] = '(none)';
			
			foreach($records as $rec)
				$subs[$rec['Subcategory']['id']] = $rec['Subcategory']['name'];
				
			//Debugger::dump($subs);
			$this->set('subcategories', $subs);
			$this->setSubJump($user_id);
			
			$this->setSelectList(new Account, $user_id);
			$this->setSelectList(new Category, $user_id);			
        }
	}
	
	public function post($recurringtrx_id = 0) 
	{		
		$user_id = $this->getUserId();

        if ($this->request->is('post') || $this->request->is('put')) 
		{			
            $this->Transactions->create();
				
			// add user
			$this->request->data['Transaction']['user_id'] = $user_id;
			
			if (intval($this->request->data['Transaction']['type']) == 1)
			{
				$amount = floatval($this->request->data['Transaction']['amount']);
				$this->request->data['Transaction']['amount'] = -$amount;
			}
			
            if ($this->Transactions->save($this->request->data)) 
			{
				$account = new Account();
				$account->updateBalance($user_id, $this->request->data['Transaction']['parent_id']);
			
                $this->request->session()->setFlash(__('The Transaction record has been saved'));
				
				$repeat = array_key_exists('checkboxsaveandadd', $this->request->data);
				if ($repeat)
					return $this->redirect(array('action' => 'add/' . $parent_id));
				else
					return $this->redirect(array('controller' => 'accounts', 'action' => 'home'));
            }
            $this->request->session()->setFlash(
                __('The Transaction record could not be saved. Please, try again.')
            );
        }
		else 
		{
			$this->Transactions->id = $recurringtrx_id;
			
			if (!$this->Transaction->exists()) 
			{
				throw new NotFoundException(__('Invalid Transaction record'));
			}

            $this->request->data = $this->Transactions->read(null, $recurringtrx_id);			
			
			// fix the amount
            $amount = abs(floatval($this->request->data['Transaction']['amount']));
			$this->request->data['Transaction']['amount'] = $amount;
				
			// move up the month
			$test = new DateTime($this->request->data['Transaction']['date']);
			$date = mktime(0, 0, 0, date_format($test, 'm') + 1, date_format($test, 'd'), date_format($test, 'Y'));
			
			$this->request->data['Transaction']['date'] = date('Y-m-d', $date);
									
            unset($this->request->data['Transaction']['password']);
			
			$user_id = $this->request->data['Transaction']['user_id'];
			
			$sub = new Subcategory;
			$records = $sub->getCategories($user_id, $this->request->data['Transaction']['category']);
			$subs = Array();
			
			$subs['0'] = '(none)';
			
			foreach($records as $rec)
				$subs[$rec['Subcategory']['id']] = $rec['Subcategory']['name'];
				
			//Debugger::dump($subs);
			$this->set('subcategories', $subs);
			$this->setSubJump($user_id);
			
			$this->setSelectList(new Account, $user_id);
			$this->setSelectList(new Category, $user_id);			
        }
	}
	
    public function hasher() 
	{
        if ($this->request->is('post')) 
		{
			$hash = $this->getHash($this->request->data['Transaction']['search']);
			
			$this->set('hash', $hash);
		}
		
        $this->set('users', $this->paginate());
    }
	
    public function getHash($text) 
	{
		$s = sha1(trim($text));
		$s = str_ireplace('-', '', $s);
		$s = strtolower($s);
		$s = substr($s, 0, 8);
		$final = '';

		for ($i = 0; $i < 6; $i++)
		{
			$c = substr($s, $i, 1);
				
			if ($i % 2 != 0)
			{
				if (ctype_digit($c))
				{
                    if ($i == 1)
                    {
                        $final .= "Q";
                    }
                    else if ($i == 3)
                    {
                        $final .= "Z";
                    }
                    else
                    {
                        $final .= $c;
                    }
				}
				else
				{
					$final .= strtoupper($c);
				}
			}
			else
			{
				$final .= $c;
			}
		}

		// add last 2 chars
		$final .= substr($s, 6, 2);
		
		//echo $final;
		
		return $final;
	}	
}
