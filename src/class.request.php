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
     * @var array
     */
    private $_post;

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
     * Get post-data
     * @return array
     */
    public function get_post() {
        return $this->_post;
    }

    /**
     * Set post data
     * @param array $post
     * @return array
     */
    public function set_post(array $post) {
        $this->_post = $post;
        return $post;
    }

    /**
     * @param string $url
     * @param array $post
     */
    public function __construct($url, array $post = null) {
        $this->_url = $url;
        $this->_post = $post;
    }

    /**
     * Send request to servers
     * @access public
     * @return mixed
     */
    public function send() {
        $ch = curl_init();
        if (is_array($this->_post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->get_post()));
        }
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
