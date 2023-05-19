<?php if (!defined('ABSPATH')) {
    exit;
}
$COOKNAME = 'wellerpcb_view'; //cookie名称
$TIME = 60 * 60 * 12;
$PATH = '/';

$id = $posts[0]->ID;
$expire = time() + $TIME; //cookie有效期
if (isset($_COOKIE[$COOKNAME]))
    $cookie = $_COOKIE[$COOKNAME]; //获取cookie
else
    $cookie = '';

if (empty($cookie)) {
    //如果没有cookie
    setcookie($COOKNAME, $id, $expire, $PATH);
} else {
    //用a分割成数组
    $list = explode('a', $cookie);
    //如果已经存在本文的id
    if (!in_array($id, $list)) {
        setcookie($COOKNAME, $cookie . 'a' . $id, $expire, $PATH);
    }
}
process_postviews();
?>
<!--独立页面模板-->

<?php my_header() ?>

<?php my_content() ?>

<?php my_footer() ?>