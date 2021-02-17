<?php

namespace Hcode;

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

use Rain\Tpl;

class Mailer {

    const USERNAME = "sandroantoniosouza98@gmail.com";
    const PASSWORD = "copague5";
    const NAME_FROM = "Sandro Ecommerce";

    private $mail;

    public function __construct($toAddress, $toName, $subject, $tplName, $data = array())
    {

        $config = array(
		    //"base_url"      => null,
		    "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']."/views/email/",
		    "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
		    "debug"         => false
		);

		Tpl::configure( $config );

		$tpl = new Tpl();

        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }

        $html = $tpl->draw($tplName, true);

        $this->mail = new \PHPMailer(true);

        $this->mail->isSMTP();
    
        //Enable SMTP debugging
        // SMTP::DEBUG_OFF = off (for production use)
        // SMTP::DEBUG_CLIENT = client messages
        // SMTP::DEBUG_SERVER = client and server messages
        $this->mail->SMTPDebug = \SMTP::DEBUG_OFF;

        $this->mail->Debugoutput = 'html';
        $this->mail->Host = 'smtp.gmail.com';
        // use
        // $this->mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        $this->mail->Port = 587;
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
            );

        $this->SMTPSecure = 'tls';   
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Mailer::USERNAME;
        $this->mail->Password = Mailer::PASSWORD;
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

        //Set an alternative reply-to address
        //$this->mail->addReplyTo('replyto@example.com', 'First Last');

        $this->mail->addAddress($toAddress, $toName);
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($html);
        $this->mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
        //$this->mail->addAttachment('images/phpmailer_mini.png');

    }

    public function send()
    {
        //var_dump($this->mail->send());
        return $this->mail->send();

    }
    
}

?>