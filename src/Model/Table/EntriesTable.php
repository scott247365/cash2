<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Entries Model
 *
 * @method \App\Model\Entity\Article get($primaryKey, $options = [])
 * @method \App\Model\Entity\Article newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Article[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Article|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Article patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Article[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Article findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EntriesTable extends Table
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

        $this->table('entries');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
		
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);		
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
			->notEmpty('title')
			->requirePresence('title')
		;
			
		return $validator;    
	}
	
	// The $query argument is a query builder instance.
	// The $options array will contain the 'tags' option we passed
	// to find('tagged') in our controller action.
	public function findTagged(Query $query, array $options)
	{
		$entries = $this->find()
			->select(['id', 'title', 'description']);

		if (empty($options['tags'])) {
			$entries->leftJoinWith('Tags', function ($q) {
				return $q->where(['Tags.name IS ' => null]);
			});
		} else {
			$entries->innerJoinWith('Tags', function ($q) use ($options) {
				return $q->where(['Tags.name IN' => $options['tags']]);
			});
		}

		return $entries->group(['Entries.id']);
	}	
    
	public function getByTag($tag)
	{					
		$q = "select * from entries, entries_tags, tags 
			where entries.id = entries_tags.entry_id 
			and tags.id = entries_tags.tag_id
            and tags.name = '" . $tag . "'";
		
		$conn = ConnectionManager::get('default');
		$entries = $conn->execute($q);
		
		//Debugger:dump($entries);

		return $entries;
	}
}
