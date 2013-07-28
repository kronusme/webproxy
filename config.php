<?php

error_reporting(0);

require_once('vendor/autoload.php');

require_once('src/class.url.php');
require_once('src/class.page_factory.php');
require_once('src/class.page.php');
require_once('src/class.basic_page.php');
require_once('src/class.css_page.php');
require_once('src/class.html_page.php');
require_once('src/class.request.php');
require_once('src/simple_html_dom.php');
require_once('src/sessions.php');

webproxy_session_start();