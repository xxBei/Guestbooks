<?php
/**
 * 文件用途：ＭＹＳＱＬ数据库连接
 * ==============================================
 * @date: 2017/6/8 9:05
 * @author: zbei
 * @version:
 */

//防止恶意调用
if(!defined('ROOT')){
    exit('Access Defined!');
}

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'root');
define('DB_NAME', 'guestbooks');

/**
 * _mysql_connect() MYSQL数据库连接
 * @access public
 * @return void
 */
function _mysql_connect(){
    //全局变量，在函数外也可以访问，想要在另一个函数内访问，需要先写一个global $_conn;，才能被访问
    global $_conn;
    if(!$_conn = mysqli_connect(DB_SERVER,DB_USER,DB_PWD)){
        exit('数据库连接失败');
    }
}

/**
 * _mysql_select_dbname() 选择数据库
 * @access public
 * @return void
 */
function _mysql_select_dbname(){
    global $_conn;
    if (!mysqli_select_db($_conn,DB_NAME)){
        exit('找不到指定数据库');
    }
}

/**
 * _mysql_charset() 设置数据库编码
 */
function _mysql_charset(){
    global $_conn;
    if(!mysqli_set_charset($_conn,'UTF8')){
        exit('字符编码不正确');
    }
}


function _mysql_close(){
    global $_conn;
    return mysqli_close($_conn);
}


function _mysql_affected_rows(){
    global $_conn;
    return mysqli_affected_rows($_conn);
}

/**
 * _mysql_query() 数据库执行操作
 * @param $_sql SQL语句
 * @return bool|mysqli_result
 */
function _mysql_query($_sql){
    global $_conn;
    if(!$_result = mysqli_query($_conn,$_sql)){
        exit('SQL执行失败'.mysqli_error($_conn));
    }
    return $_result; 
}

/**
 * _mysql_fetch_array() 从结果集取得一行作为数字数组或关联数组，只有一行
 * @param $_sql SQL语句
 * @return array|null
 */
function _mysql_fetch_array($_sql){
    return mysqli_fetch_array(_mysql_query($_sql),MYSQLI_ASSOC);
}

/**
 * _mysql_fetch_array_list() 从结果集取得一行作为数字数组或关联数组，多行
 * @param $_result
 * @return array|null
 */
function _mysql_fetch_array_list($_result){
    return mysqli_fetch_array($_result,MYSQLI_ASSOC);
}

/**
 * _is_repeat() 验证是否有重复数据
 * @param $_sql SQL语句
 * @param $_info 提示信息
 */
function _is_repeat($_sql,$_info){
    if(_mysql_fetch_array($_sql)){
        _alert_back($_info);
        exit();
    }
}

/**
 * _mysql_num_rows() 查看数据库中有多少条数据,该函数用于分页处理
 * @access public
 * @param $_sql
 * @return int
 */
function _mysql_num_rows($_sql){
    return mysqli_num_rows(_mysql_query($_sql));
}

/**
 * _mysql_free_result() 释放结果集资源
 */
function _mysql_free_result($_result){
    return mysqli_free_result($_result);
}

/**
 * _mysql_insert_id() 获取上一条的id
 * @return int|string
 */
function _mysql_insert_id(){
    global $_conn;
    return mysqli_insert_id($_conn);
}
?>