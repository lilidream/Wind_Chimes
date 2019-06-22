# 风铃 | Wind Chimes
风铃是一款由前后端来获取与展示微博与哔哩哔哩用户（偶像）粉丝相关数据的应用
## 主题色
#e2359b


# 爬取数据内容
## 微博 - weibo
 - 粉丝数
 - 前50条微博总计互动数\[转发,评论,点赞\]
## 哔哩哔哩 - bilibili
 - 粉丝数
 - 前100个投稿视频总计\[播放,评论,收藏\]
## 后台执行
使用Ubuntu 16.04 Server作为后台服务端，启动crontab定时计划定时执行`python/getData.py`爬取数据

建议一日爬取1~4次，过多可能会被新浪或B站禁掉

获取数据失败会写入csv格式的`log/error_log.txt`

## 定义粉丝指数
 - 微博互动指数(index1)  =  评论数\*0.4 + 转发数\*0.4 + 点赞数\*0.2
 - 微博粉丝有效互动指数(index2)  =  微博互动指数\*100000/粉丝数
 - 哔哩哔哩视频指数(index1)  =  播放数\*0.1+ 收藏数\*0.7 + 评论数\*0.2
 - 哔哩哔哩粉丝有效指数(index2)  =  哔哩哔哩视频指数\*1000/粉丝数
 
## 添加用户
点击主页右上角“添加”，或`add.html`

**【已完成】以下动作计划由页面完成**

在`info/info.json`文件里添加一组数据
```
"本应用的uid":{
  "name":"用户名称"
  "weiboUid":"用户微博Uid，不可无"
  "biliUid":"用户B站Uid，无则留空"
}
```
在`avatat`文件夹下添加用户的头像文件`uid.jpg`
图像为1:1，大于150px*150px

# 数据结构
## 用户信息文件
```chinese
info/info.json
{
  "1":{
    "name":"",
    "weiboUid":"",
    "biliUid":"",
    "info":简介,
  },
  ...
}
```
## 用户数据文件
```chinese
data/用户uid.json
{
  "1":{
    "time":time,
    "weibo":[fans,repo,comm,like,index1,index2],
    "bili":[fans,play,fave,comm,index1,index2]
  },
  ...
}
```
## 用户简要数据
```chinese
info/data.json
{
  "uid":{
    "name":name,
    "weiboFans":weibo_fans,
    "biliFans":bili_fans,
    "weiboIndex":weibo_index,
    "bili_index":bili_index
  },
  ...
}
```
