<?php
/*
 * [ PDOext.class.php ]
 * Contains additional helper functions for PHP's PDO database connection class.
 */

class PDOext extends PDO
{
	private $query_count = 0;

	public function query($query)
	{
		// Increment the counter
		$this->query_count++;

		// Run the query
		return parent::query($query);
	}

	public function prepare($statement, $options = array(PDO::MYSQL_ATTR_LOCAL_INFILE => true))
	{
		// Increment the counter
		$this->query_count++;

		// Prepare the statement
		return parent::prepare($statement, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true));
	}

	public function get_count()
	{
		return $this->query_count;
	}
}
?>
