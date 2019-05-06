// 案件搜索列表
Mock.mock('http://test.com', {
    //1. 过滤条件
    "filter": {
        "cities|9":[
            {
                "id":"@natural(60, 100)",
                "title":"@city",
                "areas":[{
                    "id":"@natural(60, 100)",
                    "title":"@county"
                }]
            }],//可选择在城市
        "selected":[],//选中的城市
        "types|10":[{
            "id":"@natural(60, 100)",
            "title":"@ctitle"
        }],
        "status":[
            {"id":"@natural(1, 20)","title":"可接案"},
            {"id":"@natural(1, 20)","title":"已诉前调解"},
            {"id":"@natural(1, 20)","title":"已立案"},
            {"id":"@natural(1, 20)","title":"已开庭"},
            {"id":"@natural(1, 20)","title":"已调解"},
            {"id":"@natural(1, 20)","title":"已判决"},
            {"id":"@natural(1, 20)","title":"已执行案件"},
            {"id":"@natural(1, 20)","title":"已结案"}
            ]
    },
    //2. 列表数据和分页
    "items": {
        "data|4": [{
            "no": "@increment(1001)",//案件编号
            "title": "@ctitle",//案件名称
            "cycle": "@integer(60, 100)",//办案周期
            "duration": "@integer(1, 10)",//合作周期
            "total": "@integer(150, 400)",//合作案件总数
            "cover|1": ['http://test.com/a.png','http://test.com/b.png','http://test.com/c.png']//封面图片
        }],
        "pagination": {//分页
            "total_page": "@integer(1, 10)",//总页数
            "total_record": "@integer(1, 100)",//总记录数
            "page": "@integer(1, 10)",//当前页
            "page_size": 4,//每页记录数
        }
    }
});