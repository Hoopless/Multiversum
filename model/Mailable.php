<?php


class Mailable
{

	/**
	 * @var \SendGrid\Mail\Mail
	 */
	CONST EMAIL = "multiversum@snoozing.dev";
	private $token;

	public function __construct()
	{
		$this->token     = getenv("SENDGRID_API_KEY");
		$this->sendgrind = new \SendGrid($this->token);
		$this->email     = new \SendGrid\Mail\Mail();
	}

	public function sendMail($data)
	{
		if (! isset($data['name']) || ! isset($data['email']) || ! isset($data['subject'])) {
			return json_encode([
				'name'    => 'Geen waarde opgestuurd.',
				'email'   => 'Geen waarde opgestuurd.',
				'subject' => 'Geen waarde opgestuurd.',
			]);
		}

		if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return json_encode([
				'email' => 'Ongeldig email',
			]);
		}

		try {

			$email = $this->email;

			$email->setFrom("multiversum@snoozing.dev");
			$email->setSubject("Received email from {$data['name']}");
			$email->addTo("multiversum@snoozing.dev", $data['name']);
			$email->setReplyTo($data['email']);
			$email->addContent("text/plain", "There has been an e-mail from {$data['name']}. With the following subject \n {$data['subject']} \n Their e-mail: {$data['email']}");

			$response = $this->sendgrind->send(($email));

			if ($response->statusCode() !== 200 || $response->statusCode() !== 202) {
				$array = json_decode($response->body());

				if (isset($array->errors[0])) {
					return json_encode($array->errors[0]);
				}

			}

			$array = [
				'responseCode' => $response->statusCode(),
				'message'      => 'Succefully send e-mail!',
			];

			return json_encode($array);

		} catch (Exception $e) {
			throw new Exception(" Message was not send! please look at the following error:" . $e->getMessage());
		}
	}

	public function sendConfirmationMail($emailaddress, $order_data, $id_order)
	{

		$product      = new Product();
		$product_data = $product->get($order_data['product_id']);

		$content = $this->setContent($order_data, $product_data);
		$name    = $order_data['firstname'] . " " . $order_data['lastname'];

		$email = $this->email;

		$email->setFrom("multiversum@snoozing.dev");
		$email->setSubject("Orderbevestiging #{$id_order}");
		$email->addTo($emailaddress, $name);
		$email->setReplyTo("multiversum@snoozing.dev");
		$email->addContent('text/html', $content);

		$response = $this->sendgrind->send(($email));

		if ($response->statusCode() !== 200 || $response->statusCode() !== 202) {
			$array = json_decode($response->body());

			if (isset($array->errors[0])) {
				return false;
			}

		}

		return true;


	}


	public function setContent($order, $product)
	{
		$name                  = $order['firstname'] . " " . $order['lastname'];
		$formatted_total_price = number_format($order['total_price_inc'], 2, ',', '.');
		$tax_order             = number_format(($order['total_price_inc'] - $order['total_price_ex']), 2, ',', '.');
		$formatted_price       = number_format($product['price'], 2, ',', '.');
		$own_email             = self::EMAIL;

		$content = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
					<html xmlns=\"http://www.w3.org/1999/xhtml\">
					<head>
						<meta name=\"viewport\"
							  content=\"width=device-width, initial-scale=1.0\">
						<meta http-equiv=\"Content-Type\"
							  content=\"text/html; charset=UTF-8\">
					</head>
					<body style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;\">
					<style>
						@media only screen and (max-width: 600px) {
							.inner-body {
								width: 100% !important;
							}

							.footer {
								width: 100% !important;
							}
						}

						@media only screen and (max-width: 500px) {
							.button {
								width: 100% !important;
							}
						}
					</style>
					<table class=\"wrapper\"
						   width=\"100%\"
						   cellpadding=\"0\"
						   cellspacing=\"0\"
						   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;\">
						<tr>
							<td align=\"center\"
								style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;\">
								<table class=\"content\"
									   width=\"100%\"
									   cellpadding=\"0\"
									   cellspacing=\"0\"
									   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;\">
									<tr>
										<td class=\"header\"
											style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;\">
											<a href=\"http://multiversum.snoozing.dev\"
											   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;\">
											   <img alt=\"\" src=\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhLS0gQ3JlYXRlZCB3aXRoIElua3NjYXBlIChodHRwOi8vd3d3Lmlua3NjYXBlLm9yZy8pIC0tPgoKPHN2ZwogICB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iCiAgIHhtbG5zOmNjPSJodHRwOi8vY3JlYXRpdmVjb21tb25zLm9yZy9ucyMiCiAgIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIKICAgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIgogICB4bWxuczpzb2RpcG9kaT0iaHR0cDovL3NvZGlwb2RpLnNvdXJjZWZvcmdlLm5ldC9EVEQvc29kaXBvZGktMC5kdGQiCiAgIHhtbG5zOmlua3NjYXBlPSJodHRwOi8vd3d3Lmlua3NjYXBlLm9yZy9uYW1lc3BhY2VzL2lua3NjYXBlIgogICB3aWR0aD0iMTkyMCIKICAgaGVpZ2h0PSIxMDgwIgogICB2aWV3Qm94PSIwIDAgNTA4IDI4NS43NTAwMSIKICAgdmVyc2lvbj0iMS4xIgogICBpZD0ic3ZnOCIKICAgaW5rc2NhcGU6dmVyc2lvbj0iMC45Mi40ICg1ZGE2ODljMzEzLCAyMDE5LTAxLTE0KSIKICAgc29kaXBvZGk6ZG9jbmFtZT0idnJfdjIuc3ZnIgogICBpbmtzY2FwZTpleHBvcnQtZmlsZW5hbWU9IkQ6XHBhXERvY3VtZW50c1xyc3JjaF9waWNzXG12bV9tLnBuZyIKICAgaW5rc2NhcGU6ZXhwb3J0LXhkcGk9Ijk2IgogICBpbmtzY2FwZTpleHBvcnQteWRwaT0iOTYiPgogIDxkZWZzCiAgICAgaWQ9ImRlZnMyIj4KICAgIDxtYXJrZXIKICAgICAgIHN0eWxlPSJvdmVyZmxvdzp2aXNpYmxlIgogICAgICAgcmVmWT0iMCIKICAgICAgIHJlZlg9IjAiCiAgICAgICBvcmllbnQ9ImF1dG8iCiAgICAgICBpZD0iRGlzdGFuY2VYIj4KICAgICAgPHBhdGgKICAgICAgICAgaWQ9InBhdGg0NDg3IgogICAgICAgICBzdHlsZT0ic3Ryb2tlOiMwMDAwMDA7c3Ryb2tlLXdpZHRoOjAuNSIKICAgICAgICAgZD0iTSAzLC0zIC0zLDMgTSAwLC01IFYgNSIKICAgICAgICAgaW5rc2NhcGU6Y29ubmVjdG9yLWN1cnZhdHVyZT0iMCIgLz4KICAgIDwvbWFya2VyPgogICAgPHBhdHRlcm4KICAgICAgIHk9IjAiCiAgICAgICB4PSIwIgogICAgICAgd2lkdGg9IjgiCiAgICAgICBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIgogICAgICAgaWQ9IkhhdGNoIgogICAgICAgaGVpZ2h0PSI4Ij4KICAgICAgPHBhdGgKICAgICAgICAgaWQ9InBhdGg0NDkwIgogICAgICAgICBzdHJva2Utd2lkdGg9IjAuMjUiCiAgICAgICAgIHN0cm9rZT0iIzAwMDAwMCIKICAgICAgICAgbGluZWNhcD0ic3F1YXJlIgogICAgICAgICBkPSJNOCA0IGwtNCw0IiAvPgogICAgICA8cGF0aAogICAgICAgICBpZD0icGF0aDQ0OTIiCiAgICAgICAgIHN0cm9rZS13aWR0aD0iMC4yNSIKICAgICAgICAgc3Ryb2tlPSIjMDAwMDAwIgogICAgICAgICBsaW5lY2FwPSJzcXVhcmUiCiAgICAgICAgIGQ9Ik02IDIgbC00LDQiIC8+CiAgICAgIDxwYXRoCiAgICAgICAgIGlkPSJwYXRoNDQ5NCIKICAgICAgICAgc3Ryb2tlLXdpZHRoPSIwLjI1IgogICAgICAgICBzdHJva2U9IiMwMDAwMDAiCiAgICAgICAgIGxpbmVjYXA9InNxdWFyZSIKICAgICAgICAgZD0iTTQgMCBsLTQsNCIgLz4KICAgIDwvcGF0dGVybj4KICAgIDxzeW1ib2wKICAgICAgIGlkPSIkTU9ERUxfU1BBQ0UiIC8+CiAgICA8c3ltYm9sCiAgICAgICBpZD0iJFBBUEVSX1NQQUNFIiAvPgogIDwvZGVmcz4KICA8c29kaXBvZGk6bmFtZWR2aWV3CiAgICAgaWQ9ImJhc2UiCiAgICAgcGFnZWNvbG9yPSIjZmZmZmZmIgogICAgIGJvcmRlcmNvbG9yPSIjNjY2NjY2IgogICAgIGJvcmRlcm9wYWNpdHk9IjEuMCIKICAgICBpbmtzY2FwZTpwYWdlb3BhY2l0eT0iMC4wIgogICAgIGlua3NjYXBlOnBhZ2VzaGFkb3c9IjIiCiAgICAgaW5rc2NhcGU6em9vbT0iMC4zNjE3MzM2MyIKICAgICBpbmtzY2FwZTpjeD0iMjIwLjQ1MjM0IgogICAgIGlua3NjYXBlOmN5PSI5ODkuMzUxNDQiCiAgICAgaW5rc2NhcGU6ZG9jdW1lbnQtdW5pdHM9Im1tIgogICAgIGlua3NjYXBlOmN1cnJlbnQtbGF5ZXI9ImxheWVyMTEiCiAgICAgc2hvd2dyaWQ9ImZhbHNlIgogICAgIGlua3NjYXBlOndpbmRvdy13aWR0aD0iMTkyMCIKICAgICBpbmtzY2FwZTp3aW5kb3ctaGVpZ2h0PSIxMDAxIgogICAgIGlua3NjYXBlOndpbmRvdy14PSItOSIKICAgICBpbmtzY2FwZTp3aW5kb3cteT0iLTkiCiAgICAgaW5rc2NhcGU6d2luZG93LW1heGltaXplZD0iMSIKICAgICBmaXQtbWFyZ2luLXRvcD0iMCIKICAgICBmaXQtbWFyZ2luLWxlZnQ9IjAiCiAgICAgZml0LW1hcmdpbi1yaWdodD0iMCIKICAgICBmaXQtbWFyZ2luLWJvdHRvbT0iMCIKICAgICB1bml0cz0icHgiCiAgICAgaW5rc2NhcGU6cGFnZWNoZWNrZXJib2FyZD0idHJ1ZSIgLz4KICA8bWV0YWRhdGEKICAgICBpZD0ibWV0YWRhdGE1Ij4KICAgIDxyZGY6UkRGPgogICAgICA8Y2M6V29yawogICAgICAgICByZGY6YWJvdXQ9IiI+CiAgICAgICAgPGRjOmZvcm1hdD5pbWFnZS9zdmcreG1sPC9kYzpmb3JtYXQ+CiAgICAgICAgPGRjOnR5cGUKICAgICAgICAgICByZGY6cmVzb3VyY2U9Imh0dHA6Ly9wdXJsLm9yZy9kYy9kY21pdHlwZS9TdGlsbEltYWdlIiAvPgogICAgICAgIDxkYzp0aXRsZT48L2RjOnRpdGxlPgogICAgICA8L2NjOldvcms+CiAgICA8L3JkZjpSREY+CiAgPC9tZXRhZGF0YT4KICA8ZwogICAgIGlua3NjYXBlOmdyb3VwbW9kZT0ibGF5ZXIiCiAgICAgaWQ9ImxheWVyMTEiCiAgICAgaW5rc2NhcGU6bGFiZWw9ImdsYXNzMDAwIgogICAgIHN0eWxlPSJkaXNwbGF5OmlubGluZSIKICAgICB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMTUuNTAzMjIsMTkuNTI2OTkxKSI+CiAgICA8cGF0aAogICAgICAgc3R5bGU9ImZpbGw6IzJjM2U1MDtmaWxsLW9wYWNpdHk6MTtzdHJva2U6bm9uZTtzdHJva2Utd2lkdGg6MC43NTU5NTI0MnB4O3N0cm9rZS1saW5lY2FwOmJ1dHQ7c3Ryb2tlLWxpbmVqb2luOm1pdGVyO3N0cm9rZS1vcGFjaXR5OjEiCiAgICAgICBkPSJtIC0yMzIuMjE2NTEsMzkuNDY3OTI1IGMgLTUuNjcxMTMsLTAuMjMxMDI5IC0xMS42ODI5NSwzLjQwNjE4MyAtMTMuOTM5MzUsOC42MDkyOTMgLTIuNjA5MDksMTIuNjYwNzYyIC0xLjA2MTQ2LDI1Ljc5NDI1NiAtMS42NjYyNSwzOC42Mzc1ODMgMC41MjEwMSw5LjUzNTk0OCAtMS40ODA2OCwxOS43MTI5OTkgMi4xMDE4MSwyOC44MTQ5MjkgMi44NDk5LDQuMTgzMzQgNi4zMjk1Nyw4LjM5MzU1IDEwLjQ5NzY5LDExLjIyNDEzIDIuNjQ0NzIsLTEuMzA5NTIgMS40NDc1OSwtNS43MjE4NiAyLjM4NDUsLTguMTM5NzggMy4zODA0LC0yNi4xNDk4ODMgNi4wNjcxLC01Mi4zOTE2MTMgOS42MzU0NCwtNzguNTExMjc0IC0yLjEzODE4LC0xLjUyMTA1OCAtNi4yOTg1NSwtMC4yNTMzNDQgLTkuMDEzODQsLTAuNjM0ODgxIHoiCiAgICAgICBpZD0icGF0aDQ5MDIiCiAgICAgICBpbmtzY2FwZTpjb25uZWN0b3ItY3VydmF0dXJlPSIwIiAvPgogICAgPHBhdGgKICAgICAgIHN0eWxlPSJmaWxsOiMyYzNlNTA7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjAuNzU1OTUyNDJweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIgogICAgICAgZD0ibSAtNjQuNDQ2NzEzLC0xMS42MDQ2MyBjIC00My4xNDUxNzcsMC40Mjk2NjYgLTg2LjQwOTg2Nyw4Ljg2NTc2ODQgLTEyNi4xMjAwNzcsMjUuODU1OTMxIC0xNC44MDA1OSw2LjUyMjI5IC0yMy44NzQyNCwyMi4zMjU1OCAtMjQuNDU5MDQsMzguMTc0ODk1IC0zLjE2MzE2LDI3LjA0ODc3NyAtNy4yMDMyMSw1NC4wMzQ0MDQgLTkuMTkyNjUsODEuMTk5MTY0IDAuMjYyMTQsMTEuMTgxNyA1LjExNDg5LDIyLjY1MzYgMTMuNjA3MTQsMzAuMDM4NzcgMTQuMzQwMDIsMTAuODIzNjYgMjkuMDkyNTcsMjEuMjMwMTEgNDQuNTc3NTksMzAuMzQ3MzUgMTAuNDM2MzYsNS45MjgwMiAyMi41OTQ5NSwyLjk2MzA0IDMzLjYxNTQ0LDAuODA4OCAyMi43NzYxLC00LjI0NzU3IDQ1LjE3NDcxNywtMTAuNjM2MjIgNjguMTUwMjUsLTEzLjcyMzQ4IDEzLjc2NjQ0NywwLjAxODkgMjcuMDQ4MzIyLDQuNDkzNTkgNDAuNTE4NDE5LDYuODg2OTcgMTYuNjE4OTg2NywzLjM0MDQ0IDMzLjEzMjQxMzMsNy42NDUwNSA0OS45NDAzNDMsOS44MTgwNiAxNS4yMzc4NTQsLTAuMTA1NjkgMjYuODY2OTk1LC0xMS4zMjU2NSAzOS4wNzUzMTksLTE4Ljg3MDEzIDEwLjA3NTc0NCwtNy43ODExIDIyLjgxOTU1OCwtMTMuNDA5NDYgMjkuMTgxOTA1LC0yNS4wMjI2MSA1Ljg0NjQ0NCwtOS42MTczMiA2LjI2MzA1NCwtMjEuMjM4MzYgNC41OTc5MjcsLTMyLjA3OTk1IEMgOTYuMDYwMTkzLDk1LjEzNDIyMyA5My4yMTI4MjYsNjguMzgzNDQ0IDg5LjE3NjkyOSw0MS44MzQ3MDUgODUuODkwNDg5LDI4LjcxMzExIDc2LjEyMTg5NSwxNy40ODI0NjIgNjMuMzAxODMxLDEyLjkyOTg2MSAyMi45MTAyOTUsLTMuNTc4MzkxNiAtMjAuODE4ODgxLC0xMS45MjA4MDEgLTY0LjQ0NjcxMywtMTEuNjA0NjMgWiIKICAgICAgIGlkPSJwYXRoNDkwNCIKICAgICAgIGlua3NjYXBlOmNvbm5lY3Rvci1jdXJ2YXR1cmU9IjAiIC8+CiAgICA8cGF0aAogICAgICAgc3R5bGU9ImZpbGw6IzJjM2U1MDtmaWxsLW9wYWNpdHk6MTtzdHJva2U6bm9uZTtzdHJva2Utd2lkdGg6MC43NTU5NTI0MnB4O3N0cm9rZS1saW5lY2FwOmJ1dHQ7c3Ryb2tlLWxpbmVqb2luOm1pdGVyO3N0cm9rZS1vcGFjaXR5OjEiCiAgICAgICBkPSJtIDk4Ljg1OTYxMyw0MC4xMjQ5NTQgYyA0LjI1NzM4NywyOC4yODk5MDEgNi42MDMxNTcsNTYuODkxMDM2IDEwLjc5NDQ2Nyw4NS4xODM0MzYgMC45NTA1NSwzLjMyNTQzIDMuNzgwODIsLTAuNTkxMzggNC45ODg5OSwtMS42ODc2IDQuODc4MDEsLTQuMzA2NTcgOC45NTExMSwtOS45Nzc3NyA4LjYxNTIsLTE2Ljc5MzA4IDAuNTY5MDEsLTE5LjA0NTQyMSAwLjAzMzUsLTM4LjE1MTgxNCAtMC4xNDYxNiwtNTcuMTc4MDUyIC0zLjAwMjU5LC01LjQyMTUxMyAtOC4wNjQwMiwtMTAuMzE2Njk3IC0xNC42ODIwMiwtMTAuMDk5MDUxIC0zLjAxNjk2LDAuMjE5NjE4IC03LjE2MzA5LC0wLjkzMjcyNyAtOS41NzA0NzcsMC41NzQzNDcgeiIKICAgICAgIGlkPSJwYXRoNDkwNiIKICAgICAgIGlua3NjYXBlOmNvbm5lY3Rvci1jdXJ2YXR1cmU9IjAiIC8+CiAgPC9nPgogIDxnCiAgICAgaW5rc2NhcGU6Z3JvdXBtb2RlPSJsYXllciIKICAgICBpZD0ibGF5ZXI5IgogICAgIGlua3NjYXBlOmxhYmVsPSJ0ZXh0IgogICAgIHN0eWxlPSJkaXNwbGF5OmlubGluZTtvcGFjaXR5OjEiCiAgICAgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzE1LjUwMzIyLDE5LjUyNjk5MSkiPgogICAgPGZsb3dSb290CiAgICAgICB4bWw6c3BhY2U9InByZXNlcnZlIgogICAgICAgaWQ9ImZsb3dSb290NDkxOSIKICAgICAgIHN0eWxlPSJmb250LXN0eWxlOm5vcm1hbDtmb250LXZhcmlhbnQ6bm9ybWFsO2ZvbnQtd2VpZ2h0OjMwMDtmb250LXN0cmV0Y2g6bm9ybWFsO2ZvbnQtc2l6ZTo1cHg7bGluZS1oZWlnaHQ6MTI1JTtmb250LWZhbWlseTonUm9ib3RvIExpZ2h0JzstaW5rc2NhcGUtZm9udC1zcGVjaWZpY2F0aW9uOidSb2JvdG8gTGlnaHQsIExpZ2h0Jzt0ZXh0LWFsaWduOnN0YXJ0O2xldHRlci1zcGFjaW5nOjBweDt3b3JkLXNwYWNpbmc6MHB4O3dyaXRpbmctbW9kZTpsci10Yjt0ZXh0LWFuY2hvcjpzdGFydDtmaWxsOiMxNmEwODU7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjFweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIgogICAgICAgdHJhbnNmb3JtPSJtYXRyaXgoMC4yNjQ1ODMzMywwLDAsMC4yNjQ1ODMzMywtMjQ0LjEwODM5LC0wLjU0MjA2MjYzKSI+PGZsb3dSZWdpb24KICAgICAgICAgaWQ9ImZsb3dSZWdpb240OTIxIgogICAgICAgICBzdHlsZT0iZmlsbDojMTZhMDg1O2ZpbGwtb3BhY2l0eToxIj48cmVjdAogICAgICAgICAgIGlkPSJyZWN0NDkyMyIKICAgICAgICAgICB3aWR0aD0iMTQzNy4xNDI4IgogICAgICAgICAgIGhlaWdodD0iMjQ1LjcxNDI4IgogICAgICAgICAgIHg9Ii0xMS40Mjg1NzIiCiAgICAgICAgICAgeT0iOTA4Ljc4NjI1IgogICAgICAgICAgIHN0eWxlPSJmaWxsOiMxNmEwODU7ZmlsbC1vcGFjaXR5OjEiIC8+PC9mbG93UmVnaW9uPjxmbG93UGFyYQogICAgICAgICBpZD0iZmxvd1BhcmE0OTI1IgogICAgICAgICBzdHlsZT0iZm9udC1zdHlsZTpub3JtYWw7Zm9udC12YXJpYW50Om5vcm1hbDtmb250LXdlaWdodDozMDA7Zm9udC1zdHJldGNoOm5vcm1hbDtmb250LXNpemU6MjI5LjMzMzM0MzUxcHg7Zm9udC1mYW1pbHk6UXVpY2tzYW5kOy1pbmtzY2FwZS1mb250LXNwZWNpZmljYXRpb246J1F1aWNrc2FuZCBMaWdodCc7ZmlsbDojMTZhMDg1O2ZpbGwtb3BhY2l0eToxIj5tdWx0aXZlcnN1bTwvZmxvd1BhcmE+PGZsb3dQYXJhCiAgICAgICAgIHN0eWxlPSJmb250LXN0eWxlOm5vcm1hbDtmb250LXZhcmlhbnQ6bm9ybWFsO2ZvbnQtd2VpZ2h0OjMwMDtmb250LXN0cmV0Y2g6bm9ybWFsO2ZvbnQtc2l6ZToyMjkuMzMzMzQzNTFweDtmb250LWZhbWlseTpRdWlja3NhbmQ7LWlua3NjYXBlLWZvbnQtc3BlY2lmaWNhdGlvbjonUXVpY2tzYW5kIExpZ2h0JztmaWxsOiMxNmEwODU7ZmlsbC1vcGFjaXR5OjEiCiAgICAgICAgIGlkPSJmbG93UGFyYTQ1OTQiIC8+PC9mbG93Um9vdD4gIDwvZz4KICA8ZwogICAgIGlua3NjYXBlOmdyb3VwbW9kZT0ibGF5ZXIiCiAgICAgaWQ9ImxheWVyMTYiCiAgICAgaW5rc2NhcGU6bGFiZWw9InllbGxvd3RlYWwiCiAgICAgc3R5bGU9ImRpc3BsYXk6aW5saW5lIgogICAgIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAsLTgxLjM1MzkzOSkiPgogICAgPGcKICAgICAgIGlua3NjYXBlOmdyb3VwbW9kZT0ibGF5ZXIiCiAgICAgICBpZD0ibGF5ZXIxNCIKICAgICAgIGlua3NjYXBlOmxhYmVsPSJtX3llbGxfdGVhbF9iYWNrIgogICAgICAgc3R5bGU9ImRpc3BsYXk6aW5saW5lIj4KICAgICAgPHBhdGgKICAgICAgICAgc3R5bGU9ImRpc3BsYXk6aW5saW5lO29wYWNpdHk6MTtmaWxsOiMxYWJjOWM7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjAuNzU1OTUyNDJweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIgogICAgICAgICBkPSJtIDMyNy4wMTM0Myw5OS45NTcwOCBjIC0xNC45Njk3MiwwLjQ3MzM3IC0yNi4wMzEzOSwxOS43MTc3NyAtMTcuMzQyNTEsMzIuNDQ2NjkgMjQuNzA0NjksNDYuNDAwNDUgNDkuOTY5NTQsOTIuNTE5NDQgNzYuMTQ4NzksMTM4LjEwNDc1IDYuNTk3NTIsMTEuNTgzMTcgMjQuOTMxNzUsMTIuNTAzNDcgMzMuMDI0MjEsMi4wMTUzNyA2LjI2OTAxLC03LjE1MDA1IDcuNjg5MTEsLTE4LjQ0MTM5IDEuOTg5ODUsLTI2LjM2NDc0IC0yNC42MTg4OSwtNDYuMTM3MSAtNDkuNzU4NTQsLTkyLjAxNjQgLTc1LjkxNTIsLTEzNy4zMDA0MyAtMy41MzAxMiwtNi4wMjk5NyAtMTEuMDkyNzYsLTkuMjAyNDg0IC0xNy45MDUxNCwtOC45MDE2NCB6IgogICAgICAgICBpZD0icGF0aDQ4ODQiCiAgICAgICAgIGlua3NjYXBlOmNvbm5lY3Rvci1jdXJ2YXR1cmU9IjAiIC8+CiAgICA8L2c+CiAgICA8cGF0aAogICAgICAgc3R5bGU9ImRpc3BsYXk6aW5saW5lO29wYWNpdHk6MTtmaWxsOiNmMWM0MGY7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjAuNzU1OTUyNDJweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIgogICAgICAgZD0ibSAxNzcuNzk1NTEsOTkuNzQxNTE1IGMgLTcuMzQxODcsMC43NTUyMDUgLTE0LjgzMTU1LDQuOTA5MzY1IC0xNy42NTA2LDEyLjA0NDg2NSAtMjUuODcxNDcsNDUuNjgzNDggLTUxLjU3NzI1LDkxLjQ4MDU0IC03Ni4yOTEyMjgsMTM3LjgwMDU3IC01LjE0MjIsMTIuNzMwOSA0LjE3MTk2NywyOS43Nzk3MSAxOC40MzIyMzgsMzAuMTQyMTEgOC40MDQ0NywwLjU3NDggMTcuMTM3NCwtMy45Njc5NSAyMC4xNzMsLTEyLjEwNDA5IDI1Ljc0NzczLC00NS4zODQ0NiA1MS40MzkwNSwtOTAuODIyMzIgNzYuMDk4NzEsLTEzNi44MDUyNCAyLjYxMjk2LC03Ljg0NTk5IDEuNzQ2NjUsLTE3LjQ2ODAyIC00LjMwODM0LC0yMy41ODM2NSAtNC4xNDY2NiwtNC41NjcwOCAtMTAuMTc1MTYsLTcuNzYyNzMgLTE2LjQ1Mzc4LC03LjQ5NDU2NSB6IgogICAgICAgaWQ9InBhdGg0ODczIgogICAgICAgaW5rc2NhcGU6Y29ubmVjdG9yLWN1cnZhdHVyZT0iMCIgLz4KICAgIDxwYXRoCiAgICAgICBzdHlsZT0iZGlzcGxheTppbmxpbmU7b3BhY2l0eToxO2ZpbGw6I2YxYzQwZjtmaWxsLW9wYWNpdHk6MTtzdHJva2U6bm9uZTtzdHJva2Utd2lkdGg6MC43NTU5NTI0MnB4O3N0cm9rZS1saW5lY2FwOmJ1dHQ7c3Ryb2tlLWxpbmVqb2luOm1pdGVyO3N0cm9rZS1vcGFjaXR5OjEiCiAgICAgICBkPSJtIDMyNy43MDg4NCw5OS45NDIzMTUgYyAtOC4xODQ5NiwwLjEwNjUxNSAtMTUuNjQ4NDgsNS40NzA4NTUgLTE4LjcyMDI2LDEzLjAxNDEyNSAtMjUuNzU1NzcsNDUuMjQxMTEgLTUxLjA2MzQ0LDkwLjc1NzUzIC03NS4zMjA1MSwxMzYuODIwOTcgLTYuNTIxNCwxMy4zMzg0OCA1LjQ4ODk0LDMxLjI5NTE4IDIwLjQzODc3LDMwLjA1MDU4IDguMTEzOTgsLTAuMDk3NiAxNS40Mzk0OCwtNS4zOTY1NSAxOC41MDM0OSwtMTIuODUwMjEgMjUuODExNjcsLTQ1LjQ0MDEyIDUxLjE2NTQ4LC05MS4xNTk0NSA3NS41MDMzMiwtMTM3LjQwNzE0IDYuMTE4ODksLTEzLjEyOTg1IC02LjAwMzAyLC0zMC40MjEwODYgLTIwLjQwNDgxLC0yOS42MjgzMjUgeiIKICAgICAgIGlkPSJwYXRoNDg3NSIKICAgICAgIGlua3NjYXBlOmNvbm5lY3Rvci1jdXJ2YXR1cmU9IjAiIC8+CiAgICA8cGF0aAogICAgICAgc3R5bGU9ImRpc3BsYXk6aW5saW5lO29wYWNpdHk6MTtmaWxsOiMxYWJjOWM7ZmlsbC1vcGFjaXR5OjE7c3Ryb2tlOm5vbmU7c3Ryb2tlLXdpZHRoOjAuNzU1OTUyNDJweDtzdHJva2UtbGluZWNhcDpidXR0O3N0cm9rZS1saW5lam9pbjptaXRlcjtzdHJva2Utb3BhY2l0eToxIgogICAgICAgZD0ibSAxNzcuODUxNjIsOTkuOTkzOTkxIGMgLTE0LjQ4Njk5LC0wLjAwODcgLTI1LjQyNDc1LDE3LjI2NTEwOSAtMTguODA1NzksMzAuMjQyNTM5IDIxLjc4NzUxLDQyLjE3OTQ1IDQ1LjM2MDU0LDgzLjQxOTMgNjguNDQzMTMsMTI0Ljg5ODk4IDQuMDc2MzMsNi4yNzUzMSA2LjcwMTIsMTMuNjg0NzIgMTEuNzY3NTUsMTkuMjMyNSA5LjIwMzE5LDkuMDg5MDIgMjYuMTMyMzcsNi4zNzc4MyAzMi4zMTQwMSwtNC44OTAwNyA0LjcyODQsLTcuOTk2MzYgMy45ODIxMiwtMTguNjc5NzkgLTEuMzI4MzQsLTI2LjIzNTA3IC0yNC45NTUsLTQ0Ljk4MjI5IC00OS4xNjgxOCwtOTAuMzk5NzkgLTc1LjI2NTQ1LC0xMzQuNzMzMTIgLTMuNDc0MjQsLTUuNzc3NjYgLTEwLjUwMzA2LC04Ljg5NzAyMyAtMTcuMTI1MTEsLTguNTE1NzU5IHoiCiAgICAgICBpZD0icGF0aDQ4ODIiCiAgICAgICBpbmtzY2FwZTpjb25uZWN0b3ItY3VydmF0dXJlPSIwIiAvPgogIDwvZz4KPC9zdmc+Cg==\" />
											</a>
										</td>
									</tr>
									<!-- Email Body -->
									<tr>
										<td class=\"body\"
											width=\"100%\"
											cellpadding=\"0\"
											cellspacing=\"0\"
											style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;\">
											<table class=\"inner-body\"
												   align=\"center\"
												   width=\"570\"
												   cellpadding=\"0\"
												   cellspacing=\"0\"
												   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;\">
												<!-- Body content -->
												<tr>
													<td class=\"content-cell\"
														style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;\">
														<h1 style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #2F3133; font-size: 19px; font-weight: bold; margin-top: 0; text-align: left;\">
															Beste {$name}, </h1>
														<p style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;\">
															Bedank voor uw bestelling bij Multiversum. Indien u veragen heeft kunt u contact
															met ons opnemen door een email te sturen naar {$own_email}</p>

														<div style=\"border-style: solid; border-width: 1px;\">
															<table width=\"100%\">
																<tr align=\"left\" style=\"border-style: solid; border-width: 1px;\">
																	<th>Artikel Nummer</th>
																	<th>Naam Artikel</th>
																	<th align=\"right\">Prijs artikel inc. BTW</th>
																</tr>
																<tr>
																	<td>#{$product['id']}</td>
																	<td>{$product['name']}</td>
																	<td align=\"right\">€ {$formatted_price}</td>
																</tr>
															</table>
														</div>

														<div style=\"width: 100%\">
															<table align=\"right\" width=\"50%\">
																<tr>
																	<th align=\"right\">Subtotaal:</th>
																	<td align=\"right\">€ {$formatted_total_price}</td>
																</tr>
																<tr>
																	<th align=\"right\">BTW:</th>
																	<td align=\"right\">€ {$tax_order}</td>
																</tr>
																<tr>
																	<th align=\"right\">Totaal:</th>
																	<td align=\"right\">€ {$formatted_total_price}</td>
																</tr>
															</table>
														</div>

														<p style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; padding-top: 5px;text-align: left; margin: 90px 0 30px 0; \">

														<table>
															<tr>
																<th>Adres:</th>
																<td>{$order['address']} {$order['house_number']}</td>
															</tr>
															<tr>
																<th>Woonplaats en Postcode</th>
																<td>{$order['city']} {$order['postcode']}</td>
															</tr>
															<tr>
																<th>Telefoonnummer</th>
																<td>{$order['phone']}</td>
															</tr>
															<tr>
																<th>E-mail</th>
																<td>{$order['email']}</td>
															</tr>
														</table>

														</p>

														<p style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 90px; padding-top: 5px;text-align: left;\">

															<b>Uw bestelling is in behandeling genomen</b><br>
															Uw bestelling is in behandeling genomen. Wij verwachten deze conform de
															levertijd, vermeld op onze website bij de artikelen, te verzenden. Mocht blijken
															dat de levertijd anders is dan op onze website vermeld, dan wordt er met u
															contact (per mail) opgenomen. Heeft u meerdere artikelen met verschillende
															levertijden besteld? Dan wordt uw bestelling compleet verzonden wanneer alle
															artikelen binnen zijn. <br><br>

															<b>Levertijd van artikelen</b><br>
															Wanneer u een artikel aanklikt op onze site, ziet u boven de prijs de levertijd van elk artikel.

														</p>

														<p style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 5px; padding-top: 5px; text-align: left;\">
															<b>Met vriendelijke groet,</b><br>

															<br><b>Multiversum</b> <br>
															<a style=\"text-decoration: none;\"
															   href=\"Multiversum@snoozing.dev\">Multiversum@snoozing.dev</a><br>
															<a style=\"text-decoration: none;\"
															   href=\"https://multiversum.snoozing.dev\">Multiversum.snoozing.dev</a></p>

													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;\">
											<table class=\"footer\"
												   align=\"center\"
												   width=\"570\"
												   cellpadding=\"0\"
												   cellspacing=\"0\"
												   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;\">
												<tr>
													<td class=\"content-cell\"
														align=\"center\"
														style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;\">
														<p style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center;\">
															© 2020 Multiversum. Alle rechten voorbehouden.</p>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</body>
					</html>";

		return $content;

	}
}
