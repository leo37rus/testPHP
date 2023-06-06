<?php
$link = htmlspecialchars($_POST['link'] ?? '');
if(empty($_POST['submit'])){}
if(empty($_POST['link'])){}
else
{
    @$select = (new PDO("mysql:host=127.0.0.1;port=3306;dbname=short", "root"))->query("SELECT * FROM `short` WHERE `url` = '".$link."'")->fetchAll()[0] ??[];
    if($select)
    {
        $result = 
        [
            'url'  => $select['url'],
            'key'  => $select['short_key'],
            'link' => 'http://'.$_SERVER['HTTP_HOST'].'/-'.$select['short_key']
        ];
        print_r($result);
    }
    else
    {        
        $letters='qwertyuiopasdfghjklzxcvbnm1234567890';
        $count=strlen($letters);
        $intval=time();
        $result='';
        for($i=0;$i<4;$i++) 
        {
            $last=$intval%$count;
            $intval=($intval-$last)/$count;
            $result.=$letters[$last];
        }
        
        (new PDO("mysql:host=127.0.0.1;port=3306;dbname=short", "root"))->query("INSERT INTO `short` (`id`, `url`, `short_key`) VALUES (NULL, '".$link."', '".$result.$intval."') ");
        @$select = (new PDO("mysql:host=127.0.0.1;port=3306;dbname=short", "root"))->query("SELECT * FROM `short` WHERE `url` = '".$link."'")->fetchAll()[0] ??[];
        $result = 
        [
            'url'  => $select['url'],
            'key'  => $select['short_key'],
            'link' => 'http://'.$_SERVER['HTTP_HOST'].'/q/'.$select['short_key']
        ];
        print_r($result);
    }
}
?>
<form method="post" action="">
    <input type="text" name="link">
    <input type="submit" name="submit">
</form>