<?php
/*
名称:USpider(污~蜘蛛)
版本:1.0
最后更新时间:2018/02/10 23:55
作者:狂放
作者博客:https://www.iknet.top
作者地址:https://www.iknet.top/829.html
开源协议:GPL v3
GitHub项目地址:https://github.com/kfangf/USpider
码云项目地址:https://gitee.com/kfang/USpider
版权归作者所有，任何人不得未经授权修改版权，二次开发请遵守开源协议
版权所有，侵权必究
*/ 
header('X-Powered-By:USpider (https://www.iknet.top)');
header('Content-Type: text/html; charset=UTF-8');
$proxy_data = file('../data/proxy.txt');
$ua_data = file('../data/ua.txt');
/*functions*/
function curl_get($url) {
	 global $proxy_data,$ua_data;
	 $proxy = $proxy_data[mt_rand(0,4)];
  	 $ua = $ua_data[mt_rand(0,99)];
     $ch=curl_init($url);
     curl_setopt ($ch, CURLOPT_PROXY,'http://'.$proxy );
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_USERAGENT, $ua);
     curl_setopt($ch, CURLOPT_TIMEOUT, 30);
     $content=curl_exec($ch);
     curl_close($ch);
     return($content);
}
//reg:<article id="post" class="post"> <p>([\s\S]+?)</p> </article>
for($n =1 ; $n <=10 ; $n++){
   $html = curl_get('https://www.nihaowua.com/');
   $preg = preg_match('/<article id="post" class="post"> <p>([\s\S]+?)<\/p> <\/article>/', $html,$array);  
   if ( $preg == 1 ) {
     $content = $array[1];
     echo $content."\r\n";
     $data = file_get_contents('../data/u.txt');
     if(strpos($data,$content) == false){
	    $handle = fopen("../data/u.txt", "a") or die("Unable to open file!");
         fwrite($handle, $content."\n");
         fclose($handle);
    }else{
        echo "第".$n."次抓取失败\n";
    }
  }
}
?>
