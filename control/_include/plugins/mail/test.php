<?php

require_once 'swift_required.php';

//$transport = Swift_SmtpTransport::newInstance();
$transport = Swift_SmtpTransport::newInstance('Morpheus', 25)
  ->setUsername('bizhub@t-and-g.com')
  ->setPassword('devaju12')
  ;
$mailer = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('bizhub@t-and-g.com' => 'John Doe'))
  ->setTo(array('luis@visible.pe' => 'A name'))
  ->setBody('Here is the message itself');
$numSent = $mailer->batchSend($message);
printf("Sent %d messages\n", $numSent);
if (!$mailer->send($message, $failures))
{
  echo "Failures:";
  print_r($failures);
}

?>
<br /><br />
<code>
$transport = Swift_SmtpTransport::newInstance('Morpheus', 25)
  ->setUsername('bizhub@t-and-g.com')
  ->setPassword('devaju12')
  ;
$mailer = Swift_Mailer::newInstance($transport);
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('bizhub@t-and-g.com' => 'John Doe'))
  ->setTo(array('luis@visible.pe' => 'A name'))
  ->setBody('Here is the message itself');
</code>