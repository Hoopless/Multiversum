<?php


class Tools
{

	/**
	 * Creates an insert query based on an array and table name.
	 *
	 * @param array  $array
	 * @param string $table
	 * @return string
	 */
	public static function insertQuery($array, $table)
	{
		$query = "INSERT INTO {$table} (";
		foreach ($array as $key => $value) {
			$query .= "{$value}";
			($key !== count($array) - 1) ? $query .= ", " : "";
		}
		$query .= ") ";

		$query .= "VALUES (";
		foreach ($array as $key => $value) {
			$query .= ":{$value}";
			($key !== count($array) - 1) ? $query .= ", " : "";
		}
		$query .= ") ";

		return $query;
	}


	/**
	 * Creates an update query based on an array and table name.
	 *
	 * @param array  $array
	 * @param string $table
	 * @param array  $data
	 * @return string|boolean
	 */
	public static function updateQuery($array, $table, $data)
	{
		$query = "UPDATE {$table} SET ";
		$number = 0;

		foreach ($array as $key => $value) {
			if (isset($data[$value]) && ! empty($data[$value])) {
				$query .= "{$value} = :{$value} ";
				($key !== count($array) - 1) ? $query .= ", " : "";
				$number++;
			}
		}

		if ($number === 0){
			return false;
		}

		if (preg_match('/, $/', $query)) {
			$query = trim($query);
			$query = rtrim($query, "," );
		}

		return $query;
	}

	/**
	 * @param array $array
	 * @param array $data
	 * @return bool
	 */
	public static function checkIsSet($array, $data)
	{
		foreach ($array as $item) {
			if (! isset($data[$item])) {
				return false;
			}
		}

		return true;
	}
}
