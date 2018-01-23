<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\I18n\Time;

// verify/reset expire time
define('EXPIRE_HOURS', 4);
define('EXPIRE_SECONDS', (4 * 60 * 60));
define('SECONDS_PER_MINUTE', 60 * 60);

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * beforeFilter method
     *
     * @return void
     */
	public function beforeFilter(\Cake\Event\Event $event)
    {
		parent::beforeFilter($event);
		
		$this->nonAdminActions = array('index', 'edit', 'login', 'logout', 'signup', 'verify', 'verifyResend', 'verifyUpdate', 'forgot', 'resetpassword', 'resetuserpassword');
		
		$this->Auth->allow(['logout', 'login', 'signup', 'verify', 'verifyResend', 'verifyUpdate', 'forgot', 'resetpassword', 'resetuserpassword']);	
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
			$this->Flash->error('Admin Function not available');
			return $this->redirect('/');
		}

		//sbw: not used - causes a redirect loop
		return parent::isAuthorized($user);
	}	
	
    /**
     * login method
     *
     * @return void
     */
	public function login()
	{
		if ($this->request->is('post')) 
		{
			$user = $this->Auth->identify();
			
			if ($user) 
			{
				//debug($user);die;
				if (!empty($user['key_verify_email']))
				{
					$this->Auth->logout();
					
					$email = $user['email'];

					$this->Flash->error('Unable to login.');

					$this->set('confirmHdr', 'Your Email address has not been verified.');
					$this->set('confirmMsg', 'Please check your email and click on the Verify Link.<br/><br/><a href="/users/verifyResend/' . $user['key_verify_email'] . '">Click here to resend the email.</a>');

					return $this->render('message');
				}
			
				$this->Flash->success('You are now logged in.');
				$this->Auth->setUser($user);
				
				return $this->redirect($this->Auth->redirectUrl());
			}

			unset($this->request->data['password']);
			$this->Flash->error('Your username or password is incorrect.');
		}
	}	
	
    /**
     * logout method
     *
     * @return void
     */
	public function logout()
	{
		$this->Auth->logout();
		$this->Flash->success('You are now logged out.');
		return $this->redirect('/');
	}	

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		//if (!$this->isAdmin())
		//	return $this->redirect('/');

		$this->set('users', $this->paginate($this->Users));
		$this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id)
    {
        $user = $this->Users->get($id);
		
		//debug($user);die;
		
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function editadmin($id)
    {	
        $user = $this->Users->get($id);
		
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
			$user = $this->Users->patchEntity($user, $this->request->data);
																		
			if ($this->Users->save($user)) 
			{
				// update the user with the new data
				if ($this->Auth->user('id') === $user->id) 
				{
					$data = $user->toArray();
						
					unset($data['password']);

					$this->Auth->setUser($data);
					//debug($this->Auth->user());die;
						
					$user = $this->Users->get($this->Auth->user()['id']);						
				}
					
				$this->Flash->success(__('Account has been updated.'));
				return $this->redirect(['action' => 'index']);
			} 
			else 
			{
				$this->Flash->error(__('Account could not be updated. Please, try again.'));
			}
        }
		
        $this->set('user', $user);		
        $this->set('_serialize', ['user']);	
	}	
	
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id)
    {	
        //$user = $this->Users->get($this->Auth->user()['id']);
        $user = $this->Users->get($id);
		
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
			//
			// password required to update account data
			//
			$password = $this->scrubInput($this->request->data['passwordAuth']);
			unset($this->request->data['passwordAuth']);
			
			if ($user->checkPassword($password, $user['password']))
			{
				$update = $this->request->data['update'];
				
				// if updating info
				if ($update === 'info')
				{					
					$userName = $this->scrubInput($this->request->data['userName']);
					$this->request->data['userName'] = $userName;

					$firstName = $this->scrubInput($this->request->data['firstName']);
					$this->request->data['firstName'] = $firstName;

					$lastName = $this->scrubInput($this->request->data['lastName']);
					$this->request->data['lastName'] = $lastName;					
				}
				// if updating email
				else if ($update === 'email')
				{
					$email = $this->scrubInput($this->request->data['email']);
					$this->request->data['email'] = $email;
					$this->request->data['key_verify_email'] = $this->makeEmailKey($user['firstName'], $email);
					$this->request->data['key_verify_email_expire'] = $this->getExpirationTime(EXPIRE_HOURS);
				}
				// if updating email
				else if ($update === 'password')
				{
					$p1 = $this->scrubInput($this->request->data['passwordNew']);
					$p2 = $this->scrubInput($this->request->data['passwordNew2']);
					
					unset($this->request->data['passwordNew']);
					unset($this->request->data['passwordNew2']);
					
					if ($p1 !== $p2)
					{
						$this->Flash->error(__('The New Passwords do not match. Please, try again.'));
						return;
					}
					
					$this->request->data['password'] = $p1;
					//$passwordUpdate = true;
				}
				else
				{
					$this->Flash->error(__('The Account could not be updated. Please, try again.'));
				}
					
				$this->request->data['key_verify_email_expire'] = '2016-02-06 08:17:16';
				debug($this->request->data);
				$user = $this->Users->patchEntity($user, $this->request->data);
				debug($user);
				die;
				$this->flashErrors($user);
																		
				if ($this->Users->save($user)) 
				{
					// update the user with the new data
					if ($this->Auth->user('id') === $user->id) 
					{
						$data = $user->toArray();
						
						unset($data['password']);

						$this->Auth->setUser($data);
						//debug($this->Auth->user());die;
						
						// update visible username, in case it changed
						if ($update === 'info')
							$this->checkLogin(); 
						
						$user = $this->Users->get($this->Auth->user()['id']);						
					}
					
					// if email was updated, send new verification
					if ($update === 'email')
					{
						if ($this->isDebug() && !$this->isForceDebug())
						{
							$link = URL_DEBUG . '/users/verify/' . $user['key_verify_email'];
							return $this->redirect($link);
						}
						else
						{
							// send verify email
							$link = URL_BASE . '/users/verify/' . $user['key_verify_email'];
							$this->sendVerifyEmail(
								$user['firstName'] . ' ' . $user['lastName']
								, $user['email']
								, $link
								, 'Verify New Email Address'
								, 'Please click this link to reset your account password:'
							);	

							// go to the verify form and show message
							return $this->redirect(['action' => 'verifyUpdate']);
						}						
					}
					
					$this->Flash->success(__('Your Account has been updated.'));
				} 
				else 
				{
					$this->Flash->error(__('The Account Info could not be updated. Please, try again.'));
				}
			}
			else
			{
                $this->Flash->error(__('Invalid Password, please try again.'));
			}			
        }
		
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete()
    {
		/* todo: implement for user's own record
	
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
		
		*/
		
        return $this->redirect('/');
    }
	
    public function signup()
    {
        $user = $this->Users->newEntity();
		
        if ($this->request->is('post')) 
		{
            $user = $this->Users->patchEntity($user, $this->request->data);
			
			$this->flashErrors($user);
									
			if (sizeof($user->errors()) > 0)
			{
                $this->Flash->error(__('Account could not be created. Please, try again.'));
			}
			else
			{
				$user['firstName'] = $this->scrubInput($user['firstName']);
				$user['lastName'] = $this->scrubInput($user['lastName']);
				$user['userName'] = $this->scrubInput($user['firstName']); // userName starts as firstName
				$user['email'] = $this->scrubInput($user['email']);
				$user['user_type'] = USERTYPE_USER;
				
				//$user['key_verify_email'] = $this->makeEmailKey($user['firstName'], $user['email']);
				//$user['key_verify_email_expire'] = $this->getExpirationTime(EXPIRE_HOURS);
				$user['ip_register'] = $this->request->clientIp();
				
				//debug($user);die;
				
				if (false && strpos($user['key_verify_email'], '/') !== false)
				{
					$this->Flash->error(__('Invalid Key Generated for Email Validation.'));
				}
				else
				{		
					$result = $this->Users->save($user);
					if ($result)
					{
						//debug($result);die;
						
						$this->Flash->success(__('User account has been created.'));
						//return $this->redirect('/entries/populate/' . $result->id);
														
						if ($this->isDebug() && !$this->isForceDebug())
						{
							$link = URL_DEBUG . '/users/verify/' . $user['key_verify_email'];
							return $this->redirect($link);
						}
						else
						{
							// send verify email
							$link = URL_BASE . '/users/verify/' . $user['key_verify_email'];
							$this->sendVerifyEmail(
								$user['firstName'] . ' ' . $user['lastName']
								, $user['email']
								, $link
								, 'Verify New Email Address'
								, 'Please click this link to reset your account password:'
							);
							
							// go to the verify form and show message
							return $this->redirect(['action' => 'verify']);
						}						
					} 
					else 
					{
						$this->Flash->error(__('Account could not be created. Please, try again.'));
					}
				}
			}
        }
		
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
	
    /**
     * verify method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function verify($key = null)
    {	
		if (empty($key))
		{
			// show results
			$this->set('confirmHdr', 'Your account has been created and a verification email has been sent to your email address.');
			$this->set('confirmMsg', 'Please check your email and click on the Verify Link.');

			$this->render('message');
		}
		else
		{
			$key = $this->sanitize($key);
		
			// key always required for reset
			if (empty($key) || gettype($key) != 'string')
			{
				return $this->redirect('/');			
			}
			
			//
			// looking up user for the reset key
			//
			$user = $this->Users
				->find('all')
				->select(['id', 'key_verify_email', 'key_verify_email_expire'])
				->where(['key_verify_email =' => $key]);
			
			if (!empty($user))
				$user = $user->first();
				
			if (!empty($user) && !empty($user['key_verify_email']))
			{
				// has token expired?
				$remainingTime = $this->timeDiff(/* now = */ time(), /* future time = */ strtotime($user['key_verify_email_expire']));//sbw
				if ($remainingTime <= 0)
				{
					$this->Flash->error(__('Verification email has expired, please try again.'));
					return $this->redirect('/users/forgot');			
				}
			
				//
				// update the user's record
				//
				$user->key_verify_email = null;
				$user->key_verify_email_expire = null;
				$user->user_type = USERTYPE_USER;
				
				//debug($user);die;
				if ($this->Users->save($user)) 
				{
					$this->Flash->success(__('Email Verified, you can now login.'));			
					$this->redirect('/users/login/');
				} 
				else 
				{
					$this->Flash->error(__('Email could not be verified. Please, try again.'));
					$this->redirect('/users/login');
				}
			}
			else
			{
				$this->Flash->error(__('Invalid or expired email verification'));
				$this->redirect('/');
			}			
		}
    }	

    /**
     * verifyUpdate method - shows updated email needs verification message
     *
     */
    public function verifyUpdate()
    {		
		// show results
		$this->set('confirmHdr', 'Your Email address and been updated and a verification Email Has Been Sent');
		$this->set('confirmMsg', 'Please check your email and click on the Verify Link');
		
		$this->render('message');
   }	

    /**
     * verifyResend method - shows updated email needs verification message
     *
     */
    public function verifyResend($key = null)
    {		
		$key = $this->sanitize($key);
		
		if (!empty($key) && gettype($key) == 'string')
		{
			//
			// looking up user for the reset key
			//
			$user = $this->Users
				->find('all')
				->select(['id', 'key_verify_email'])
				->where(['key_verify_email =' => $key]);
				
			if (!empty($user))
				$user = $user->first();
				
			if (!empty($user) && !empty($user['key_verify_email']))
			{		
				// update the verify expiration
				$data['key_verify_email_expire'] = $this->getExpirationTime2(EXPIRE_HOURS);	
				$user = $this->Users->patchEntity($user, $data);
				//debug($data);die;
				
				if ($this->Users->save($user))
				{
					// send verify email				
					if ($this->isDebug() && !$this->isForceDebug())
					{
						$link = URL_DEBUG . '/users/verify/' . $user['key_verify_email'];
						return $this->redirect($link);
					}
					else
					{
						// send verify email
						$link = URL_BASE . '/users/verify/' . $user['key_verify_email'];
						
						$this->sendVerifyEmail(
							$user['firstName'] . ' ' . $user['lastName']
							, $user['email']
							, $link
							, 'Verify New Email Address'
							, 'Please click this link to verify your email address:'
						);	

						// go to the verify form and show message
						return $this->redirect(['action' => 'verifyUpdate']);
					}
				}				
				
				// show results
				$this->set('confirmHdr', 'A verification email has been sent to your email address');
				$this->set('confirmMsg', 'Please check your email and click on the Verify Link');
				
				$this->render('message');
			}			
		}
		
		return $this->redirect('/');			
   }	
   
    /**
     *  resetuserpassword method - get user id to match the reset key, and calls the real reset
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function resetuserpassword($key = null)
    {
		$key = $this->sanitize($key);
	
		// key always required for reset
		if (empty($key) || gettype($key) != 'string')
		{
			return $this->redirect('/');			
		}
		
		//
		// looking up user for the reset key
		//
		$user = $this->Users
			->find('all')
			->select(['id', 'key_reset_password'])
			->where(['key_reset_password =' => $key]);
			
		if (!empty($user) && $user->first() != null)
		{
			$this->redirect('/users/resetpassword/' . $key . '/' . $user->first()['id']);
		}
		else
		{
			$this->Flash->error(__('Invalid or Expired Password Reset Key. Please enter Email address to reset your password again.'));
			$this->redirect('/users/forgot');
		}						
	}
	
    public function resetpassword($key = null, $id = null)
    {
		$key = $this->sanitize($key);
	
		// key always required for reset
		if (empty($key) || gettype($key) != 'string' || $id == null || intval($id) <= 0)
		{
			$this->Flash->error(__('Illegal operation.'));			
			return $this->redirect('/');			
		}
		
		$user = $this->Users->get($id);
		
		if ($user['key_reset_password'] == null)
		{
			// password has already been resetpassword OR reset wasn't requested 
			$this->Flash->error(__('Illegal operation 2.'));
			return $this->redirect('/');			
		}
		
		if ($user['key_reset_password'] !== $key)
		{			
			// password reset key doesn't match reset request
			$this->Flash->error(__('Illegal operation 3.'));
			return $this->redirect('/');			
		}

		if (empty($user['key_reset_password_expire']))
		{			
			// password has already been resetpassword OR reset wasn't requested 
			$this->Flash->error(__('Illegal operation 4.'));
			return $this->redirect('/');			
		}
		
		// has password reset token expired?
		$remainingTime = $this->timeDiff(/* now = */ time(), /* future time = */ strtotime($user['key_reset_password_expire']));
		if ($remainingTime > 0)
		{
			//debug(date('H:i:s', $remainingTime));
			//debug($exp);
			//debug($now);
			//debug($remainingTime);
			//die;
		}
		else
		{
			$this->Flash->error(__('Password reset token has expired, please try again.'));
			return $this->redirect('/users/forgot');			
		}
		
        if ($this->request->is(['patch', 'post', 'put'])) 
		{
			//
			// new password submitted
			//
			$p1 = $this->sanitize(trim($this->request->data['password']));
			$p2 = $this->sanitize(trim($this->request->data['passwordConfirm']));
						
			if ($p1 === $p2)
			{				
				$this->request->data['key_reset_password'] = null;
				$this->request->data['key_reset_password_expire'] = null;
				unset($this->request->data['passwordConfirm']);
				
				//debug($this->request->data);die;
				
				$user = $this->Users->patchEntity($user, $this->request->data);
					
				if ($this->Users->save($user)) 
				{
					$this->Flash->success(__('The new password has been saved.'));
					return $this->redirect('/users/login');
				} 
				else 
				{
					$this->Flash->error(__('The new password could not be saved. Please try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('The two passwords do not match. Please try again.'));
			}
		}

        $this->set(compact('user'));
        $this->set('_serialize', ['user']);							
	}
	
    public function timeDiff($now, $toTime)
    {
		$now = time();
		
		$diff = $toTime - $now;
		
		return $diff;
	}
	
    public function forgot()
    {
        if ($this->request->is('post')) 
		{
			$userEmail = $this->sanitize(trim($this->request->data['email']));
			
			//debug($userEmail);die;
			if (!empty($userEmail))
			{
				$this->doPasswordReset($userEmail);
			}
			else
			{
				$this->Flash->error('Invalid Email Address. Please try again.');
			}
        }
		
		//
		// Send email to reset user password form will be shown or re-shown here
		//
    }

	private function doPasswordReset($userEmail)
	{
		//
		// find user
		//				
		$user = $this->Users
					->find('all')
					->where(['email =' => $userEmail]);
				
		$rec = $user->first();
		if (isset($rec))
		{
			//
			// make user a password reset key
			//
			$key = $this->makeEmailKey($rec['firstName'], $rec['email']);
								
			if (strpos($key, '/') !== false)
			{
				$this->Flash->error(__('Invalid Password Reset Key generated.'));
			}
			else
			{
				//
				// store the reset key with the user
				//
				$user = $this->Users->get($rec['id']);
				
				if (isset($user)) 
				{
					$user->key_reset_password = $key;
					$user->key_reset_password_expire = $this->getExpirationTime(EXPIRE_HOURS);
					
					unset($user->password);
					unset($user->email);
					unset($user->name);
					unset($user->created);
					unset($user->modified);
					unset($user->user_type);
							
					if ($this->Users->save($user)) 
					{
						if ($this->isDebug() && !$this->isForceDebug())
						{
							$resetLink = URL_DEBUG . '/users/resetuserpassword/' . $key;

							$this->Flash->error(__('Bypassing Email Send, new password reset.'));
									
							return $this->redirect($resetLink);
						}
						else
						{
							$resetLink = URL_BASE . '/users/resetuserpassword/' . $key;
									
							// email password reset link
							$email = new Email('default');
							$email->from([EMAIL_ADMIN => APP_NAME . __('Admin')])
										->to($userEmail)
										->subject('Password Reset Link')
										->send("Please click this link to reset your account password:\r\n\r\n\r\n$resetLink \r\n\r\n(Link expires in " . EXPIRE_HOURS . " hours.");
										
							// show user a message
							$this->set('confirmHdr', 'A Password Reset link has been sent to your email address');
							$this->set('confirmMsg', 'Please check your email and click on the Password Reset link.');
							$this->render('message');							
						}								
					} 
					else 
					{
						$this->Flash->error(__('Error saving Password Reset Key. Please, try again.'));
					}
				}
				else
				{
					$this->Flash->error(__('User not found for specified Email Address. Please try again.'));
				}
			}
		}
		else
		{
			$this->Flash->error('Email Address not found. Please try again.');
		}					
	}

	private function getExpirationTime($expireHours)
	{
		// make experation time: now + 4 hours
		$exp = time() + ($expireHours * SECONDS_PER_MINUTE);				
		$date = new Time($exp);
		$expire = $date->format('Y-m-d H:i:s');
		
		return $expire;
	}

	private function getExpirationTime2($expireHours)
	{
		// make experation time: now + 4 hours
		$exp = time() + ($expireHours * SECONDS_PER_MINUTE);				
		
		return $exp;
	}
	
	private function makeEmailKey($name, $email)
	{
		//
		// make user a hashed email key
		//
		$key = $name . '-' . $email . '-' . date('Y-m-d');					
		
		$key = hash('sha256', $key);

		return $key;
	}
	
	private function sendVerifyEmail($name, $userEmail, $link, $subject, $prompt)
	{														
		// email password reset link
		$email = new Email('default');
		
		if ($email)
		{
			$email->from([EMAIL_ADMIN => APP_NAME . __('Admin')])
				->to($userEmail)
				->subject($subject)
				->send("$prompt\r\n\r\n\r\n$link \r\n\r\n(Link expires in " . EXPIRE_HOURS . " hours.");
		}
	}	
	
	private function flashErrors($model)
	{
		if ($model->errors())
		{
			//dump($user->errors());
			foreach($model->errors() as $k => $v)
			{
				foreach($v as $error)
					$this->Flash->error($error);
			}
		}
	}
		
    public function getErrors($errors)
    {
		//debug($errors);
		$errorList = '';
		
		foreach($errors as $field => $error)
		{
			foreach($error as $err)
			{
				if (strlen($errorList) > 0)
					$errorList .= ', ';
					
				$errorList .= $err . ': ' . $field;
			}
		}	
	
		return $errorList;
    }	
}
