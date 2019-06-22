<?php
    $pw = $_POST["pw"];
    $name = $_POST["name"];
    $weiboUid = $_POST["weiboUid"];
    $biliUid = $_POST["biliUid"];
    $infoo = $_POST["info"];
    $avatar = $_POST["avatar"];

    $password = "123";//此为管理员密码，请更改

    if($pw == $password){
        $infofile = file_get_contents("info/info.json");
        $info = json_decode($infofile,true);
        $len = count($info)+1;
        $info[(string)$len] = ["name"=>$name,"weiboUid"=>$weiboUid,"biliUid"=>$biliUid,"info"=>$infoo];

        $image_name = "avatar/".(string)$len.".jpg";
        $img = file_get_contents($avatar);
        $fp = fopen($image_name,'w');
        fwrite($fp, $img);
        fclose($fp);

        $json = json_encode($info,JSON_UNESCAPED_UNICODE);
        $file = fopen("info/info.json",'w+');
        fwrite($file,$json);
        fclose($file);

        $file = fopen("data/".$len.".json",'w+');
        fwrite($file,"{}");
        fclose($file);

        echo "OK!";
    }
    else{
        echo "Password Error!";
    }
?>