
<?php
$url_page = 'example/page/url.php';
//page the link will request
$text = 'this is a simple string';    
$id = '4334%3434';        
$linktext = "<Clickit> & you will see it";
//text of the link, with HTML unfriendly characters
?>
<?php
// this gives you a clean link to use
$url = "http://localhost/";
$url .= rawurlencode($url_page);
$url .= "?text=" . urlencode($text);
$url .= "&id=" . urlencode($id);
echo htmlspecialchars($url);
// htmlspecialchars escapes any html that 
// might do bad things to your html page
?>
<a href="<?php echo htmlspecialchars($url); ?>">
<?php echo htmlspecialchars($linktext) .'<br><br>'; ?>
</a>
