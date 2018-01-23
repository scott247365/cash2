<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\I18n\I18n;
use Cake\Core\Exception\Exception;
use Cake\Core\Configure;
use Cake\Error\Debugger;

// domain name constants
define('APP_NAME' , 'Cash');
define('DOMAIN_NAME' , 'cash.scotthub.com');
define('URL_BASE', 'http://' . DOMAIN_NAME);
define('URL_DEBUG', 'http://localhost');
define('EMAIL_ADMIN', 'admin@' . DOMAIN_NAME);
define('SITE_CONTACT_EMAIL', 'info@' . DOMAIN_NAME);

define('TYPE1', 1);
define('TYPE2', 2);
define('TYPE3', 3);
define('TYPE4', 4);
define('TYPE5', 5);
define('TYPE6', 6);
define('TYPE7', 7);

define('TYPEEMAIL', 1);
define('TYPEDEL', 4);
define('TYPESTEPS', 5);
define('TYPECANNED', 6);
define('TYPETEMPLATES', 7);

define('TAG1', 'Emails');
define('TAG2', 'not used 0');
define('TAG3', 'Notes');
define('TAG4', 'DEL');
define('TAG5', 'Steps');
define('TAG6', 'Canned');
define('TAG7', 'Templates');
define('TAGSHARED', 'Shared');

define('BODYSTYLE', '<span style="color:green;">');
define('ENDBODYSTYLE', '</span>');


// misc constants
define('CATEGORY_QNA', 'qna');

