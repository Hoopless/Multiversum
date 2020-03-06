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
        try {

            $email = $this->email;

            $email->setFrom("multiversum@snoozing.dev");
            $email->setSubject("Received email");
            $email->addTo("multiversum@snoozing.dev", $data['name']);
            $email->setReplyTo($data['email']);
            $email->addContent("text/plain", "There has been an e-mail from {$data['name']}. With the following subject \n {$data['subject']} \n Their e-mail: {$data['email']}");

            $response = $this->sendgrind->send(($email));

            if ($response->statusCode() !== 200 || $response->statusCode() !== 202) {
                $array = json_decode($response->body());

                if (isset($array->errors[0])){
                    return json_encode($array->errors[0]);
                }

                return json_encode("Error! could not find error code.");

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