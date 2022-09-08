<?php
namespace App\Shared\Infrastructure\Components\Email;

abstract class AbsEmail implements IEmail
{
    protected $headers = [];
    protected $email_from = [];
    protected $emails_to = [];
    protected $emails_cc = [];
    protected $emails_bcc = [];
    protected $attachments = [];

    protected $subject = "";
    protected $content = "";

    protected $errors = [];
    protected $iserror = false;

    protected function _add_error($msg)
    {
        $this->iserror = true;
        $this->errors[] = $msg;
        return $this;
    }

    public function set_subject($subject){$this->subject = $subject; return $this;}

    public function set_from($stremail){$this->email_from = $stremail; return $this;}

    public function add_to($stremail){$this->emails_to[]=$stremail; return $this;}
    public function add_cc($stremail){$this->emails_cc[]=$stremail; return $this;}
    public function add_bcc($stremail){$this->emails_bcc[]=$stremail; return $this;}
    public function set_content($mxcontent){(is_array($mxcontent))? $this->content=implode(PHP_EOL,$mxcontent): $this->content = $mxcontent; return $this;}
    public function add_attachment($arattach=["path"=>"","mime"=>"","filename"=>""]){$this->attachments[] = $arattach; return $this;}

    public function get_errors(){return $this->errors;}
}