// user types
define('USERTYPE_PENDING'	, 0); 	// registered, email not verified
define('USERTYPE_USER'		, 10);	// registered, email verified
define('USERTYPE_REPORTER'	, 20);	// can see reports
define('USERTYPE_ADMIN'		, 100);	// super-user, can do anything

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	protected $nonAdminActions = array(); // set template for normal or admin functions
	protected $isLoggedIn = false;
	protected $isAdmin = false;
	protected $userName = null;
	protected $userId = false;
	
    public $helpers = array('Custom');		
	
	public function isLoggedIn() {	
		return $this->Auth->user();
	}
	public function isAdmin() {	
		return ($this->Auth->user()['user_type'] === USERTYPE_ADMIN);
	}
	
    public function isDebug() {
		return Configure::read('debug');
	}
    public function isForceDebug() {
		//return true;
		return false;
	}

	private $userlayout = false;
	public function getUserLayout() {
		return $this->userlayout;
	}
		
    /**
     * checkLogin method
     *
     * @return bool for logged in or not
     */
	public function checkLogin()
	{
		$userName = false;
		$userId = false;
		$isLoggedIn = $this->isLoggedIn();
		
		if ($isLoggedIn)
		{
			//Debugger::dump($this->Auth->user());die;
			$userName = $this->Auth->user()['firstName'];
			if (empty($userName))
			{
				$userName = $this->Auth->user()['email'];
				if (empty($userName))
				{
					$userName = 'anon';
				}
			}			
				
			$userId = $this->Auth->user()['id'];
			//dump($this->Auth->user());die;
		}
		
		$this->set('isLoggedIn', $isLoggedIn);
		$this->set('userName', $userName);
		$this->set('userId', $userId);
		
		return $isLoggedIn;
	}
	
    /**
     * beforeFilter method
     *
     * @return void
     */
	public function beforeFilter(\Cake\Event\Event $event)
	{	
		// check if user is logged in
		$this->checkLogin();

		// set language
		$language = $this->request->session()->read('Settings.Language');
		if (mb_strlen($language) > 0)
			I18n::locale($language);
		
		// set default layout
		$this->userlayout = 'default';
		$this->set('urlContact', '/contacts/add');
		
		if (in_array($this->request->params['action'], $this->nonAdminActions))
		{
			$this->viewBuilder()->layout('default');
		}
		else
		{
			$this->viewBuilder()->layout('default');
		}
		
		$this->set("search", "");
		$this->set('isAdmin', $this->isAdmin());
		$this->set('allowTranslate', $this->isAdmin());		
	}

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initializeORIG()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }
	
    public function initialize()
    {
        parent::initialize();
	
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
			'authorize'=> 'Controller',//added this line
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
			'loginRedirect' => [
                'controller' => 'Entries',
                'action' => 'index'        
			],
			'logoutRedirect' => [
                'controller' => 'Entries',
                'action' => 'index'        
			],
		]);

        // Allow the display action so our pages controller continues to work.
        $this->Auth->allow(['display']);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }		
    }
	
    /**
     * Check if user is authorized to perform an action, turn off all by default
     *
     * @param $usre to check
     * @return bool for is authorized
     */
	public function isAuthorized($user)
	{
		// Admin can access every action
		if ($user['user_type'] >= USERTYPE_ADMIN)
		{
			return true;
		}

		// Default deny
		return true; //sbw: false causes a redirect loop
	}	
	
    /**
     * Get datetime for today starting at 00:00:00
     *
     * @return Time object
     */
	public function getToday(&$start, &$end, $localTimezone = "America/Chicago")
	{
		// get the date/time in local timezone
		$today = new Time("", $localTimezone);
				
		$this->getDayUtc($today->format("Y/m/d"), $start, $end, $localTimezone);
	}
	
	public function getDay($dayOffset, &$start, &$end, $localTimezone = "America/Chicago")
	{
		// get the date/time in local timezone
		$today = new Time("", $localTimezone);

		$today->addDays($dayOffset);
				
		$this->getDayUtc($today->format("Y/m/d"), $start, $end, $localTimezone);
	}
	
    /**
     * Get datetime range for today from at 00:00:00 to 23:59:59
     *
     * @return none
     */
	public function getDayUtc($date, &$start, &$end, $localTimezone)
	{
		// get the date/time in local timezone
		$day = new Time($date, $localTimezone);
		$start = new Time($day->format("Y/m/d"), "America/Chicago"); // peel off the time, leave the date only
		$end = new Time($day->format("Y/m/d 23:59:59"), "America/Chicago");

		// change them to utc for the 
		$start->timezone = "UTC";
		$end->timezone = "UTC";		
		
		//debug($start);
		//debug($end);
		//die;
	}
	
    /**
     * Converts form request fields to a Time object for the specified timezone
     *
     * @return Time object
     */
	public function fixTimeZone($dt, $tzFrom, $tzTo)
    {		
		$time = new Time(sprintf("%d-%.02d-%.02d %.02d:%.02d:00"
			, $dt['year']
			, $dt['month']
			, $dt['day']
			, $dt['hour']
			, $dt['minute']
		), $tzFrom);
		
		$time->timezone = $tzTo;
	
		return $time;
	}	

	function cleanPunct($input) {
		return str_replace('', $input);
	}	
	
	function cleanInput($input) {
	 
	  $search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@',        // Strip multi-line comments
		);
	 
		$output = preg_replace($search, '', $input);
		
		return $output;
	}

	function sanitize($input) {
		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = sanitize($val);
			}
		}
		else {
		
			$before = $input;
		
			if (get_magic_quotes_gpc()) {
				$input = stripslashes($input);
			}
			
			$output  = $this->cleanInput($input);
			//$output = mysqli::real_escape_string ($output);
			
			// anything dangerous stripped?
			if ($before !== $output)
			{
				// shows 500 page
				//debug($output);
				//die;
				
				throw new Exception('Dangerous Input Detected: code injection profile.');
			}
		}
		
		return $output;
	}

    /**
     * Add multiple method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
	 
    public function makeDashed($text)
    {		
		$nick = strtolower(trim($text));
		
		$nick = $this->scrubPunct($nick);
		
		$nick = $this->scrubSpaces($nick);
		
		$nick = str_replace(' ', '-', $nick); // make-nickname-dashed
		
		return $nick;
	}

    public function scrubSpaces($text)
    {		
		//
		// remove multiple embedded spaces
		//
		$startLength = 0;
		for ($i = 0; $startLength != strlen($text) && $i < 1000; $i++) // added 1000 just to make non-infinite
		{
			$startLength = strlen($text);
			$text = str_replace('  ', ' ', $text); // removed extra spaces until no more exist
		}
		
		return $text;
	}
	
    public function scrubDangerous($text)
    {		
		//
		// remove dangerous punctuation
		//
		$text = str_replace(array('`','~','\'','"','|','^'), '', $text); 

		return $text;
	}
	
    /**
     * scrubInput method
     *
     * @return scrubbed input text
     */
    private function scrubInputHeavy($text)
    {
		$text = trim($text);					// whitespace
		$text = $this->scrubDangerous($text); 	// dangerous punct
		$text = $this->sanitize($text);			// dangerous text
		$text = $this->scrubSpaces($text);		// embedded spaces

		return $text;
	}	
	
	private function scrubInputLight($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		
		$data = $this->scrubSpaces($data); // remove embedded spaces
	  
		return $data;
	}	
	
	protected function scrubInput($data) 
	{
		//$data = $this->scrubInputHeavy($data);
		$data = $this->scrubInputLight($data);
		
		return $data;
	}	
	
    public function fixHtml($text)
    {		
		//
		// make it html friendly
		//
		$text = str_replace('<', '&lt;', $text); 
		$text = str_replace('>', '&gt;', $text); 
		
		return $text;
	}	
	
    public function scrubPunct($text)
    {		
		$text = $this->scrubDangerous($text);
		$text = $this->fixHtml($text);
	
		// first keyboard row
		$text = str_replace(array('!','@','#','$','%','^','&','*','(',')','_','-','+','='), '', $text); 
		
		// 2nd keyboard row
		$text = str_replace(array('[','{','}',']','|','\\'), '', $text); 
		
		// 3nd keyboard row
		$text = str_replace(array(';',':','\'','"'), '', $text); 
		
		// 4th keyboard row		
		$text = str_replace(array('<',',','.','>','/','?'), '', $text); 
				
		return $text;
	}	
		
	function sendEmail($fromEmail, $subject, $message)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: ' . $fromEmail . "\r\n";
				
		mail('sbwilkinson1@gmail.com', $subject, $message, 'From: ' . $fromEmail);
	}

    public function setSelectList($model, $user_id, $firstEntry = '') 
	{
		$select = $model->getSelectList($user_id, $firstEntry);
		$this->set($model->useTable, $select);
	}		

    public function setSubJump($user_id) 
	{
		$s = new Subcategory;
		$subs = $s->getCategories($user_id);
		$cnt = 0;
		foreach($subs as $sub)
		{
			$subs[$cnt]['Subcategory']['type'] = $sub['Category']['type'];
			unset($subs[$cnt]['Category']);
			$cnt++;
		}
		
		//Debugger::dump($subs);//exit;
		$this->set('subjump', $subs);	
	}	
	
    public function getUserId() 
	{
		$u = $this->Auth->user();
		
		return intval($u['id']);
	}	

    public function getCurrMonth($buffer_days = 0) 
	{
		$date = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$day = getDate($date)['mday'];
		//Debugger::dump(getDate($date));die;
		
		// for the first 5 days of the month, show prev month
		if ($buffer_days > 0 && $day <= $buffer_days)
		{
			$date = mktime(0, 0, 0, date("m")-1, date("d"), date("Y"));	
		}

		return $date;
	}

	public function getMonth($month) 
	{
		$date = mktime(0, 0, 0, $month, date("d"), date("Y"));
		$day = getDate($date)['mday'];
		//Debugger::dump(getDate($date));die;

		return $date;
	}	
	
}
