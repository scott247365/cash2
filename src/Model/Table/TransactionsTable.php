<?php
namespace App\Model\Table;

use App\Model\Entity\Account;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager; // for custom query

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class TransactionsTable extends Table {

//public $name = 'Transaction';
//public $useTable = 'transactions';
//public $useDbConfig = 'default';
//public $primaryKey = 'id';

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('transactions');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
		
        $this->belongsTo('Users');
        $this->belongsTo('Categories');
        $this->belongsTo('Subcategories');
        $this->belongsTo('Accounts');
    }


public function getList($limit = 0)
{
	$q = 'select * from transactions where 1';
		
	$r = $this->query($q);
	
	return $r; 
}

public function getAccountBalance($user_id, $account_id)
{
	$balance = 0.0;
		
	$q = "
select max(Account.starting_balance) + IFNULL(sum(Transaction.amount),0) AS balance from accounts Account
LEFT JOIN transactions Transaction
ON Account.id = Transaction.account_id
WHERE Account.id = '$account_id' AND Account.user_id = '$user_id' 
GROUP BY Account.id	";
	
	$r = $this->query($q);
	//Debugger::dump($r);	exit;
	
	if (isset($r[0][0]['balance']))
		$balance = floatval($r[0][0]['balance']);
		
	return $balance;
}

public function getByUser($user_id, $account_id = 0, $sort = 0, $month = 0, $cat = 0, $sub = 0, $useStartMonth = false, $year = 0, $desc = '')
{	
	$user_id = intval($user_id);
	$account_id = intval($account_id);
	$sort = intval($sort);
	$month = intval($month);
	$year = intval($year);
	$cat = intval($cat);
	$sub = intval($sub);
	
	$conditions = array();
	$conditions['`Transactions`.`user_id` ='] = $user_id;
	$q = "";
	
	if ($account_id > 0)
	{
		$q .= " AND `Transaction`.`account_id` = " . intval($account_id);
		$conditions['Transactions.account_id ='] = $account_id;
	}
		
	if ($month > 0)
	{
		if ($useStartMonth)
		{
			$q .= " AND MONTH(`Transaction`.`date`) >= " . intval($month);
			$conditions["MONTH(`Transactions`.`date`) >= "] = $month;
		}
		else
		{
			$q .= " AND MONTH(`Transaction`.`date`) = " . intval($month);
			$conditions["MONTH(`Transactions`.`date`) = "] = $month;
		}
		
		if ($year == 0)
			$year = date('Y');
		
		$q .= " AND YEAR(`Transaction`.`date`) = " . intval($year);
		$conditions["YEAR(`Transactions`.`date`) = "] = $year;
	}
	
	if ($cat > 0)
	{
		$q .= " AND `Category`.`id` = " . intval($cat);
		$conditions["`Categories`.`id` = "] = $cat;
	}
		
	if ($sub > 0)
	{
		$q .= " AND `Subcategory`.`id` = " . intval($sub);
		$conditions["`Subcategories`.`id` = "] = $sub;
	}

	//cash2 not safe yet
	//if ($desc != '')
	//	$q .= " AND `Transaction`.`description` like %" . $desc . "% ";
		
	$order = array();
	
	if ($sort == 0)
		;
	else if ($sort == 1)
	{
		$q .= ' ORDER BY `date`, `Transaction`.`id` ';
		$order["`Transactions`.`date`"] = "DESC";
		$order["`Transactions`.`id`"] = "ASC";
	}
	else if ($sort == 2)
	{
		$q .= ' ORDER BY `date` DESC, `Transaction`.`id` DESC ';
		$order["`Transactions`.`date`"] = "DESC";
		$order["`Transactions`.`id`"] = "DESC";
	}
	
	//dd($conditions);
	
	$r = $this->find()
		->contain(['Accounts', 'Categories', 'Subcategories'])
		->where($conditions)
		->order($order);
		
	//echo $r->count() . '<br\>';
	foreach($r as $rec)
	{
		//dd($rec);
	}
			
	return $r; 
}

public function getAnnualTotals($user_id)
{
	$q = "select YEAR(date) as 'year', sum(amount) as 'total' from transactions group by YEAR(date);";

	$r = $this->query($q);
	
	return $r;
}

