<?php

    /*
    $this->config['smtp_username'] //Смените на имя своего почтового ящика.
    $this->config['smtp_port'] // Порт работы. Не меняйте, если не уверены.
    $this->config['smtp_host'] //сервер для отправки почты
    $this->config['smtp_password'] //Измените пароль
    $this->config['smtp_debug'] //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
    $this->config['smtp_charset']	//кодировка сообщений. (или UTF-8, итд)
    $this->config['smtp_from'] //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
    */


    class classMail{

        private $config = array();

        function __construct($smtp_username, $smtp_host, $smtp_password, $smtp_from, $smtp_charset = 'UTF-8'){

           $this->config['smtp_username'] = $smtp_username;  //Смените на имя своего почтового ящика.
	       $this->config['smtp_port']	 = '25'; // Порт работы. Не меняйте, если не уверены.
	       $this->config['smtp_host']	 = $smtp_host;  //сервер для отправки почты
	       $this->config['smtp_password'] = $smtp_password;  //Измените пароль
	       $this->config['smtp_debug']	= true;  //Если Вы хотите видеть сообщения ошибок, укажите true вместо false
	       $this->config['smtp_charset']  = $smtp_charset;	//кодировка сообщений. (или UTF-8, итд)
	       $this->config['smtp_from']	 = $smtp_from; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"

        }

        public function send($to, $subject, $message){

            $this->smtpmail($to, $subject, $message);

        }

        private function smtpmail($mail_to, $subject, $message, $headers='') {
        //global $this->config;
        $SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
        $SEND .=	'Subject: =?'.$this->config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
        if ($headers) $SEND .= $headers."\r\n\r\n";
        else
        {

                $SEND .= "Reply-To: ".$this->config['smtp_username']."\r\n";
                $SEND .= "MIME-Version: 1.0\r\n";
                $SEND .= "Content-Type: text/plain; charset=\"".$this->config['smtp_charset']."\"\r\n";
                $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
                $SEND .= "From: \"".$this->config['smtp_from']."\" <".$this->config['smtp_username'].">\r\n";
                $SEND .= "To: $mail_to <$mail_to>\r\n";
                $SEND .= "X-Priority: 3\r\n\r\n";

        }
        $SEND .=  $message."\r\n";
         if( !$socket = fsockopen($this->config['smtp_host'], $this->config['smtp_port'], $errno, $errstr, 30) ) {
            if ($this->config['smtp_debug']) echo $errno."<br>".$errstr;
            return false;
         }

        if (!$this->server_parse($socket, "220", __LINE__)) return false;

        fputs($socket, "EHLO " . $this->config['smtp_host'] . "\r\n");
        if (!$this->server_parse($socket, "250", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не могу отправить EHLO</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, "AUTH LOGIN\r\n");
        if (!$this->server_parse($socket, "334", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не могу найти ответ на запрос авторизаци.</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, base64_encode($this->config['smtp_username']) . "\r\n");
        if (!$this->server_parse($socket, "334", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Логин авторизации не был принят сервером!</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, base64_encode($this->config['smtp_password']) . "\r\n");
        if (!$this->server_parse($socket, "235", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Пароль не был принят сервером как верный! Ошибка авторизации!</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, "MAIL FROM: <".$this->config['smtp_username'].">\r\n");
        if (!$this->server_parse($socket, "250", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду MAIL FROM: </p>';
            fclose($socket);
            return false;
        }
        fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");

        if (!$this->server_parse($socket, "250", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду RCPT TO: </p>';
            fclose($socket);
            return false;
        }
        fputs($socket, "DATA\r\n");

        if (!$this->server_parse($socket, "354", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не могу отправить комманду DATA</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, $SEND."\r\n.\r\n");

        if (!$this->server_parse($socket, "250", __LINE__)) {
            if ($this->config['smtp_debug']) echo '<p>Не смог отправить тело письма. Письмо не было отправленно!</p>';
            fclose($socket);
            return false;
        }
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        return TRUE;
    }

        private function server_parse($socket, $response, $line = __LINE__) {
            //global $this->config;
            while (@substr($server_response, 3, 1) != ' ') {
                if (!($server_response = fgets($socket, 256))) {
                    if ($this->config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
                    return false;
                }
            }
            if (!(substr($server_response, 0, 3) == $response)) {
                if ($this->config['smtp_debug']) echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
                return false;
            }
            return true;
    }
    }

?>
