// 律师地图
Mock.mock('http://test.com', {
    //1. 过滤条件
    "filter": {
        //可选择在城市
        "cities|9":[
            {
                "id":"@natural(60, 100)",
                "title":"@city",
                "areas":[{
                    "id":"@natural(60, 100)",
                    "title":"@county"
                }]
            }],
        //类型
        "types|10":[{
            "id":"@natural(60, 100)",
            "title":"@ctitle"
        }],
    },
    //2. 地图数据
    "items": {
        "data|4-8": [{
            "title": "@county",//区域
            "total": "@integer(150, 400)人",//人数
        }]
    }
});