<?php

namespace framework\Models;

class QueryBuilder
{
	private static $dbConnect = null;
	private $select;
	private $selectCount;
	private $insert;
	private $update;
	private $where;
	private $orderBy;
	private $limit;
	private $whereValue = array();
	private $insertValue = array();
	private $updateValue = array();
	private $from;
	private $leftJoin;
	private $rightJoin;
	private $innerJoin;
	private $crossJoin;


	function __construct ()
	{
		if (self::$dbConnect == null) {
			try {
				self::$dbConnect = new \PDO('mysql:host=framework.dev;dbname=firstbase', 'root', '');//db connecttion settings, change host,password
			} catch (PDOException $e) {
				die("<h1>ERROR</h1>");
			}
			return self::$dbConnect;
		}
	}  //return db connect if object created

	private function __clone ()
	{

	}//block object clone

	public function select ($what = "*")
	{
		if (is_array($what)) {
			$result = implode(", ", $what);
		}else {
			$result = $what;
		}

		$this->select = "SELECT " . $result;
		return $this;
	}// end select action


	public function selectCount ()
	{
		$this->selectCount = "SELECT COUNT(*) ";
		return $this;
	}
	
	
	public function insert ($table,$data)
	{
		$result = "INSERT INTO " . $table;
		$column = "(";
		$columnValues = "VALUES (";
		$leg = count($data);
		$i = 0;

		foreach ($data as $key => $value) {
			if ($i === $leg - 1) {
				$column .=  $key . ") ";
				$columnValues .= ":" . $key .")";
			} else {
				$column .= $key . ", ";
				$columnValues .= ":" . $key . ", ";
			}
			$this->insertValue[':' . $key] = $value;
			$i++;
		}
		$result .= $column . $columnValues;
		$this->insert = $result;
		return $this;
	}
	

	public function update ($table,$tableColumn)
	{
		$leg = count($tableColumn);
		$result = "UPDATE " . $table . " SET ";

		foreach ($tableColumn as $key => $record) {
			if ($key === $leg - 1) {
				$result .= $record['col'] . $record['sign'] . ":" . $record['col'];
			} else {
				$result .= $record['col'] . $record['sign'] . ":" . $record['col']  . ", ";
			}

			$this->updateValue[':' . $record['col']] = $record['value'];//bindparam - kay: value
		}

		$this->update = $result;
		return $this;
 	}//end update action

	public function from ($table)
	{
		$this->from = " FROM " . $table;
		return $this;//return object
	}

	public function innerJoin ($table, $row1, $row2, $sing)
	{
		$join = "JOIN " . $table . " ON " .  $row1 . $sing . $row2;
		$this->innerJoin = $join;
		return $this;
	}//end innerJoin action

	public function leftJoin ($table, $row1, $row2, $sing)
	{
		$join = "LEFT JOIN " . $table . " ON " .  $row1 . $sing . $row2;
		$this->leftJoin = $join;
		return $this;
	}//end leftJoin action

	public function rightJoin ($table, $row1, $row2, $sing)
	{
		$join = "RIGHT JOIN " . $table . " ON " .  $row1 . $sing . $row2;
		$this->rightJoin = $join;
		return $this;
	}//end rightJoin action

	public function crossJoin ($table, $row1, $row2, $sing)
	{
		$join = "CROSS JOIN " . $table . " ON " .  $row1 . $sing . $row2;
		$this->crossJoin = $join;
		return $this;
	}//end crossJoin action

	public function where ($where)
	{
		$leg = count($where);
		$sql = " WHERE ";
		$i = 0;
		foreach ($where as $key => $value) {
			if ($i === $leg - 1) {
				$sql .= "(" . $key . "= :" . $key . ")";//key ենք նշանակում տալիս ենք նրան column անունը վերջում bindparam անելու համար
			} else {
				$sql .= "(" . $key . "= :" . $key . ") AND ";
			}
			$this->whereValue[':' . $key] = $value;//bindparam - kay: value
			$i++;
		}
		$this->where = $sql;
		return $this;//return object
	}//end where action


	public function limit ($start, $rowNum)
	{
		if (isset($start) && isset($rowNum)) {
			$result = " LIMIT " . $start . " " . $rowNum;
			$this->limit = $result;
			return $this;
		}else {
			return false;
		}
	}//end limit action

	public function order ($order, $asc = " ASC ")
	{
		if (is_array($order) && count($order) > 0) {

			$result = " ORDER BY ". implode(", ", $order) . " " . $asc;
		}
		$this->orderBy = $result;
		return $this;
	}//end orderBy action

	private function fetch ($type)
	{
		$query = sprintf('%s %s %s', $this->select, $this->from, $this->where);//convert objects to string
		$result = self::$dbConnect->prepare($query);//prepare sql_query whit this connection
		$result->execute($this->whereValue);//bindParam array values
		if ($type === 1) {
			return $result->fetchAll();
		} else {
			return $result->fetch(\PDO::FETCH_ASSOC);
		}
	}

	private function fetchCount ()
	{
		$query = sprintf('%s %s %s', $this->selectCount, $this->from, $this->where);//convert objects to string
		$result = self::$dbConnect->prepare($query);//prepare sql_query whit this connection
		$result->execute($this->whereValue);//bindParam array values
		$result = $result->fetchColumn();
		return $result;
	}

	private function insertData()
	{
		$query = sprintf('%s', $this->insert);
		$result = self::$dbConnect->prepare($query);
		$result->execute($this->insertValue);
		return $result;
	}

	public function callInsert()
	{
		return $this->insertData();
	}

	public function get ($num = 1)
	{
		if ($num === 1) {
			return $this->fetch(1);
		} elseif($num === 0) {
			return $this->fetchCount();
		}
	}//call private fetch action

	public function first ()
	{
		return $this->fetch(0);

	}//call private fetch action

	public function checkData ($persInfo)
	{
		$query = $this->query->selectCount()->from("users")->where($persInfo)->get(0);
		return $query;
	}

	public function checkInputs ($data)
	{
		$array = array();
		foreach ($data as $key => $value) {
			$array[$key] = trim(strip_tags($value));
		}
		return $array;
	}//not part of QueryBuilder, clear info from tags and gaps

} // end class QueryBuilder

/*
$a = array (
	 	array ('col' => 'name',
	 	'value' => 'Ara',
		'sign' => '=',
		'con' => 'AND'
		),
		array ('col' => 'lastname',
		'value' => 'Mesropyan',
		'sign' => '=',
		)
	);

$query = new QueryBuilder();
var_dump($query->select()->from("users")->where($a)->get());*/