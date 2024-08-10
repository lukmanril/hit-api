<?php
define('SECRETKEY', 'SECRETKEY_HERE');

define('BASEURL_', '127.0.0.1');
define('BASEURL', 'http://'.BASEURL_.'/hit-api/public');

//DB
define('DB_DRIVER', 'mysql');
define('DB_HOST', BASEURL_);
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dbApi');

//EMAIL
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'EMAIL_HERE');
define('SMTP_PASSWORD', 'PASSWORD_HERE');