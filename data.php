<?php
    $uid = $_GET["uid"];
    if($uid==""){$uid="1";}
    $infofile = file_get_contents("info/info.json");
    $info = json_decode($infofile,true);
    $datafile = file_get_contents("info/data.json");
    $fansdata = json_decode($datafile,true);
?>
<html>
    <meta charset="utf-8">
    <head>
        <title><?php echo $info[$uid]["name"] ?>-风铃</title>
        <link rel="stylesheet" href="style/base.css" type="text/css" />
    </head>
    <script type="text/javascript" src="js/echarts.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <body>
        <div class="topbar">
            <div class="topbar_box">
                <img src="style/logo.png"/>
                <div class="title"><a href="index.php" style="color:#efefef">风铃 | Wind Chimes</a></div>
                <div class="guide_box">
                    <a href="index.php" ><div>主页</div></a>
                    <a href="add.html" target="_blank" ><div>添加</div></a>
                    <a href="about.html"><div>关于</div></a>
                </div>
            </div>
        </div>
        <div class="body_box">
            <div class="data_user_box">
                <div class="data_avatar">
                    <img src='avatar/<?php echo $uid ?>.jpg' />
                </div>
                <div class="data_info box">
                    <div class="data_info_box">
                        <div class="data_name"><?php echo $info[$uid]["name"] ?></div>
                        <div class="data_briinfo"><?php echo $info[$uid]["info"] ?></div>
                    </div>
                    <div class="data_infodata">
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["weiboFans"] ?></div>
                            <div class="ddb_title">微博粉丝</div>
                        </div>
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["weiboIndex"] ?></div>
                            <div class="ddb_title">微博互动指数</div>
                        </div>
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["weiboIndex2"] ?></div>
                            <div class="ddb_title">微博有效互动指数</div>
                        </div>
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["biliFans"] ?></div>
                            <div class="ddb_title">哔哩哔哩粉丝</div>
                        </div>
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["biliIndex"] ?></div>
                            <div class="ddb_title">哔哩视频指数</div>
                        </div>
                        <div class="data_databox1">
                            <div class="ddb_data"><?php echo $fansdata[$uid]["biliIndex2"] ?></div>
                            <div class="ddb_title">哔哩视频有效指数</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="big_chart box" id="c0">
            </div>
            <div class="ddata">
                <div class="left_sina">
                    <div class="chart box" id="c1"></div>
                    <div class="chart box" id="c2"></div>
                    <div class="chart box" id="c3"></div>
                    <div class="chart box" id="c4"></div>
                </div>
                <div class="right_bili">
                    <div class="chart box" id="c5"></div>
                    <div class="chart box" id="c6"></div>
                    <div class="chart box" id="c7"></div>
                    <div class="chart box" id="c8"></div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <hr/>
            <a href='https://github.com/lilidream/Wind_Chimes' target='_blank'>风铃 Wind Chimes</a> | Written By TOYOHAY
        </div>
        <script type="text/javascript">
            var user_name = "<?php echo $info[$uid]["name"] ?>";
            $.getJSON("data/<?php echo $uid ?>.json","",function(data){
                thedata = data;
                weiboFans = new Array();
                weiboFansAno = new Array();
                weiboRepo = new Array();
                weiboComm = new Array();
                weiboLike = new Array();
                weiboIndex = new Array();
                weiboIndex2 = new Array();
                weiboIndexAno = new Array();
                weiboIndex2Ano = new Array();
                biliFans = new Array();
                biliFansAno = new Array();
                biliPlay = new Array();
                biliFave = new Array();
                biliComm = new Array();
                biliIndex = new Array();
                biliIndex2 = new Array();
                biliIndexAno = new Array();
                biliIndex2Ano = new Array();
                len = Object.keys(thedata).length;
                for(i=1;i<=len;i++){
                    weiboFans.push([thedata[i]["time"],thedata[i]["weibo"][0]]);
                    weiboRepo.push([thedata[i]["time"],thedata[i]["weibo"][1]]);
                    weiboComm.push([thedata[i]["time"],thedata[i]["weibo"][2]]);
                    weiboLike.push([thedata[i]["time"],thedata[i]["weibo"][3]]);
                    weiboIndex.push([thedata[i]["time"],thedata[i]["weibo"][4]]);
                    weiboIndex2.push([thedata[i]["time"],thedata[i]["weibo"][5]]);
                    biliFans.push([thedata[i]["time"],thedata[i]["bili"][0]]);
                    biliPlay.push([thedata[i]["time"],thedata[i]["bili"][1]]);
                    biliFave.push([thedata[i]["time"],thedata[i]["bili"][2]]);
                    biliComm.push([thedata[i]["time"],thedata[i]["bili"][3]]);
                    biliIndex.push([thedata[i]["time"],thedata[i]["bili"][4]]);
                    biliIndex2.push([thedata[i]["time"],thedata[i]["bili"][5]]);
                }
                for(i=2;i<=len;i++){
                    weiboFansAno.push([thedata[i]["time"],thedata[i]["weibo"][0]-thedata[i-1]["weibo"][0]]);
                    biliFansAno.push([thedata[i]["time"],thedata[i]["bili"][0]-thedata[i-1]["bili"][0]]);
                    biliIndexAno.push([thedata[i]["time"],thedata[i]["bili"][4]-thedata[i-1]["bili"][4]]);
                    biliIndex2Ano.push([thedata[i]["time"],thedata[i]["bili"][5]-thedata[i-1]["bili"][5]]);
                    weiboIndexAno.push([thedata[i]["time"],thedata[i]["weibo"][4]-thedata[i-1]["weibo"][4]]);
                    weiboIndex2Ano.push([thedata[i]["time"],thedata[i]["weibo"][5]-thedata[i-1]["weibo"][5]]);
                }

                var IndexChart = echarts.init(document.getElementById('c0'));
                var option = {
                    title : {text : '微博、哔哩哔哩指数变化',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [
                        {
                            type : 'value',
                            min: function(value) {
                                return value.min - 20;
                            },
                            max: function(value) {
                                return value.max + 20;
                            }
                        }
                    ],
                    series : [
                        {name: '微博互动指数变化',type: 'line',data: weiboIndexAno,smooth:true},
                        {name: '微博有效互动指数变化',type: 'line',data: weiboIndex2Ano,smooth:true},
                        {name: '哔哩哔哩视频指数变化',type: 'line',data: biliIndexAno,smooth:true},
                        {name: '哔哩哔哩有效视频指数变化',type: 'line',data: biliIndex2Ano,smooth:true},
                    ],
                    grid:{left:'1%',right:'2%',bottom:'3%',containLabel:true}
                }
                IndexChart.setOption(option);

                var weiboFansChart = echarts.init(document.getElementById('c1'));
                var option = {
                    title : {text : '微博粉丝总数',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [
                        {
                            type : 'value',
                            min: function(value) {
                                return value.min - 20;
                            },
                            max: function(value) {
                                return value.max + 20;
                            }
                        }
                    ],
                    series : [{
                            name: '微博粉丝数',
                            type: 'line',
                            data: weiboFans,
                            smooth:true
                        }]
                }
                weiboFansChart.setOption(option);

                var weiboFansAnoChart = echarts.init(document.getElementById('c2'));
                var option = {
                    title : {text : '微博粉丝变化',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value'}],
                    series : [{
                            name: '微博粉丝数变化',
                            type: 'line',
                            data: weiboFansAno,
                            smooth:true
                        }]
                }
                weiboFansAnoChart.setOption(option);

                var weiboReactChart = echarts.init(document.getElementById('c3'));
                var option = {
                    title : {text : '前50条微博互动数',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value',min:'dataMin',max:'dataMax'}],
                    series : [
                        {name: '转发数',type: 'line',data: weiboRepo,smooth:true},
                        {name: '评论数',type: 'line',data: weiboComm,smooth:true},
                        {name: '点赞数',type: 'line',data: weiboLike,smooth:true},
                    ]
                }
                weiboReactChart.setOption(option);

                var weiboIndexChart = echarts.init(document.getElementById('c4'));
                var option = {
                    title : {text : '微博指数',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value',min:'dataMin',max:'dataMax'}],
                    series : [
                        {
                            name: '微博互动指数',
                            type: 'line',
                            data: weiboIndex,
                            smooth:true
                        },
                        {
                            name: '微博有效互动指数',
                            type: 'line',
                            data: weiboIndex2,
                            smooth:true
                        },
                    ]
                }
                weiboIndexChart.setOption(option);

                var weiboFansChart = echarts.init(document.getElementById('c5'));
                var option = {
                    title : {text : '哔哩哔哩粉丝总数',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [
                        {
                            type : 'value',
                            min: function(value) {
                                return value.min - 20;
                            },
                            max: function(value) {
                                return value.max + 20;
                            }
                        }
                    ],
                    series : [{
                            name: '哔哩哔哩粉丝数',
                            type: 'line',
                            data: biliFans,
                            smooth:true
                        }]
                }
                weiboFansChart.setOption(option);

                var weiboFansAnoChart = echarts.init(document.getElementById('c6'));
                var option = {
                    title : {text : '哔哩哔哩粉丝变化',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value'}],
                    series : [{
                            name: '微博粉丝数变化',
                            type: 'line',
                            data: biliFansAno,
                            smooth:true
                        }]
                }
                weiboFansAnoChart.setOption(option);

                var weiboReactChart = echarts.init(document.getElementById('c7'));
                var option = {
                    title : {text : '前100个投稿统计数据',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value',min:'dataMin',max:'dataMax'}],
                    series : [
                        {name: '播放数',type: 'line',data: biliPlay,smooth:true},
                        {name: '收藏数',type: 'line',data: biliFave,smooth:true},
                        {name: '评论数',type: 'line',data: biliComm,smooth:true},
                    ]
                }
                weiboReactChart.setOption(option);

                var weiboIndexChart = echarts.init(document.getElementById('c8'));
                var option = {
                    title : {text : '哔哩哔哩指数',subtext : user_name},
                    tooltip : {trigger: 'axis'},
                    toolbox: {show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    dataZoom: {show: true,},
                    legend : {show:true},
                    grid: {y2: 80},
                    xAxis : [{type : 'time',splitNumber:10}],
                    yAxis : [{type : 'value',min:'dataMin',max:'dataMax'}],
                    series : [
                        {
                            name: '哔哩哔哩视频指数',
                            type: 'line',
                            data: biliIndex,
                            smooth:true
                        },
                        {
                            name: '哔哩哔哩视频有效指数',
                            type: 'line',
                            data: biliIndex2,
                            smooth:true
                        },
                    ]
                }
                weiboIndexChart.setOption(option);
            });

        </script>
    </body>
</html>