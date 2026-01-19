<?php

namespace model;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
  private $MailObject;
  public function __construct()
  {
    $this->MailObject = new PHPMailer();
    $this->MailObject->isSMTP();
    $this->MailObject->Host       = 'smtp.gmail.com';                     // Configura el servidor SMTP para enviar
    $this->MailObject->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
    $this->MailObject->Username   = getenv("STMP_MAIL");               // Usuario SMTP
    $this->MailObject->Password   = getenv("STMP_PASS");                        // Contraseña SMTP
    $this->MailObject->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;; // Habilitar encriptación TLS
    $this->MailObject->Port       = 465;
    $this->MailObject->setFrom(getenv("STMP_MAIL"), "Instituto Venezolano de Lenguas");
  }
  /**
   * @param $message array
   *    adress:mail = correo al que enviar el correo
   *    suject:string = asunto del correo
   *    body:string | HTML = contenido del correo 
   */
  public function sendMail($message): void
  {
    try {
      $mailContainer = clone $this->MailObject;
      $mailContainer->isHTML(true);
      $mailContainer->addAddress($message['adress']);
      $mailContainer->Subject = $message['suject'];
      $mailContainer->Body = $message['body'];
      $mailContainer->AltBody = $message['altBody'];
      if(isset($message['filePath']) && isset($message['fileName']) ){
        $mailContainer->addAttachment($message['filePath'], $message['fileName'].".pdf");
      }
      if (!$mailContainer->send()) {
        throw new \Exception('El mensaje no pudo ser enviado.');
      }
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    } finally {
      unset($mailContainer);
    }
  }
}
