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

    class Contato extends Model {

       
        private $name;
        private $mail;
        private $message;
        private $subject;
        private $tel;
        private $city;
        private $data_system; //date('d/m/Y H:i');
        private $resposta;

        private $estado;
        private $ip;
        private $zip;
        private $country;
        private $provedor;

        public function __get($attr)
        {
            return $this->$attr;
        }

        public function __set($attr, $value)
        {
            $this->$attr = $value;
        }

        public function registercontact()
        {
            $query = "insert into tb_contacts(
                name, mail, tel, subject, message, city, data_system, estado, ip, zip, country, provedor
            )values(
                :name, :mail, :tel, :subject, :message, :city, :data_system, :estado, :ip, :zip, :country, :provedor
            )";

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name', utf8_decode($this->__get('name')));
            $stmt->bindValue(':mail', utf8_decode($this->__get('mail')));
            $stmt->bindValue(':tel', utf8_decode($this->__get('tel')));
            $stmt->bindValue(':subject', utf8_decode($this->__get('subject')));
            $stmt->bindValue(':message', utf8_decode($this->__get('message')));
            $stmt->bindValue(':city', utf8_decode($this->__get('city')));
            $stmt->bindValue(':data_system', utf8_decode($this->__get('data_system')));
            $stmt->bindValue(':estado', utf8_decode($this->__get('estado')));
            $stmt->bindValue(':ip', utf8_decode($this->__get('ip')));
            $stmt->bindValue(':zip', utf8_decode($this->__get('zip')));
            $stmt->bindValue(':country', utf8_decode($this->__get('country')));
            $stmt->bindValue(':provedor', utf8_decode($this->__get('provedor')));
            
            $stmt->execute();
            return true;

        }
        
        public function confirmaEnvio(){ 

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 2;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'username@gmail.com';                     // SMTP username
                $mail->Password   = 'senha-email';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('username@gmail.com', 'DNSecury');
                $mail->addAddress($this->mail, $this->name);     // Add a recipient
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = utf8_decode($this->subject);
                $mail->Body    = utf8_encode($this->resposta);
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

?>