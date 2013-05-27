<?php


class pagesTest extends PHPUnit_Framework_TestCase {

    private $_tests_html = array(
        array('http://kronus.me/', 'utf-8'),
        array('http://www.qq.com/', 'gb2312')
    );

    private $_tests_css = array(
        array('http://blog.dota2.com/wp-content/themes/dota2/style.css'),
        array('http://static.php.net/www.php.net/styles/phpnet.css')
    );

    private $_tests_basic = array(
        array('http://static.php.net/www.php.net/images/php.gif'),
        array('http://mail.google.com/favicon.ico')
    );

    public function testGetHtmlPage() {
        foreach($this->_tests_html as $test) {
            $pf = new page_factory();
            $page = $pf->get_page(new url($test[0]));
            $this->assertEquals(strtolower($page->get_charset()), $test[1]);
            $this->assertEquals($page->get_url()->raw(), $test[0]);
            $dom = str_get_html($page->process(), true, true, $page->get_charset(), false);
            $this->assertEquals(count($dom->find('iframe')), 0);
            $this->assertEquals(count($dom->find('embed')), 0);
            $this->assertEquals(count($dom->find('applet')), 0);
        }
    }

    public function testGetCssFile() {
        foreach($this->_tests_css as $test) {
            $pf = new page_factory();
            $page = $pf->get_page(new url($test[0]));
            $content = $page->process();
            $this->assertEquals(strpos($content, 'url(http://'), false);
            $this->assertEquals(strpos($content, 'url(\'http://'), false);
            $this->assertEquals(strpos($content, 'url("http://'), false);
        }
    }

    public function testGetBasicPage() {
        foreach($this->_tests_basic as $test) {
            $pf = new page_factory();
            $page = $pf->get_page(new url($test[0]));
            $content = $page->process();
            $this->assertEquals($content, file_get_contents($test[0]));
        }
    }
}