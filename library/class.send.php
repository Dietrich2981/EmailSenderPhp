<?php
require_once('class.db.php');

class send
{

    private $_host = 'smtp.example.com';
    private $_auth = true;
    private $_port = '465';
    private $_username = 'username@example.com';
    private $_password = '*********';
    private $_secure = 'ssl';
    private $_from = null;
    private $_subject = null;
    private $_message = null;
    private $_replyMail = null;
    private $_replyName = null;
    private $_stats = array
    (
        'all' => 0,
        'success' => 0,
        'error' => 0
    );

    /**
     * Send mail
     * @param  [string] $mail_to [mail to send]
     * @return [int]          [1 = success; 2 = error send; 3 = empty fields]
     */
    private function sendMail($mail_to)
    {
        if ($mail_to == null || $this->_from == null || $this->_from == null || $this->_message == null)
        {
            return 3;
        }
        require_once('PHPMailerAutoload.php');
        try
        {
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->Host = $this->_host;
            $mail->SMTPAuth = $this->_auth;
            $mail->Port = $this->_port;
            $mail->SMTPSecure = $this->_secure;
            $mail->CharSet = "UTF-8";
            $mail->Username = $this->_username;
            $mail->Password = $this->_password;
            $mail->AddAddress($mail_to, '');
            $mail->AddReplyTo($this->_replyMail, $this->_replyName);
            $mail->SetFrom($this->_username, $this->_from);
            $mail->Subject = htmlspecialchars($this->_subject);
            $mail->MsgHTML($this->_message);
            $mail->AddEmbeddedImage('1.jpg', 'my_img', 'image . jpg', 'base64', 'image/jpg');
            $mail->Send();
            return 1;
        } catch (phpmailerException $e)
        {
            return 2;
        }
    }

    /**
     * [Change message]
     * @param  [string] $from
     * @param  [string] $subject
     * @param  [string] $message
     * @param  [string] $replyMail
     * @param  [string] $replyName
     */
    public function changeMessage($from, $subject, $message, $replyMail, $replyName)
    {
        $this->_from = $from;
        $this->_subject = $subject;
        $this->_message = $message;
        $this->_replyMail = $replyMail;
        $this->_replyName = $replyName;
    }

    public function setFrom($from)
    {
        $this->_from = $from;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->_subject = $subject;
        return $this;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
        return $this;
    }

    public function setReplyMail($replyMail)
    {
        $this->_replyMail = $replyMail;
        return $this;
    }

    public function setReplyName($replyName)
    {
        $this->_replyName = $replyName;
        return $this;
    }


    /**
     * [Send out on the list of mails]
     * @param  [array] $mails_to [Mails list]
     * @return [array] [Statistics]
     */
    public function massSender($mails_to)
    {
        $i = 0;
        $countMail = count($mails_to);
        if ($countMail == null)
        {
            return 'Список рассылки пуст';
        }
        if ($mails_to[$countMail - 1] == null)
        {
            $countMail--;
        }
        $this->_stats['success'] = 0;
        $this->_stats['error'] = 0;
        $this->_stats['all'] = $countMail;
        while ($i < $countMail)
        {
            if ($this->sendMail($mails_to[$i]) == 1)
            {
                $this->_stats['success']++;
            } else
            {
                $this->_stats['error']++;
            }
            $i++;
        }
        $this->saveResult($this->_stats, $this->_message, $this->_subject);
        return $this->_stats;
    }

    /**
     * [Save result to database]
     * @param $stats
     * @param $message
     * @param $subject
     * @internal param $ [array] $stats
     * @internal param $ [array] $message
     */
    private function saveResult($stats, $message, $subject)
    {
        $request = "INSERT INTO `history` (`id`, `data`, `all_mails`, `success`, `error`, `subject`, `message`) VALUES (NULL, '" . date("Y-m-d") . "', '" . $stats['all'] . "', '" . $stats['success'] . "', '" . $stats['error'] . "', '" . $subject . "', '" . $message . "')";
        db::querydb($request);
    }
}

?>