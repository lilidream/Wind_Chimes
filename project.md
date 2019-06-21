# 爬取数据
## 微博 - weibo
 - 粉丝数
 - 前50条微博互动数

## 指数
微博互动指数(index1)  =  评论数\*0.4 + 转发数\*0.4 + 点赞数\*0.2
微博粉丝有效互动指数(index2)  =  (评论数\*0.4 + 转发数\*0.4 + 点赞数\*0.2)*100000/粉丝数
哔哩哔哩视频指数  =  播放数\*0.1+ 收藏数\*0.7 + 评论数\*0.2

## 哔哩哔哩 - bilibili
 - 粉丝数 `https://api.bilibili.com/x/relation/stat?jsonp=jsonp&vmid=4549624`
 - 视频`https://space.bilibili.com/ajax/member/getSubmitVideos?mid=52250&pagesize=100&tid=0&page=1&keyword=&order=pubdate`
 

# 数据结构
## 信息文件
```chinese
info/info.json
{
  "1":{
    "name":"",
    "weiboUid":"",
    "biliUid":"",
    ...
  },
  ...
}
```
## 数据文件
```chinese
data/$wcid.json
{
  "1":{
    "time":time,
    "weibo":[fans,repo,comm,like],
    "bili":[fans,play,fave,comm]
  },
  ...
}
```
## 简要数据
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
