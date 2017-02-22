<?php
/**
 * php上传文件
 */
$allowtype = array("jpg","jpeg","png");
$MAX_FILE_SIZE = 1024*1024; // 1024KB=1MB
$save_path = "uploads/";
// echo $save_path;
// /Users/fanrong33/kuaipan/github_svn/mars-template/trunk/uploads/

$size     = $_FILES['file']['size'];
$type     = $_FILES['file']['type'];
$name     = $_FILES['file']['name'];
$tmp_name = $_FILES['file']['tmp_name'];
$error    = $_FILES['file']['error'];
// var_dump($_FILES);
// array(1) {
//   ["file"]=>
//   array(5) {
//     ["name"]=> string(15) "480x320-400.png"
//     ["type"]=> string(9) "image/png"
//     ["tmp_name"]=> string(26) "/private/var/tmp/phproiQ8O"
//     ["error"]=> int(0)
//     ["size"]=> int(36126) 36KB
//   }
// }

//判断文件是否上传成功
if($error > 0){
    echo ("文件上传出错:");
    switch($error){
        case 1: die("文件大于php.ini配置文件中限制的大小");
        case 2: die("文件大于表单允许上传的大小");
        case 3: die("只有部分文件被上传");
        case 4: die("没有文件被上传");
        default : die("未知错误");
    }
}

//判断上传文件的大小
if($size > $MAX_FILE_SIZE){
    die("上传文件大于允许上传的大小");
}
//判断上传文件是否是允许上传的格式
/*
获取上传文件的后缀名
array_pop 函数删除数组的最后一个元素
explode 函数将一个字符串以制定的字符，符号分割，返回一个数组
*/
$hz = array_pop(explode(".",$name));

if(!in_array($hz, $allowtype)){
    die("上传错误：上传文件为不可上传格式");
}
if(is_uploaded_file($tmp_name)){
    if(!move_uploaded_file($tmp_name, $save_path.$name)){
        die("移动文件出错");
    }
}else{
    die("非法上传文件");
}


list($width, $height) = getimagesize($save_path.$name);
// echo "文件{$name}上传成功,保存的目录{$save_path}";
$result = array(
    'status' => 1,
    'data'   => array(
        'url'   => $save_path.$name,
        'title' => $width.'x'.$height,
    )
);
// 返回JSON数据格式到客户端 包含状态信息
header('Content-Type:application/json; charset=utf-8');
echo json_encode($result);
?>