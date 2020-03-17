<?php


class Mailable
{

	/**
	 * @var \SendGrid\Mail\Mail
	 */
	private static $email = "multiversum@snoozing.dev";
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
		$own_email             = self::$email;

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
											<a href=\"http://xelion.localhost\"
											   style=\"font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;\">
												
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
