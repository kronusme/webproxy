<?php

require_once('config.php');
if (isset($_POST['url'])) {
    $_POST['url'] = (string)$_POST['url'];
    header('Location:view.php?url='.url::encode($_POST['url']));
    die();
}
?>

<head>
    <title>WebProxy</title>
</head>
<body>
    <form method="post" action="?">
        <fieldset>
            <label for="url">Url:</label> <input type="text" id="url" name="url" value="" placeholder="http://kronus.me" />
            <input type="submit" name="submit" value="Submit" />
        </fieldset>
    </form>
</body>