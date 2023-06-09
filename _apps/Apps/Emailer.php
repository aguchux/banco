<?php

namespace Apps;

class Emailer
{

	public $toEmail = NULL;
	public $toName = NULL;

	public $fromEmail = fromEmail;
	public $fromName = fromName;
	public $replyEmail = replyEmail;
	public $replyName = replyName;
	public $subject = subject;

	private $variables = array();

	var $recipients = array();
	var $EmailTemplate;
	var $EmailContents;

	public $hasattachment = false;
	public $attachment = NULL;
	public $attachmentname = '';

	public function __construct($to = false)
	{
		if ($to !== false) {
			if (is_array($to)) {
				foreach ($to as $_to) {
					$this->recipients[$_to] = $_to;
				}
			} else {
				$this->recipients[$to] = $to;
			}
		}
	}

	public function __set($key, $val)
	{
		$this->variables[$key] = $val;
	}

	function SetTemplate(EmailTemplate $EmailTemplate)
	{
		$this->EmailTemplate = $EmailTemplate;
	}

	function SetAttachment($attachment,$attachmentname)
	{
		$this->hasattachment = true;
		$this->attachment = $attachment;
		$this->attachmentname = $attachmentname;
	}

	function send()
	{
		$html = $this->EmailTemplate->compile();
		try {

			$PHPmailer = new PHPMailer(true);
			$PHPmailer->CharSet = "UTF-8";
			$PHPmailer->AddAddress($this->toEmail, $this->toName);
			$PHPmailer->setFrom($this->fromEmail, $this->fromName);
			$PHPmailer->AddReplyTo($this->replyEmail, $this->replyName);
			if($this->hasattachment){
				$PHPmailer->AddAttachment($this->attachment,$this->attachmentname);
			}
			$PHPmailer->Subject = $this->subject;
			$PHPmailer->Body = $html;
			
			if(PHPMAILER_IS_HTML){
				$PHPmailer->isHTML(true);
				$PHPmailer->MsgHTML($html);	
				$PHPmailer->Encoding = "base64";
			}

			return $PHPmailer->Send();
		} catch (\Exception $e) {
			$PHPmailer->ClearAllRecipients();
			return 0;
		}
	}
}
