<?php 

    namespace App\Models;

    use MF\Model\Model;

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use MF\PHPMailer\PHPMailer;
    use MF\PHPMailer\SMTP;
    use MF\PHPMailer\OAuth;
    use MF\PHPMailer\POP3;
    use MF\PHPMailer\Exception;


    class Sendmail extends Model 
    {

        private $mail;
        private $subject;
        private $message;

        // Atributos do alertLogOff
        private $name;
        private $logOff;


        # Função mágica get chamada para sendmail.
        public function __get($attr)
        {
            return $this->$attr;
        }

        # Função mágica set chamada para sendmail.
        public function __set($attr, $value)
        {
            $this->$attr = $value;
        }

        public function sendmail()
        {
          $mailer = new PHPMailer(true);

            try {
                //Server settings
                $mailer->SMTPDebug = false;                             // Enable verbose debug output
                $mailer->isSMTP();                                      // Set mailer to use SMTP
                $mailer->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                $mailer->SMTPAuth = true;                               // Enable SMTP authentication
                $mailer->Username = 'username@gmail.com';                      // SMTP username
                $mailer->Password = 'password';                     // SMTP password
                $mailer->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mailer->Port = 587;                                    // TCP port to connect to
        
                //Recipients
                $mailer->setFrom('username@gmail.com', 'DNSecury');
                $mailer->addAddress($this->mail);     // Add a recipient
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
        
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
                //Content
                $mailer->isHTML(true);                                  // Set email format to HTML
                $mailer->Subject = utf8_decode($this->subject);
                $mailer->Body    = utf8_encode($this->message);
                //$mail->AltBody = ''; //Caso não exista tags html
        
                $mailer->send();
                

            } catch (Exception $e) { 
                echo "<pre>";
                print_r($e); 
                echo "</pre>";              
                //Alguma lógica que armazene o erro para posterior analise por parte do programador.
            }
        }

        public function AlertLogoff()
        {
          $mailer = new PHPMailer(true);

            try {
                //Server settings
                $mailer->SMTPDebug = false;                             // Enable verbose debug output
                $mailer->isSMTP();                                      // Set mailer to use SMTP
                $mailer->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                $mailer->SMTPAuth = true;                               // Enable SMTP authentication
                $mailer->Username = 'username@gmail.com';            // SMTP username
                $mailer->Password = 'password';                     // SMTP password
                $mailer->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mailer->Port = 587;                                    // TCP port to connect to
        
                //Recipients
                $mailer->setFrom('username@gmail.com', 'DNSecury');
                $mailer->addAddress($this->mail);                       // Add a recipient

                //Content
                $mailer->isHTML(true);                                  // Set email format to HTML
                $mailer->Subject = utf8_decode("Alert DNSecury");
                $mailer->Body    = utf8_decode("
                        <div>
                            <h3>".$this->name."</h3>
                            <p>
                                Segue abaixo sua nova chave de acesso:
                                <h4>".$this->logOff."</h4>
                            </p>
                        </div>
                        <div>
                            <h3>Aviso muito importante</h1>
                            <p>
                                ainda não tem aviso mas não compartilhe esse email.
                            </p>
                        </div>
                ");        
                $mailer->send();                

            } catch (Exception $e) { 
                echo "<pre>";
                print_r($e); 
                echo "</pre>";              
                //Alguma lógica que armazene o erro para posterior analise por parte do programador.
            }
        }
            
    }

    

?>