<?php
include_once "../lib/tools.php";
//验证是否选择了景点，没有选择的话返回false
if(isset($_GET['detail_id']) && $_GET['detail_id'] != '') {
    $detail_id = $_GET['detail_id'];
} else {
    $result['ret'] = false;
    $jsonString = json_encode($result);
    echo $jsonString;
    exit;
}

//查询当前所选景点基本信息
$sceneryData = query_row("SELECT * FROM sceneries WHERE id='$detail_id' LIMIT 1");

if(!$sceneryData) {
    $result['ret'] = false;
    $jsonString = json_encode($result);
    echo $jsonString;
    exit;
}

$sceneryId = $sceneryData['id'];

//根据当前景点id查询当前景点画廊展示的景点图片
$galleryData = query_list("SELECT img_url FROM sce_photos WHERE scenery_id='$sceneryId'");
//根据景点ID查询当前景点门票的分类列表
$categoryList = query_list("SELECT b.id,b.name AS category FROM tickets AS a LEFT JOIN ticket_categories AS b
    ON a.ticket_category_id = b.id WHERE a.scenery_id='$sceneryId' GROUP BY b.name,b.id");


$result['ret'] = true;
if($sceneryData['star_lev'] == '') {
    $result['data']['sightName'] = $sceneryData['name'];
} else {
    $result['data']['sightName'] = $sceneryData['name'].'('.$sceneryData['star_lev'].'景区)';
}
$result['data']['bannerImg'] = $sceneryData['img_url'];
foreach ($galleryData as $value) {
    $result['data']['galleryImgs'][] = $value['img_url'];
}
//将票类名循环进去
foreach ($categoryList AS $value) {
    $result['data']['categoryList'][]['title'] = $value['category'];
}

//将票名根据类名循环进json数组去
foreach ($categoryList AS $key => $value) {
    $categoryId = $value['id'];
    $ticketList = query_list("SELECT * FROM tickets WHERE ticket_category_id='$categoryId' AND scenery_id='$sceneryId'");
    foreach($ticketList AS $ticket) {
        $result['data']['categoryList'][$key]['children'][]['title'] = $ticket['name'];
    }
}

$jsonString = json_encode($result);
echo $jsonString;