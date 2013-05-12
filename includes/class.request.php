<?php
/**
 * Class represents basic functionality for sending request to server and receive response
 *
 * @author kronus
 */
class request {
    /**
     * @var string
     */
    private $_url;

    /**
     * Get url
     * @return string
     */
    public function get_url() {
        return $this->_url;
    }

    /**
     * Set url
     * @param string $url
     * @return request
     */
    public function set_url($url) {
        $this->_url = (string)$url;
        return $this;
    }

    /**
     * @param string $url
     */
    public function __construct($url) {
        $this->_url = $url;
    }

    /**
     * Send request to servers
     * @access public
     * @return mixed
     */
    public function send() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        //curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Ignore SSL warnings and questions
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $buffer = curl_exec($ch);
        $d = explode("\r\n\r\n", $buffer, 2);
        curl_close($ch);
        return $d;
    }
}
