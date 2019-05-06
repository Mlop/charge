//律师列表
Mock.mock('http://test.com', {
    //1. 全国实际执业律师参考数据
    "stat|6":[{
        "title":"@region()地区律师参考总数",
        "data|3-8": [{
            "location": "@province",
            "percent": "@integer(1,100)%"
        }],
    }],
    //2. 过滤条件
    "filter": {
        //可选择城市
        "cities|9": [
            {
                "id": "@natural(60, 100)",
                "title": "@city",
                "areas": [{
                    "id": "@natural(60, 100)",
                    "title": "@county"
                }]
            }],
        //案件类型
        "types|10": [{
            "id": "@natural(60, 100)",
            "title": "@ctitle"
        }],
    },
    //3. 列表数据
    "items": {
        //数据
        'list|9': [{
            "title": "@province",
            "sign_duration": "@natural(12, 540)",
            "total": "@natural(200, 1000)",
            "total_case": "@natural(200, 1000)",
            "ing_case": "@natural(200, 1000)",
            "end_case": "@natural(200, 1000)",
        }],
        //分页
        "pagination": {
            "total_page": "@integer(1, 10)",//总页数
            "total_record": "@integer(1, 100)",//总记录数
            "page": "@integer(1, 10)",//当前页
            "page_size": 4,//每页记录数
        }
    }
});