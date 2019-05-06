//热点新闻
Mock.mock('http://test.com', {
    //1. 最新热点
    'news|4':[{
        'tag':'最热',//最热标签
        'title':"@csentence",//标题
        'page':"@cparagraph(1, 3)",//内容
        'publish_date':'@date("yyyy-MM-dd")',//发布时间
        'total_up':"@integer(100,300)"
    }],
    //2. 个人资料
    'profile':{
        "name":"@cname",
        "company":"@ctitle",
        "up":"@integer(100,300)",
        "favorite":"@integer(10,100)",
        "proxy":"@integer(1,100)",
    }
});