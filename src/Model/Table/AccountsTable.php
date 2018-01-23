<?php
namespace App\Model\Table;

use App\Model\Entity\Account;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Bookmarks
 */
class AccountsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('accounts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
        return $rules;
    }

	public function getRecord($limit = 0)
	{
		$q = 'select * from accounts where 1';
			
		$r = $this->query($q);
		
		return $r; 
	}

	public function getSummary($user_id)
	{
		$r = $this->getVisible($user_id, 0, true);
		
		$balance = 0.0;
		foreach($r as $rec)
		{
			$balance += $rec['balance'];
		}
		
		$size = count($r);
		$r[$size]['name'] = 'TOTAL:';
		$r[$size]['balance'] = $balance;
		
		return $r; 
	}

	public function getByUser($user_id, $parent_id = 0, $sort = 0)
	{
		$q = "select * from `accounts` where 1 AND `user_id` = `$user_id` ";
		
		if ($parent_id > 0)
			$q .= " AND parent_id = '$parent_id' ";

		if ($sort == 0)
			; // 0 = no sort 
		else if ($sort == 1)
			$q .= " ORDER BY name ";
		else if ($sort == 2)
			$q .= " ORDER BY balance DESC ";
			
		$r = $this->query($q);
		
		return $r; 
	}

	public function getVisible($user_id, $parent_id = 0, $sort = 0)
	{
		$q = "select * from `accounts` where 1 AND `hidden` != '1' AND `user_id` = `$user_id` ";

		if ($parent_id > 0)
			$q .= " AND `parent_id` = `$parent_id` ";

		if ($sort == 0)
			; // 0 = no sort 
		else if ($sort == 1)
			$q .= " ORDER BY name ";
		else if ($sort == 2)
			$q .= " ORDER BY name DESC ";
			
		$r = $this->query($q);
				
		return $r; 
	}

	public function updateBalance($user_id, $parent_id)
	{
		$q = " update accounts set balance = (select sum(amount) as total from transactions where user_id = `$user_id` AND parent_id = `$parent_id` group by user_id, parent_id) + accounts.starting_balance where accounts.id = `$parent_id` ";
		
		$r = $this->query($q);
	}

	public function updateBalance2($user_id, $account_id, $balance)
	{
		$q = " update accounts set balance = `$balance` where accounts.id = `$account_id` AND accounts.user_id = `$user_id` ";
			
		$r = $this->query($q);
	}	
}
