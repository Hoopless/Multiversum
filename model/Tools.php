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
