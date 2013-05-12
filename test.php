<?php

require_once('config.php');

class allInOneTest extends PHPUnit_Framework_TestCase {

    private $_url_tests = array(
        array('kronus.me', 'http', 'scheme', 3),
        array('http://kronus.me', 'http', 'scheme', 3),
        array('kronus.me/2012/1/', '/2012/1/', 'path', 3),
        array('http://kronus.me/2012/1/', '/2012/1/', 'path', 3),
        array('kronus.me/2012/1/1.php', '1.php', 'file', 4),
        array('kronus.me:80/', '80', 'port', 3),
        array('kronus.me:80?q1=1&q2=2', 'q1=1&q2=2', 'query', 5),
        array('kronus.me:80/?q1=1&q2=2', 'q1=1&q2=2', 'query', 4),
        array('kronus.me:80/?#qqq', 'qqq', 'fragment', 4),
        array('http://kronus.me/category/cms/page/2/', '/category/cms/page/2/', 'path', 3)
    );

    public function testUrlParser() {
        foreach($this->_url_tests as $test) {
            $url = new url($test[0]);
            $this->assertEquals($test[1], $url->get($test[2]));
        }
    }

    public function testUrlRaw() {
        foreach($this->_url_tests as $test) {
            $url = new url($test[0]);
            $this->assertEquals($test[0], $url->raw());
        }
    }
    public function testUrlEncodeDecode() {
        foreach($this->_url_tests as $test) {
            $this->assertEquals($test[0], url::decode(url::encode($test[0])));
        }
    }
    public function testUrlComponentsCount() {
        foreach($this->_url_tests as $test) {
            $url = new url($test[0]);
            $this->assertEquals($test[3], count($url->get_all_components()));
        }
    }
}