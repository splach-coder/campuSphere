<?php
require '..\vendor\autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

require '..\vendor\phpmailer\phpmailer\src\Exception.php';
require '..\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require '..\vendor\phpmailer\phpmailer\src\SMTP.php';
//require '..\vendor\vlucas\phpdotenv\src\Dotenv.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Email {
    private $mail;
    private $Name;
    private $smtpGmail;
    private $smtpPassword;

    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->Name = 'campuSphere';
        $this->smtpGmail =  $_ENV["SMTP_GMAIL"];
        $this->smtpPassword = $_ENV["SMTP_PASSWORD"];
    }

    public function sendEmail($recipientEmail, $Name, $Subject, $Body) {
        try {
            //Server settings
            $this->mail->SMTPDebug = 0;                      // Enable verbose debug output
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   // Enable SMTP authentication 
            $this->mail->Username = $this->smtpGmail;                           // SMTP username
            $this->mail->Password = $this->smtpPassword;                            // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mail->Port       = 587;                                    // TCP port to connect to

            //Recipients
            $this->mail->setFrom($this->smtpGmail, $this->Name);
            $this->mail->addAddress($recipientEmail, $Name);     // Add a recipient
            $this->mail->addReplyTo($this->smtpGmail, $this->Name);

            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $Subject;
            $this->mail->Body    = $Body;
            $this->mail->AltBody = '';

            $this->mail->send();
            
            return 'Email sent successfully';
            
        } catch (Exception $e) {
            return "Email sending failed: {$this->mail->ErrorInfo}";
        }
    }

}
?>
