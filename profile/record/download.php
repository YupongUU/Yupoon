<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>变音小能手</title>
  <meta name="viewport" content="width=device-width">
</head>

<?php

    //获取media_id
    $MEDIA_ID = $_GET['media_id'];
    //echo $MEDIA_ID;
    
    //获取access_token
    $res = get_php_file("access_token.php",true);
    $result = json_decode($res, true);
    $ACCESS_TOKEN = $result['access_token'];
    //echo $ACCESS_TOKEN;
    
    //音频地址
    $url_audio = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$ACCESS_TOKEN."&media_id=".$MEDIA_ID;
    //获取音频内容并保存
    $audio = getfile($url_audio);
    $filename = "weixin_".time().".amr";
    saveFile($filename, $audio);

    

    //curl 获取文件数据  
    function getfile($url){  
        $ch = curl_init($url);  
        curl_setopt($ch, CURLOPT_HEADER, 0);  
        curl_setopt($ch, CURLOPT_NOBODY, 0);//只取body头  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//curl_exec执行成功后返回执行的结果；不设置的话，curl_exec执行成功则返回true  
        $output = curl_exec($ch);  
        curl_close($ch);  
        return $output;  
    }  
  
    //保存文件到本地  
    function saveFile($filename, $filecontent){  
        $local_file = fopen($filename, 'w');  
        if (false !== $local_file){//不恒等于（恒等于=== 就是false只能等于false，而不等于0）  
        if (false !== fwrite($local_file, $filecontent)) {  
            fclose($local_file);  
            }  
        }  
    }  


    //打开本地php文件
    function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
  }

?>
<body>
  <button id="start">点击播放</button>
</body>