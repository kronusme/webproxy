<?php

require_once('config.php');

$_GET['url'] = url::decode((string)$_GET['url']);

$url = new url($_GET['url']);
$pf = new page_factory();
if ($_POST) {
    $url = $pf->post_page($url);
    if ($_POST) {
        $page = $pf->get_page($url, $_POST);
    }
    else {
        header('Location: view.php?url='.url::encode($url->assembly()));
        die();
    }
}
else {
    $page = $pf->get_page($url);
}
$modified_content = $page->process();

header($page->get_content_type());
echo $modified_content;