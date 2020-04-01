<?php


class User
{

	public function __construct()
	{
		$this->dataHandler = new DataHandler($_ENV['DB_HOST'], "mysql", $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_PORT']);
	}

	public function checkSessionSet($session)
	{
		$isset = false;

		if (isset($session['user_id'])) {
			$isset = true;

		}

		if (isset($session['logged_in'])) {
			$isset = true;
		}

		return $isset;
	}

	public function checkAccount($email, $password)
	{
		$query = "SELECT id FROM users WHERE email = :email LIMIT 1; ";

		$stmt = $this->dataHandler->preparedQuery($query);
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetch();

		if ($this->checkPassword($password, $data['id'])) {
			return [
				'logged_in' => true,
			];
		}

		return [
			'logged_in' => false,
			'error'     => 'Foutief e-mail of wachtwoord ingevoerd.',
		];


	}

	public function checkedLoggedIn()
	{

		if ($this->checkSessionSet($_SESSION)) {
			return [
				'logged_in' => $_SESSION['logged_in'],
			];
		}

		return [
			'logged_in' => false,
		];

	}

	public function checkPassword($password, $id_user)
	{

		$query = "SELECT password FROM users WHERE id = :id";

		$stmt = $this->dataHandler->preparedQuery($query);
		$stmt->bindParam(':id', $id_user);
		$stmt->execute();

		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetch();


		if (password_verify($password, $data['password'])) {
			$_SESSION['logged_in'] = true;

			return true;
		}

		$_SESSION['logged_in'] = false;

		return false;

	}

	public static function checkLoggedIn()
	{
		if (isset($_SESSION['logged_in'])) {
			if ($_SESSION['logged_in']){
				return true;
			}
		}

		return false;
	}
}
