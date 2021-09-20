<?php
$ini_array = parse_ini_file(__DIR__ . "/../config/commonVariables.ini");

$db_var_host = $ini_array['host'];
$db_var_db_name = $ini_array['db_name'];
$db_var_username = $ini_array['username'];
$db_var_password = $ini_array['password'];

$smtp_var_host = $ini_array['smtpHost'];
$smtp_var_username = $ini_array['smtpUserName'];
$smtp_var_password = $ini_array['smtpPasswordEmail'];


$email_from_address = $ini_array['EmailAddress'];
$email_reply_address = $ini_array['EmailReplyAddress'];
$email_from_alias = $ini_array['EmailAlias'];
