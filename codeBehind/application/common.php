<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
* 接口返回数据函数
*
* @access public
* @param String 需要返回的信息内容
* @param Int 状态码(0为正常，1为异常)
* @return String JSON字符串
*/
function exit_msg($msg = "调试信息",$code = 1){
    $data['msg'] = $msg;
    $data['code'] = $code;
    exit(json_encode($data));
}

/**
* 密码加密
*
* @access public
* @param String 需要加密的密码
* @return String 加密后的字符串
*/
function encr($pw)
{
    return md5(md5($pw));
}

/**
* 去除字符的空格（所有的空格）
*
* @access public
* @param String 传入的字符串
* @return String 返回去除了空格的字符串
*/
function trim_blank($str="")
{
    return str_replace(" ","",$str);
}

/**
* 返回 layui-table 格式的数据
*
* @access public
* @param Array 符合条件且需要渲染的数据
* @param Array 符合条件的所有数据
* @param String 返回的信息内容
* @param Int 状态码(0为正常，1为异常)
* @return String JSON字符串
*/
function return_table($dataRows,$dataRowsAll,$msg = '',$code = 0)
{
    $arr['code'] = $code;
    $arr['msg'] = $msg;
    $arr['count'] = count($dataRowsAll);
    $arr['data'] = $dataRows;
    return json($arr);
}

/**
* 数字补足所需位数(数字前加0)
*
* @access public
* @param Int 待补足的数字
* @param Int 待补足的数字位数
* @return String 补足后的数字
*/
function complement($num,$digit)
{
    return sprintf("%0".$digit."d",$num);
}

/**
* 使用 phpexcel 读取数据
*
* @access public
* @param Array 条件数组：文件限制大小、后缀
* @param String 保存路径：默认在缓存目录下
* @return Array 读取的数据
*/
function getExcelData($condition = ['size'=>200000,'ext'=>'xlsx,xls,csv'],$savePath = RUNTIME_PATH . DS . 'excelField')
{
    import('PHPExcel.PHPExcel');
    $objPHPExcel = new \PHPExcel();

    //获取表单上传文件
    $file = request()->file('excel');
    $info = $file->validate($condition)->move($savePath);
    if ($info) {
        // 上传文件名
        $fileSaveName = $info->getSaveName();
        //上传文件的地址
        $filePath = $savePath . DS . $fileSaveName;
        $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
        //加载文件内容,编码utf-8
        $obj_PHPExcel =$objReader->load($filePath, $encode = 'utf-8');
        //转换为数组格式
        $excel_array=$obj_PHPExcel->getsheet(0)->toArray();
        // 去掉标题行
        $title_row = array_shift($excel_array);  //删除第一个数组(标题);
        return $excel_array;
    }else{
        exit_msg("上传失败，请检查权限问题！");
    }
}