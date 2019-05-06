//客户端首页数据
Mock.mock('http://test.com', {
    //1. 统计数据
    "summary|4":[
        {
            "title":"@ctitle",//统计名称
            "total|1000-9999":0//统计总数
        }
    ],
    //2. 热门案件
    "hot|9":[
        {
            "no":"@increment(1001)",//案件编号
            "title":"@ctitle",//案件标题
            "cycle":"@integer(60, 100)",//办案周期
            "duration":"@integer(1, 10)",//合作周期
            "total":"@integer(150, 400)",//合作案件总数
            "price":"￥@float(2000, 10000)",//价格
        }
    ],
    //3. 合作企业
    "companies|8":[
        {
            "duration":"@integer(1, 10)",//合作年数
            "total":"@integer(150, 400)",//合作案件
            "total_case":"@integer(150, 400)",//总案件数
            "ing_case":"@integer(50, 400)",//进行中在案件
            "avg_days":"@integer(1, 300)",//平均处理天数
        }
    ]
});