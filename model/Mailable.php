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
												<svg
												   xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
												   xmlns:cc=\"http://creativecommons.org/ns#\"
												   xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\"
												   xmlns:svg=\"http://www.w3.org/2000/svg\"
												   xmlns=\"http://www.w3.org/2000/svg\"
												   xmlns:sodipodi=\"http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd\"
												   xmlns:inkscape=\"http://www.inkscape.org/namespaces/inkscape\"
												   width=\"1920\"
												   height=\"1080\"
												   viewBox=\"0 0 508 285.75001\"
												   version=\"1.1\"
												   id=\"svg8\"
												   inkscape:version=\"0.92.4 (5da689c313, 2019-01-14)\"
												   sodipodi:docname=\"vr_v2.svg\"
												   inkscape:export-filename=\"D:\pa\Documents\rsrch_pics\mvm_m.png\"
												   inkscape:export-xdpi=\"96\"
												   inkscape:export-ydpi=\"96\">
												  <defs
													 id=\"defs2\">
													<marker
													   style=\"overflow:visible\"
													   refY=\"0\"
													   refX=\"0\"
													   orient=\"auto\"
													   id=\"DistanceX\">
													  <path
														 id=\"path4487\"
														 style=\"stroke:#000000;stroke-width:0.5\"
														 d=\"M 3,-3 -3,3 M 0,-5 V 5\"
														 inkscape:connector-curvature=\"0\" />
													</marker>
													<pattern
													   y=\"0\"
													   x=\"0\"
													   width=\"8\"
													   patternUnits=\"userSpaceOnUse\"
													   id=\"Hatch\"
													   height=\"8\">
													  <path
														 id=\"path4490\"
														 stroke-width=\"0.25\"
														 stroke=\"#000000\"
														 linecap=\"square\"
														 d=\"M8 4 l-4,4\" />
													  <path
														 id=\"path4492\"
														 stroke-width=\"0.25\"
														 stroke=\"#000000\"
														 linecap=\"square\"
														 d=\"M6 2 l-4,4\" />
													  <path
														 id=\"path4494\"
														 stroke-width=\"0.25\"
														 stroke=\"#000000\"
														 linecap=\"square\"
														 d=\"M4 0 l-4,4\" />
													</pattern>
													<symbol
													   id=\"$MODEL_SPACE\" />
													<symbol
													   id=\"$PAPER_SPACE\" />
												  </defs>
												  <sodipodi:namedview
													 id=\"base\"
													 pagecolor=\"#ffffff\"
													 bordercolor=\"#666666\"
													 borderopacity=\"1.0\"
													 inkscape:pageopacity=\"0.0\"
													 inkscape:pageshadow=\"2\"
													 inkscape:zoom=\"0.36173363\"
													 inkscape:cx=\"220.45234\"
													 inkscape:cy=\"989.35144\"
													 inkscape:document-units=\"mm\"
													 inkscape:current-layer=\"layer11\"
													 showgrid=\"false\"
													 inkscape:window-width=\"1920\"
													 inkscape:window-height=\"1001\"
													 inkscape:window-x=\"-9\"
													 inkscape:window-y=\"-9\"
													 inkscape:window-maximized=\"1\"
													 fit-margin-top=\"0\"
													 fit-margin-left=\"0\"
													 fit-margin-right=\"0\"
													 fit-margin-bottom=\"0\"
													 units=\"px\"
													 inkscape:pagecheckerboard=\"true\" />
												  <metadata
													 id=\"metadata5\">
													<rdf:RDF>
													  <cc:Work
														 rdf:about=\"\">
														<dc:format>image/svg+xml</dc:format>
														<dc:type
														   rdf:resource=\"http://purl.org/dc/dcmitype/StillImage\" />
														<dc:title></dc:title>
													  </cc:Work>
													</rdf:RDF>
												  </metadata>
												  <g
													 inkscape:groupmode=\"layer\"
													 id=\"layer11\"
													 inkscape:label=\"glass000\"
													 style=\"display:inline\"
													 transform=\"translate(315.50322,19.526991)\">
													<path
													   style=\"fill:#2c3e50;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m -232.21651,39.467925 c -5.67113,-0.231029 -11.68295,3.406183 -13.93935,8.609293 -2.60909,12.660762 -1.06146,25.794256 -1.66625,38.637583 0.52101,9.535948 -1.48068,19.712999 2.10181,28.814929 2.8499,4.18334 6.32957,8.39355 10.49769,11.22413 2.64472,-1.30952 1.44759,-5.72186 2.3845,-8.13978 3.3804,-26.149883 6.0671,-52.391613 9.63544,-78.511274 -2.13818,-1.521058 -6.29855,-0.253344 -9.01384,-0.634881 z\"
													   id=\"path4902\"
													   inkscape:connector-curvature=\"0\" />
													<path
													   style=\"fill:#2c3e50;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m -64.446713,-11.60463 c -43.145177,0.429666 -86.409867,8.8657684 -126.120077,25.855931 -14.80059,6.52229 -23.87424,22.32558 -24.45904,38.174895 -3.16316,27.048777 -7.20321,54.034404 -9.19265,81.199164 0.26214,11.1817 5.11489,22.6536 13.60714,30.03877 14.34002,10.82366 29.09257,21.23011 44.57759,30.34735 10.43636,5.92802 22.59495,2.96304 33.61544,0.8088 22.7761,-4.24757 45.174717,-10.63622 68.15025,-13.72348 13.766447,0.0189 27.048322,4.49359 40.518419,6.88697 16.6189867,3.34044 33.1324133,7.64505 49.940343,9.81806 15.237854,-0.10569 26.866995,-11.32565 39.075319,-18.87013 10.075744,-7.7811 22.819558,-13.40946 29.181905,-25.02261 5.846444,-9.61732 6.263054,-21.23836 4.597927,-32.07995 C 96.060193,95.134223 93.212826,68.383444 89.176929,41.834705 85.890489,28.71311 76.121895,17.482462 63.301831,12.929861 22.910295,-3.5783916 -20.818881,-11.920801 -64.446713,-11.60463 Z\"
													   id=\"path4904\"
													   inkscape:connector-curvature=\"0\" />
													<path
													   style=\"fill:#2c3e50;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m 98.859613,40.124954 c 4.257387,28.289901 6.603157,56.891036 10.794467,85.183436 0.95055,3.32543 3.78082,-0.59138 4.98899,-1.6876 4.87801,-4.30657 8.95111,-9.97777 8.6152,-16.79308 0.56901,-19.045421 0.0335,-38.151814 -0.14616,-57.178052 -3.00259,-5.421513 -8.06402,-10.316697 -14.68202,-10.099051 -3.01696,0.219618 -7.16309,-0.932727 -9.570477,0.574347 z\"
													   id=\"path4906\"
													   inkscape:connector-curvature=\"0\" />
												  </g>
												  <g
													 inkscape:groupmode=\"layer\"
													 id=\"layer9\"
													 inkscape:label=\"text\"
													 style=\"display:inline;opacity:1\"
													 transform=\"translate(315.50322,19.526991)\">
													<flowRoot
													   xml:space=\"preserve\"
													   id=\"flowRoot4919\"
													   style=\"font-style:normal;font-variant:normal;font-weight:300;font-stretch:normal;font-size:5px;line-height:125%;font-family:'Roboto Light';-inkscape-font-specification:'Roboto Light, Light';text-align:start;letter-spacing:0px;word-spacing:0px;writing-mode:lr-tb;text-anchor:start;fill:#16a085;fill-opacity:1;stroke:none;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   transform=\"matrix(0.26458333,0,0,0.26458333,-244.10839,-0.54206263)\"><flowRegion
														 id=\"flowRegion4921\"
														 style=\"fill:#16a085;fill-opacity:1\"><rect
														   id=\"rect4923\"
														   width=\"1437.1428\"
														   height=\"245.71428\"
														   x=\"-11.428572\"
														   y=\"908.78625\"
														   style=\"fill:#16a085;fill-opacity:1\" /></flowRegion><flowPara
														 id=\"flowPara4925\"
														 style=\"font-style:normal;font-variant:normal;font-weight:300;font-stretch:normal;font-size:229.33334351px;font-family:Quicksand;-inkscape-font-specification:'Quicksand Light';fill:#16a085;fill-opacity:1\">multiversum</flowPara><flowPara
														 style=\"font-style:normal;font-variant:normal;font-weight:300;font-stretch:normal;font-size:229.33334351px;font-family:Quicksand;-inkscape-font-specification:'Quicksand Light';fill:#16a085;fill-opacity:1\"
														 id=\"flowPara4594\" /></flowRoot>  </g>
												  <g
													 inkscape:groupmode=\"layer\"
													 id=\"layer16\"
													 inkscape:label=\"yellowteal\"
													 style=\"display:inline\"
													 transform=\"translate(0,-81.353939)\">
													<g
													   inkscape:groupmode=\"layer\"
													   id=\"layer14\"
													   inkscape:label=\"m_yell_teal_back\"
													   style=\"display:inline\">
													  <path
														 style=\"display:inline;opacity:1;fill:#1abc9c;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
														 d=\"m 327.01343,99.95708 c -14.96972,0.47337 -26.03139,19.71777 -17.34251,32.44669 24.70469,46.40045 49.96954,92.51944 76.14879,138.10475 6.59752,11.58317 24.93175,12.50347 33.02421,2.01537 6.26901,-7.15005 7.68911,-18.44139 1.98985,-26.36474 -24.61889,-46.1371 -49.75854,-92.0164 -75.9152,-137.30043 -3.53012,-6.02997 -11.09276,-9.202484 -17.90514,-8.90164 z\"
														 id=\"path4884\"
														 inkscape:connector-curvature=\"0\" />
													</g>
													<path
													   style=\"display:inline;opacity:1;fill:#f1c40f;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m 177.79551,99.741515 c -7.34187,0.755205 -14.83155,4.909365 -17.6506,12.044865 -25.87147,45.68348 -51.57725,91.48054 -76.291228,137.80057 -5.1422,12.7309 4.171967,29.77971 18.432238,30.14211 8.40447,0.5748 17.1374,-3.96795 20.173,-12.10409 25.74773,-45.38446 51.43905,-90.82232 76.09871,-136.80524 2.61296,-7.84599 1.74665,-17.46802 -4.30834,-23.58365 -4.14666,-4.56708 -10.17516,-7.76273 -16.45378,-7.494565 z\"
													   id=\"path4873\"
													   inkscape:connector-curvature=\"0\" />
													<path
													   style=\"display:inline;opacity:1;fill:#f1c40f;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m 327.70884,99.942315 c -8.18496,0.106515 -15.64848,5.470855 -18.72026,13.014125 -25.75577,45.24111 -51.06344,90.75753 -75.32051,136.82097 -6.5214,13.33848 5.48894,31.29518 20.43877,30.05058 8.11398,-0.0976 15.43948,-5.39655 18.50349,-12.85021 25.81167,-45.44012 51.16548,-91.15945 75.50332,-137.40714 6.11889,-13.12985 -6.00302,-30.421086 -20.40481,-29.628325 z\"
													   id=\"path4875\"
													   inkscape:connector-curvature=\"0\" />
													<path
													   style=\"display:inline;opacity:1;fill:#1abc9c;fill-opacity:1;stroke:none;stroke-width:0.75595242px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1\"
													   d=\"m 177.85162,99.993991 c -14.48699,-0.0087 -25.42475,17.265109 -18.80579,30.242539 21.78751,42.17945 45.36054,83.4193 68.44313,124.89898 4.07633,6.27531 6.7012,13.68472 11.76755,19.2325 9.20319,9.08902 26.13237,6.37783 32.31401,-4.89007 4.7284,-7.99636 3.98212,-18.67979 -1.32834,-26.23507 -24.955,-44.98229 -49.16818,-90.39979 -75.26545,-134.73312 -3.47424,-5.77766 -10.50306,-8.897023 -17.12511,-8.515759 z\"
													   id=\"path4882\"
													   inkscape:connector-curvature=\"0\" />
												  </g>
												</svg>
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
