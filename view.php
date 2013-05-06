<?php

require_once('config.php');

$_GET['url'] = url::decode((string)$_GET['url']);

$url = new url($_GET['url']);
ChromePhp::log($url);
$pf = new page_factory();
$page = $pf->get_page($url);
$modified_content = $page->process();

header($page->get_content_type());
echo $modified_content;