<html>
    <meta charset="utf-8">
    <head>
        <title>Wind Chimes</title>
        <link rel="stylesheet" href="style/base.css" type="text/css" />
    </head>
    <body>
        <div class="topbar">
            <div class="topbar_box">
                <img src="style/logo.png"/>
                <div class="title"><a href="" style="color:#efefef"> 风铃 / Wind Chimes</a></div>
                <div class="guide_box">
                    <a href="" ><div>主页</div></a>
                    <a href="add.html" target="_blank" ><div>添加</div></a>
                    <a href="about.html"><div>关于</div></a>
                </div>
            </div>
        </div>
        <div class="body_box">
            <!--广告框-->
            <div class="box ad_box">
                <div style="font-size:30px;line-height:300px;width: 100%;height: 100%;text-align: center">不知道这里搞点什么好</div>
            </div>
            <!--左栏-->
            <div class="left_box">
                <div class="box about_box">
                    <div class="avatar">
                        <img src='style/avatar.jpg'/>
                    </div>
                    <div class="info">
                        风铃(Wind Chimes)是一个由<a href="http://nightship.cn/" target="_blank">TOYOHAY</a>开发的统计微博与B站粉丝数据的项目。
                    </div>
                </div>
            </div>
            <!--右栏-->
            <div class="right_box">
                <div class="data_box box">
                    <?php 
                        $infofile = file_get_contents("info/info.json");
                        $info = json_decode($infofile,true);
                        $datafile = file_get_contents("info/data.json");
                        $fansdata = json_decode($datafile,true);

                        foreach($info as $uid=>$data){
                            echo '<div class="user_box"><div class="avatar"><img src="avatar/'.$uid.'.jpg"/></div>';
                            echo '<div class="info_box"><div class="name"><a href="data.php?uid='.$uid.'" style="color:black">'.$data["name"].'</a></div><div class="info">'.$data["info"].'</div></div>';
                            echo '<div class="data"><table><tr><td></td><td>粉丝数</td><td>互动/视频指数</td><td>有效互动指数</td></tr>';
                            echo '<tr><td><img src="style/weibo.png"/></td><td>'.$fansdata[$uid]["weiboFans"].'</td><td>'.$fansdata[$uid]["weiboIndex"].'</td><td>'.$fansdata[$uid]["weiboIndex2"].'</td></tr>';
                            echo '<tr><td><img src="style/bili.png"/></td><td>'.$fansdata[$uid]["biliFans"].'</td><td>'.$fansdata[$uid]["biliIndex"].'</td><td>'.$fansdata[$uid]["biliIndex2"].'</td></tr></table></div></div>';
                        }
                    ?>
                </div>
            </div>
            <div class="bottom">
                <hr/>
                <a href='https://github.com/lilidream/Wind_Chimes' target='_blank'>风铃 Wind Chimes</a> | Written By TOYOHAY
            </div>
        </div>
    </body>
</html>