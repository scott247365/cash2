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

use App\Model\Entity\Subcategory;
use App\Model\Entity\Category;
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
class SubcategoriesTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('subcategories');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		
        $this->belongsTo('Users');
		
        $this->belongsTo('Categories');
    }

public function getRecord($limit = 0)
{
	$q = 'select * from subcategories where 1';
		
	$r = $this->query($q);
	
	return $r; 
}

public function getByUser($user_id, $parent_id = 0, $sort = 0)
{
	$q = "
SELECT Subcategory.name, Category.name, Subcategory.id, Category.id, Subcategory.notes 
	FROM `subcategories` Subcategory
	LEFT JOIN categories Category
		ON Subcategory.parent_id = Category.id
	WHERE 1=1
	AND Subcategory.user_id = `$user_id` 
";
	
	if ($sort == 0)
		; // 0 = no sort 
	else if ($sort == 1)
		$q .= " ORDER BY Subcategory.name ";
	else if ($sort == 2)
		$q .= " ORDER BY Subcategory.name DESC ";
		
	$r = $this->query($q);
	
	return $r; 
}

public function getCategories($user_id, $category = 0)
{
	$q = "	
SELECT Subcategory.name, Subcategory.id, Subcategory.parent_id, Category.type 
FROM `subcategories` Subcategory 
LEFT JOIN `categories` Category 
ON Category.id = Subcategory.parent_id 
WHERE 1 
AND Subcategory.user_id = $user_id 
";

	if ($category > 0)
		$q .= " AND Subcategory.parent_id = $category ";

	$q .= " 
ORDER BY Subcategory.parent_id, Subcategory.name
";
	
	$r = $this->query($q);
	
	return $r; 
}
}
