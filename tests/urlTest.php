<?php


class urlTest extends PHPUnit_Framework_TestCase {

    private $_url_tests = array(
        array('kronus.me', 'http', 'scheme', 3, 'http://kronus.me/'),
        array('http://kronus.me', 'http', 'scheme', 3, 'http://kronus.me/'),
        array('kronus.me/2012/1/', '/2012/1/', 'path', 3, 'http://kronus.me/2012/1/'),
        array('http://kronus.me/2012/1/', '/2012/1/', 'path', 3, 'http://kronus.me/2012/1/'),
        array('kronus.me/2012/1/1.php', '1.php', 'file', 4, 'http://kronus.me/2012/1/1.php'),
        array('kronus.me:80/', '80', 'port', 3, 'http://kronus.me:80/'),
        array('kronus.me:80?q1=1&q2=2', 'q1=1&q2=2', 'query', 5, 'http://kronus.me:80/?q1=1&q2=2'),
        array('kronus.me:80/?q1=1&q2=2', 'q1=1&q2=2', 'query', 4, 'http://kronus.me:80/?q1=1&q2=2'),
        array('kronus.me:80/?#qqq', 'qqq', 'fragment', 4, 'http://kronus.me:80/#qqq'),
        array('http://kronus.me/category/cms/page/2/', '/category/cms/page/2/', 'path', 3, 'http://kronus.me/category/cms/page/2/'),
        array('kronus.me:80/index.php', '80', 'port', 4, 'http://kronus.me:80/index.php')
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

    public function testAssemblyUrl() {
        foreach($this->_url_tests as $test) {
            $url = new url($test[0]);
            $this->assertEquals($test[4], $url->assembly());
        }
    }

    public function testSet() {
        foreach($this->_url_tests as $test) {
            $url = new url($test[0]);
            $url->set('user', 'user');
            $url->set('pass', 'pass');
            $this->assertEquals(str_replace('http://', 'http://user:pass@', $test[4]), $url->assembly());
        }
    }
}