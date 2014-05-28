<?php

class Mail {

    protected $name;
    protected $From;
    protected $to;
    protected $subject;
    protected $body;

    public function sendMail($from, $to, $template_id, $replacements) {
        $replacements["[#SITE_NAME#]"] = Yii::app()->name;
        $replacements["[#SITE_URL#]"] = Yii::app()->baseUrl;

        $emailTemplates = new EmailTemplates;
        //$data = $emailTemplates->findByPk($id);
        $data = $emailTemplates->findByPk($template_id);
        $subject = $data->email_title;
        $body = $data->email_content;


        //var_dump($data);

        foreach ($replacements as $key => $value) {
            $subject = str_replace($key, $value, $subject);
            $body = str_replace($key, $value, $body);
        }

        Yii::import('application.extensions.mail.swiftmailer.lib.classes.Swift', true);
        Yii::registerAutoloader(array('Swift', 'autoload'));
        Yii::import('application.extensions.mail.swiftmailer.lib.swift_init', true);
        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1') {
            /* $this->smtp_host='mail.4hirescotland.com';
              $this->smtp_port='26';
              $this->smtp_user='test@hrtmcc.org';
              $this->smtp_pass='test01'; */
            $transport = Swift_SmtpTransport::newInstance('mail.4hirescotland.com', 26)->setUsername('test@hrtmcc.org')->setPassword('test01');
            //$from = array("sidshakya@wlink.com" => "No Reply - Shipmates.co.za");
            //$transport = Swift_SmtpTransport::newInstance('smtp.ntc.net.np', 25);
            //$transport = Swift_MailTransport::newInstance();
        } else {
            $transport = Swift_MailTransport::newInstance();
        }

        /*
          You could alternatively use a different transport such as Sendmail or Mail:

          // Sendmail
          $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

          // Mail
          $transport = Swift_MailTransport::newInstance();
         */
        //$transport = Swift_MailTransport::newInstance();
        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        //$message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBcc(array('meshobhitshakya@gmail.com' => 'Shobhit Shakya','jems.khadgi@gmail.com' => 'Jems Khadgi','shobhitshakya@yahoo.com'=>'Shobhit Yahoo'))->setBody($body);
        $message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBody($body, 'text/html');

        // Send the message
        $result = $mailer->send($message);
        return $result;
    }

    public function sendQueuedMail($queue) {
        $from = unserialize($queue['queue_from']);
        $to = unserialize($queue['queue_to']);
        $subject = $queue['queue_subject'];
        $body = $queue['queue_content'];
        if ($queue['attach_file']) {
            $attachment = Yii::app()->request->hostInfo . '/uploads/document/' . $queue['attach_file'];
            //$attachment = Yii::app()->request->hostInfo.'/imageblog/trunk/uploads/document/'.$queue['attach_file'];
        }

        Yii::import('application.extensions.mail.swiftmailer.lib.classes.Swift', true);
        Yii::registerAutoloader(array('Swift', 'autoload'));
        Yii::import('application.extensions.mail.swiftmailer.lib.swift_init', true);

        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
            /* $transport = Swift_SmtpTransport::newInstance('smtp.wlink.com.np', 25);
              $from = array("sidshakya@wlink.com" => "No Reply - Shipmates.co.za"); */
            //$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -t -i');
            //$transport = Swift_SmtpTransport::newInstance('smtp.broadlink.com.np', 25);
            $transport = Swift_SmtpTransport::newInstance('mail.offersnepal.com', 26)->setUsername('sanjay@offersnepal.com')->setPassword('sanjay@123#');
        } else {
            $transport = Swift_MailTransport::newInstance();
        }

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        $message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBody($body)->addPart(nl2br($body), 'text/html');
        if ($attachment) {
            $swiftAttachment = Swift_Attachment::fromPath($attachment); // create a Swift Attachment
            $message->attach($swiftAttachment); // now attach the correct type
        }
        //$message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBody($body)->addPart(nl2br($body)->attach($attachment), 'text/html')
        // Send the message
        $result = $mailer->send($message);
        if ($result)
            return true;
        else
            return false;
    }

    public function queueMail($from, $to, $subject, $body) {
        $emailLogs = new Emails;
        $emailLogs->from = $from;
        $emailLogs->to = $to;
        $emailLogs->subject = $subject;
        $emailLogs->message = $body;
        $emailLogs->created_at = new CDbExpression('NOW()');

        if ($emailLogs->save()) {
            return true;
        } else {
            echo '<pre>';
            print_r($emailLogs);
            echo '</pre>';
            Yii::app()->end();
            return false;
        }
    }

    /*
     * send email directly rather than by generating email from templates
     */

    public function sendEmail($from, $to, $subject, $body) {
        Yii::import('application.extensions.mail.swiftmailer.lib.classes.Swift', true);
        Yii::registerAutoloader(array('Swift', 'autoload'));
        Yii::import('application.extensions.mail.swiftmailer.lib.swift_init', true);
        if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '::1') {
            /* $this->smtp_host='mail.4hirescotland.com';
              $this->smtp_port='26';
              $this->smtp_user='test@hrtmcc.org';
              $this->smtp_pass='test01'; */
            //$transport = Swift_SmtpTransport::newInstance('smtp.broadlink.com.np', 25);
//            $transport = Swift_SmtpTransport::newInstance('mail.retailersclub.co.za ', 26)->setUsername('no-reply@retailersclub.co.za')->setPassword('$Fp1hG7[#s]]');
//            $transport = Swift_SmtpTransport::newInstance('mail.offersnepal.com', 26)->setUsername('sanjay@offersnepal.com')->setPassword('sanjay@123#');
//            $transport = Swift_SmtpTransport::newInstance('localhost', 25);
            //$transport = Swift_SmtpTransport::newInstance('mail.4hirescotland.com', 26)->setUsername('test@hrtmcc.org')->setPassword('test01');
//$from = array("sidshakya@wlink.com" => "No Reply - Shipmates.co.za");
//$transport = Swift_SmtpTransport::newInstance('smtp.ntc.net.np', 25);
//$transport = Swift_MailTransport::newInstance();
//            $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 25);
//Supposed to allow local domain sending to work from what I read
            $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')->setUsername('sanjay.ariyaweb@gmail.com')->setPassword('sanjay123#');
            $transport->setLocalDomain('[127.0.0.1]');
            
        } else {
            $transport = Swift_MailTransport::newInstance();
        }
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBody($body, 'text/html');
        $result = $mailer->send($message);
        return $result;
    }

}

?>