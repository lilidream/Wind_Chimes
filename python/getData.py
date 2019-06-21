import json
import requests
import datetime

def errorLog(errrorType,Uid):
    time = datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    logfile = open("../log/error_log.txt",'a',encoding='utf-8')
    logfile.write(time+","+errrorType+","+str(Uid)+"\n")
    logfile.close()

#获取微博数据
def getWeiboData(weiboUid):
    data = {"state":1,"fans":0,"repo":0,"comm":0,"like":0} #创建数据组，状态为1
    headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.63 Safari/537.36'}
    try: #尝试GET
        weibo_data = requests.get("https://m.weibo.cn/api/container/getIndex?type=uid&value="+str(weiboUid)+"&containerid=100505"+str(weiboUid),headers=headers,timeout=5)
    except requests.exceptions.ConnectTimeout: #超时
        errorLog("Weibo Connect Timeout",weiboUid)
        data["state"] = 0
    else: 
        if weibo_data.status_code == 403: #是否被禁止访问
            errorLog("Weibo Connection 403",weiboUid)
            data["state"] = 0
        else:
            user_info = json.loads(weibo_data.text)
            data["fans"] = user_info["data"]["userInfo"]["followers_count"]

    #统计信息
    for i in range(5):
        try:
            weibo_data = requests.get("https://m.weibo.cn/api/container/getIndex?type=uid&value="+str(weiboUid)+"&containerid=107603"+str(weiboUid)+"&page="+str(i+1),headers=headers,timeout=3)
        except requests.exceptions.ConnectTimeout:
            errorLog("Weibo Connect2 Timeout",weiboUid)
            data["state"] = 0
        else:
            if weibo_data.status_code == 403:
                errorLog("Weibo Connection2 403",weiboUid)
                data["state"] = 0
            else:
                card_data = json.loads(weibo_data.text)
                for j in range(len(card_data["data"]["cards"])):
                    data["repo"]+=card_data["data"]["cards"][j]["mblog"]["reposts_count"]
                    data["comm"]+=card_data["data"]["cards"][j]["mblog"]["comments_count"]
                    data["like"]+=card_data["data"]["cards"][j]["mblog"]["attitudes_count"]
    
    data["weiboIndex"] = int(data["comm"]*0.4+data["repo"]*0.4+data["like"]*0.2)
    data["weiboIndex2"] = int(data["weiboIndex"]*100000/data["fans"])

    return data

#获取Bilibili数据
def getBiliData(biliUid):
    headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.63 Safari/537.36'}
    data = {"state":1,"fans":0,"play":0,"fave":0,"comm":0}
    try:
        bili_data = requests.get("https://api.bilibili.com/x/relation/stat?jsonp=jsonp&vmid="+str(biliUid),headers=headers,timeout=5)
    except requests.exceptions.ConnectTimeout:
        errorLog("Bili Connect Timeout",biliUid)
        data["state"] = 0
    else:
        if bili_data.status_code == 403:
            errorLog("Bili Connect 403",biliUid)
            data["state"] = 0
        else:
            user_info = json.loads(bili_data.text)
            data["fans"] = user_info["data"]["follower"]
    
    try:
        bili_data = requests.get("https://space.bilibili.com/ajax/member/getSubmitVideos?mid="+str(biliUid)+"&pagesize=100&tid=0&page=1&keyword=&order=pubdate",headers=headers,timeout=5)
    except requests.exceptions.ConnectTimeout:
        errorLog("Bili Connect2 Timeout",biliUid)
        data["state"] = 0
    else:
        if bili_data.status_code == 403:
            errorLog("Bili Connect2 403",biliUid)
            data["state"] = 0
        else:
            video_info = json.loads(bili_data.text)
            for video in video_info["data"]["vlist"]:
                data["play"] += video["play"]
                data["fave"] += video["favorites"]
                data["comm"] += video["comment"]
    data["biliIndex"] = int(data["play"]*0.1+data["fave"]*0.6+data["comm"]*0.2)
    data["biliIndex2"] = int(data["biliIndex"]*1000/data["fans"])
    return data
        
def loadInfo():
    thefile = open("../info/info.json",'r',encoding='utf-8')
    data = json.loads(thefile.read())
    thefile.close()
    return data

def loadJson(path):
    thefile = open(path,'r',encoding='utf-8')
    data = json.loads(thefile.read())
    thefile.close()
    return data
    
def writeJson(path,data):
    thefile = open(path,'w+',encoding='utf-8')
    thefile.write(json.dumps(data,ensure_ascii=False))
    thefile.close()
    return "Json wrote"

if __name__ == "__main__":
    info = loadInfo()
    for uid in info:
        print("Get data at:"+info[uid]["name"])

        info_data = loadJson("../info/data.json")
        info_d = {}
        data = {"time":datetime.datetime.now().strftime('%Y-%m-%d %H:%M')}
        if info[uid]["weiboUid"] != "":
            weiboData = getWeiboData(info[uid]["weiboUid"])
            data["weibo"] = [weiboData["fans"],weiboData["repo"],weiboData["comm"],weiboData["like"],weiboData["weiboIndex"],weiboData["weiboIndex2"]]
            info_d["weiboFans"] = weiboData["fans"]
            info_d["weiboIndex"] = weiboData["weiboIndex"]
            info_d["weiboIndex2"] = weiboData["weiboIndex2"]
        if info[uid]["biliUid"] != "":
            biliData = getBiliData(info[uid]["biliUid"])
            data["bili"] = [biliData["fans"],biliData["play"],biliData["fave"],biliData["comm"],biliData["biliIndex"],biliData["biliIndex2"]]
            info_d["biliFans"] = biliData["fans"]
            info_d["biliIndex"] = biliData["biliIndex"]
            info_d["biliIndex2"] = biliData["biliIndex2"]
        
        oridata = loadJson("../data/"+str(uid)+".json")
        length = len(oridata)
        oridata[str(length+1)] = data
        writeJson("../data/"+str(uid)+".json",oridata)

        info_d["name"] = info[uid]["name"]
        info_data[uid] = info_d
        writeJson("../info/data.json",info_data)
