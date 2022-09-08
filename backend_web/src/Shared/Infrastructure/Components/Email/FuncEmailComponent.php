<?php
namespace App\Shared\Infrastructure\Components\Email;

final class FuncEmailComponent extends AbsEmail
{
    private string $titlefrom = "";
    private string $boundary = "";

    private function _boundary()
    {
        if($this->attachments)
            $this->boundary = md5(uniqid());
        return $this;
    }

    private function _header_mime()
    {
        $headers = [
            "MIME-Version: 1.0",
            "Content-Type: text/html; charset=\"UTF-8\"",
            "Content-Transfer-Encoding: 8bit",
        ];

        if($this->boundary)
        {
            $headers = [
                "MIME-Version: 1.0",
                "Content-Type: multipart/mixed; boundary=\"$this->boundary\"",
                "Content-Transfer-Encoding: 7bit",
                "This is a MIME encoded message."
            ];
        }
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    private function _header_from()
    {
        $this->headers[] = "From: $this->titlefrom <$this->email_from>";
        $this->headers[] = "Return-Path: <$this->email_from>";
        $this->headers[] = "X-Sender: $this->email_from";
        return $this;
    }

    private function _header_cc()
    {
        if($this->emails_cc)
            $this->headers[] = "cc: ".implode(", ",$this->emails_cc);
        return $this;
    }

    private function _header_bcc()
    {
        if($this->emails_bcc)
            $this->headers[] = "bcc: ".implode(", ",$this->emails_bcc);
        return $this;
    }

    private function _header()
    {
        $header = implode(PHP_EOL, $this->headers);
        return $header;
    }

    private function _get_multipart()
    {
        if(!$this->boundary) return "";
        $content[] = "--$this->boundary";
        $content[] = "Content-Type: text/html; charset=UTF-8";
        $content[] = "Content-Transfer-Encoding: 8bit";
        return implode(PHP_EOL, $content);
    }

    private function _get_attachment(array $arattach)
    {
        //https://stackoverflow.com/questions/12301358/send-attachments-with-php-mail
        $pathfile = $arattach["path"];
        if(!is_file($pathfile)) return "";

        $mime = $arattach["mime"] ?? "application/octet-stream";
        $alias = $arattach["filename"] ?? basename($pathfile);

        $content = file_get_contents($pathfile);
        if(!$content) return "";

        $content = chunk_split(base64_encode($content));
        $separator = $this->boundary;

        $body[] = "";
        $body[] = "--$separator";
        $body[] = "Content-Type: $mime; name=\"$alias\"";
        $body[] = "Content-Transfer-Encoding: base64";
        $body[] = "Content-Disposition: attachment; ";
        $body[] = $content;
        $body[] = "--$separator--";
        $body[] = "";

        return implode(PHP_EOL, $body);
    }

    public function send()
    {
        try
        {
            if($this->email_from && $this->emails_to) {
                $header = $this->_boundary()
                    ->_header_from()
                    ->_header_mime()
                    ->_header_cc()
                    ->_header_bcc()
                    ->_header()
                ;

                $content = $this->_get_multipart().PHP_EOL;
                $content .= $this->content.PHP_EOL;

                foreach ($this->attachments as $arattach)
                    $content .= $this->_get_attachment($arattach);

                $this->logpr($this->emails_to,"TO ->");
                $this->logpr($this->headers, "HEADER ->");
                $this->logpr($content,"BODY ->");

                $this->emails_to = implode(", ",$this->emails_to);
                $r = mail($this->emails_to, $this->subject, $content, $header);
                if(!$r) {
                    $this->_add_error("Error sending email!");
                    $this->_add_error(error_get_last());
                }
            }
            else {
                $this->_add_error("No target emails!");
            }
        }
        catch (\Exception $e) {
            $this->_add_error($e->getMessage());
        }
        finally {
            return $this;
        }
    }

    public function set_title_from(string $title){$this->titlefrom = $title; return $this;}

    private function logpr(){}

}