<?php


class Mailable
{

    private $token;

    public function __construct()
    {
        $this->token     = getenv("SENDGRID_API_KEY");
        $this->sendgrind = new \SendGrid($this->token);
        $this->email     = new \SendGrid\Mail\Mail();
    }

    public function sendMail($data)
    {
        if (! isset($data['name']) || ! isset($data['email']) || ! isset($data['subject']) ){
            return json_encode([
                'name' => 'Geen waarde opgestuurd.',
                'email' => 'Geen waarde opgestuurd.',
                'subject' => 'Geen waarde opgestuurd.'
                ]);
        }

        if (! filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            return json_encode([
                    'email' => 'Ongeldig email'
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

                if (isset($array->errors[0])){
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
}
