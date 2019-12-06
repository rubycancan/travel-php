<?php
include_once "../lib/tools.php";
//验证是否有已经选择好了的城市，如果没有就默认为南宁
if(isset($_GET['city']) && $_GET['city'] != '') {
    $city = $_GET['city'];
} else {
    $city = '南宁';
}

//查询当前页面所属城市id
$cityData = query_row("SELECT * FROM cities WHERE name='$city'");

if(!$cityData) {
    $result['ret'] = false;
    $jsonString = json_encode($result);
    echo $jsonString;
    exit;
}
$cityId = $cityData['id'];

//查询轮播图列表
$swiperList = query_list("SELECT * FROM swipers WHERE city_id=$cityId");
//首页圆形图表里的内容列表
$iconList = query_list("SELECT * FROM icons WHERE city_id=$cityId");
//查询热销推荐列表
$recommendList = query_list("SELECT * FROM recommends WHERE city_id=$cityId");
//查询周末推荐列表
$weekendList = query_list("SELECT * FROM weekends WHERE city_id=$cityId");

//将查询结果转换为JSON数据
$result = array();
$result['ret'] = true;
$result['data']['city'] = $city;//前端显示city，这里的city可以考虑去掉，4天津，5长春，6长沙
$result['data']['swiperList'] = $swiperList;
$result['data']['iconList'] = $iconList;
$result['data']['recommendList'] = $recommendList;
$result['data']['weekendList'] = $weekendList;
$jsonString = json_encode($result);
echo $jsonString;