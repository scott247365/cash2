<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Model\Table;

use App\Model\Entity\Category;
use App\Model\Entity\Subcategory;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class CategoriesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('categories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		
        $this->belongsTo('Users');
		
        $this->hasMany('subcategories')->sort(['name' => 'ASC']);
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

	public function getByUser($user_id, $parent_id = 0, $sort = 0)
	{
		$q = 
	"SELECT Category.name, Subcategory.name, Category.id, Subcategory.id, Category.notes, Category.type 
	FROM categories Category
	LEFT JOIN subcategories Subcategory
	ON Category.id = Subcategory.parent_id
	WHERE 1=1
	AND Category.user_id = `$user_id` ";
		
		if ($sort == 0)
			; // 0 = no sort 
		else if ($sort == 1)
			$q .= " ORDER BY Category.name ";
		else if ($sort == 2)
			$q .= " ORDER BY Category.name DESC ";
		
		$r = $this->query($q);
				
		return $r; 
	}

	public function getSelectList($user_id, $firstEntry = '') 
	{
		$records = $this->getByUser($user_id, 0, true);
		
		$select = Array();
		
		if ($firstEntry != '')
			$select['0'] = $firstEntry;
				
		foreach($records as $rec)
		{
			$select[$rec['id']] = $rec['name'];
		}
		
		return $select;
	}		
}
