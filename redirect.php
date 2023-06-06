<?php
$key = htmlspecialchars($_GET['key']);
if(empty($_GET['key'])){}
else
{
    @$select =
    (new PDO("mysql:host=127.0.0.1;port=3306;dbname=short", "root"))->query("SELECT * FROM `short` WHERE `short_key` = '".$key."'")->fetchAll()[0] ??[];
    if($select)
    {
        $result = 
        [
            'url' => $select['url'],
            'key' => $select['short_key']
        ];
        
        header('location: '.$result['url']);
        
    }
}
?>