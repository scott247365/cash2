<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class UsersTable extends Table
{
	//new: use this to determain access
	public function isOwnedBy($articleId, $userId)
	{
		return $this->exists(['id' => $articleId, 'user_id' => $userId]);
	}

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

		/*
        $this->hasMany('Bookmarks', [
            'foreignKey' => 'user_id'
        ]);
		*/
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
	
        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email', 'Email address is requiered')
			;
			

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Password is required')			
			->add('password', [
				'minLength' => [
					'rule' => ['minLength', 6],
					'message' => 'Password must be at least 6 characters'
				]
			])
			->add('password', 'custom', [
				'rule' => function ($value, $context) {
							
							$p = $context['data']['password'];
							// password must contain one of each: number, uppler- and lower-case letter
							if (preg_match('/[0-9]/', $p))
							{
								if (preg_match('/[A-Z]/', $p))
								{
									if (preg_match('/[a-z]/', $p))
									{
										return true;
									}
								}
							}
							
							//debug($context['data']['password']);die;
							return false;
						},
				'message' => 'Password must contain numbers and upper- and lower-case letters'
			])			
		;
		
		// First Name
        $validator
            ->requirePresence('firstName', 'create', 'First Name is required')
            ->notEmpty('firstName', 'First Name is required')			
			->add('firstName', [
				'minLength' => [
					'rule' => ['minLength', 2],
					'message' => 'First Name must be at least 2 letters'
				]
			])
			->add('firstName', 'custom', [
				'rule' => function ($value, $context) {
				
							$p = $context['data']['firstName'];
							
							// name must contain only letters
							if (ctype_alpha($p))
							{
								return true;
							}
							
							//debug($p);die;
							return false;
						},
				'message' => 'First Name must be letters only'
			])			
		;

		// Last Name
        $validator
            ->requirePresence('lastName', 'create', 'Last Name is required')
            ->notEmpty('lastName', 'Last Name is required')			
			->add('lastName', [
				'minLength' => [
					'rule' => ['minLength', 2],
					'message' => 'Last Name must be at least 2 characters'
				]
			])
			->add('lastName', 'custom', [
				'rule' => function ($value, $context) {
				
							$p = $context['data']['lastName'];
							
							// name must contain only letters
							if (ctype_alpha($p))
							{
								return true;
							}
							
							//debug($p);die;
							return false;
						},
				'message' => 'Last Name must be letters only'
			])			
		;
		
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
