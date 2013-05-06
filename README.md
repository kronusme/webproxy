# WebProxy

### About

1. **What is it?**
Simple Web Proxy script for private use.

2. **Why I should use it?**
You should use it when some urls are not available for you for some reasons (blocked by your provider etc). And sites like hidemyass.com or zend2.com are not available to.

3. **What I need to use it?**
You just need to have a php hosting.

### Install

1. Clone project.
2. Run [composer](http://getcomposer.org/) to install components.
3. Upload code to url site.
4. Go to http://yousite.com/path/to/proxy/
5. Enter url you want to navigate.
6. Profit.

### Supported features

1. GET requests only (for now).
2. URL encoding (to prevent blocking by words in the url).
3. Remove script, embed, applet, iframe tags from page.
4. Change a, img, link "src"/"href" attr to use our proxy.
5. For all html-elements with "style"/"background" attributes used replacing for link-values.
6. Same with css-files where some properties (like background) use links.
7. "Real" link is always shown on the page, so you can easy share it.

### Not supported featues and some issues

1. Only GET requests.
2. Not supported forms actions even if "get" method is used.