public function getNetto($user_id, &$maxDate, $all = false)
{
	if ($all)
	{
		$date = new DateTime('2015-01-01');
	}
	else
	{
		$date = new DateTime('now');
		$date = $date->modify('-1 year');
		$date = $date->modify('+1 month');
	}
		
	$startDate = $date->format('Y-m-01');
	//Debugger::dump($startDate);

	$q2 = " SELECT * FROM (
SELECT sum(t.amount) as amount
, DATE_FORMAT(t.date, '%Y-%m') as date 
FROM transactions t
WHERE t.user_id = '$user_id'
AND t.amount > 0
AND t.category != '9'
AND t.date >= '$startDate'
GROUP BY DATE_FORMAT(t.date, '%Y-%m')
UNION
SELECT sum(t.amount) as amount
, DATE_FORMAT(t.date, '%Y-%m') as date
FROM transactions t
WHERE t.user_id = '$user_id'
AND t.amount <= 0
AND t.category != '9'
AND t.date >= '$startDate'
GROUP BY DATE_FORMAT(t.date, '%Y-%m') 
) Transaction ORDER BY date DESC;
";

	$r = $this->query($q2);
	
	//Debugger::dump($q2);	
	//Debugger::dump($r);	
	
	$stats = array();
	$cnt = 0;
	foreach($r as $rec)
	{
		$date = $rec['Transaction']['date'];
		
		if (!array_key_exists($date, $stats))
		{
			$stats[$date]['date'] = $date;
			$date2 = DateTime::createFromFormat('Y-m-j', $stats[$date]['date'] . '-01');	
			$stats[$date]['date2'] = $date2;			
		}
			
		if (!array_key_exists('inc', $stats[$date]))
			$stats[$date]['inc'] = 0.0;			
		if (!array_key_exists('exp', $stats[$date]))
			$stats[$date]['exp'] = 0.0;
			
		if (floatval($rec['Transaction']['amount']) > 0.0)
			$stats[$date]['inc'] = floatval($rec['Transaction']['amount']);
		else
			$stats[$date]['exp'] = floatval($rec['Transaction']['amount']);

		if (isset($stats[$date]['net']))
			$stats[$date]['net'] += floatval($rec['Transaction']['amount']);
		else
			$stats[$date]['net'] = floatval($rec['Transaction']['amount']);		
			
		$cnt++;
	}

	$ytdNet = 0.0;
	$ytdInc = 0.0;
	$ytdExp = 0.0;
	$maxDate = DateTime::createFromFormat('Y-m-j', '1900-01-01');
	$maxNet = 0.0;
	foreach($stats as $rec)
	{
		$ytdInc += $rec['inc'];
		$ytdExp += $rec['exp'];
		$ytdNet += $rec['net'];
		
		$date = DateTime::createFromFormat('Y-m-j', $rec['date'] . '-01');
		if ($date > $maxDate)
			$maxDate = $date;
		//echo $date->format('Y-m-d');exit;
		
		if ($rec['net'] > $maxNet)
			$maxNet = $rec['net'];
	}
	
	$stats['ytd']['date'] = 'YTD';
	$stats['ytd']['inc'] = $ytdInc;
	$stats['ytd']['exp'] = $ytdExp;
	$stats['ytd']['net'] = $ytdNet;
	$stats['ytd']['date2'] = $maxDate;
	
	//Debugger::dump($stats);	
	
	return $stats; 
}

public function getExpenses($user_id, $month, $year)
{
	$cats = $this->getExpensesCat($user_id, $month, $year);
	$subs = $this->getExpensesSub($user_id, $month, $year);
	
	$countCat = 0;
	$total = 0;
	foreach($cats as $rec)
	{		
		$total += floatval($rec[0]['amount']);
		
		$count = 0;
		foreach($subs as $sub)
		{
			if ($sub['Category']['id'] == $rec['Category']['id'])
				$cats[$countCat]['subs'][$count++] = $sub;
		}
		
		$countCat++;
	}
		
	if (abs($total - 0.0) > EPSILON)
	{
		$cats[0]['total'] = $total;
	}
		
	//Debugger::dump($cats[1]['subs']); //die;
	//Debugger::dump($cats); //die;
	
	return $cats;
}

public function getExpensesCat($user_id, $month, $year)
{	
	$month = intval($month);
	$year = intval($year);
	
	$q = "
select Category.id, Category.name, sum(Transaction.amount) AS amount, count(distinct Transaction.subcategory) as tcount from transactions as Transaction
LEFT JOIN categories as Category
ON Transaction.category = Category.id
WHERE Transaction.user_id = '$user_id' 
AND DATE_FORMAT(Transaction.date, '%m') = $month 
AND YEAR(Transaction.date) = $year
AND Transaction.category != '11'
AND Transaction.description != 'Transfer' 
 GROUP BY Transaction.category 
ORDER BY amount
";

	$r = $this->query($q);
	//Debugger::dump($r);
		
	return $r;
}

public function getExpensesSub($user_id, $month, $year)
{		
	$month = intval($month);
	$year = intval($year);

	$q = "
select Category.id, Category.name, Subcategory.name, Subcategory.id, sum(Transaction.amount) AS amount, count(distinct Transaction.subcategory) as tcount 
from transactions as Transaction
LEFT JOIN categories as Category
ON Transaction.category = Category.id
LEFT JOIN subcategories as Subcategory
ON Transaction.subcategory = Subcategory.id
WHERE Transaction.user_id = '$user_id' 
AND DATE_FORMAT(Transaction.date, '%m') = $month 
AND YEAR(Transaction.date) = $year
AND Transaction.category != '11'
AND Transaction.description != 'Transfer' 
 GROUP BY Transaction.subcategory 
";

	$r = $this->query($q);
	//Debugger::dump($r);
		
	return $r;
}
}
