<?php
/**
* 文件用途：过滤信息
* ==============================================
* @date: 2017年6月4日
* @author: zbei
* @version:
*/
//防止恶意调用
if(!defined('ROOT')){
    echo 'Access Defined!';
}
if(!function_exists('_alert_back')){
    exit('_alert_back()函数不存在');
}

/**
 * @_check_username() 检测用户名函数
 * @access public 公共函数
 * @param string $_string 没有过滤的用户名
 * @param int $min_num
 * @param int $max_num
 * @return string $_string 过滤后的用户名
 */
function _check_username($_string,$min_num,$max_num){
    //去掉空格
    $_string = trim($_string);
    //长度小于两位或大于二十位
    if(mb_strlen($_string,'utf-8')<$min_num || mb_strlen($_string,'utf-8')>$max_num){
        _alert_back('长度不能小于'.$min_num.'位或大于'.$max_num.'位!');
    }

    //限制敏感字符
    $_char_pattern = '/[<>\'\"\ \　]/';
    if(preg_match($_char_pattern, $_string)){
        _alert_back('用户名不得包含敏感字符！');
    }

    //敏感用户名
    $_mg[0] = 'xbei';
    $_mg[1] = 'zbei';
    foreach ($_mg as $value){
        @$_mg_string .= $value.'\n';
    }
    if(in_array($_string, $_mg)){
        _alert_back($_mg_string.'敏感用户名不得注册！');
    }
    //将用户名转义输出
//     return mysqli_real_escape_string($_string);
    return $_string;
}

/**
 * _check_password 验证密码
 * @access public
 * @param String $_first 密码
 * @param String $_end 确认密码
 * @param int $min_num 最小位数
 * @return String $_first 加密的密码
 */
function _check_password($_first,$_end,$min_num){
    //密码不能小于6位
    if(strlen($_first) < 6){
        exit(_alert_back('密码不能小于'.$min_num.'位'));
    }
    //验证两次密码是否一致
    if($_first != $_end){
        exit(_alert_back('两次密码不一致'));
    }
    //返回加密密码
    return sha1($_first);
}

/**
 * _check_question 验证问题
 * @access public
 * @param String $_question 问题
 * @param int $min_num 最小位数
 * @param int $max_num 最大位数
 * @return string $_question 转义密码问题
 */
function _check_question($_question,$min_num,$max_num){
    //密码问题不能小于4位或大于20位
    if(mb_strlen($_question,'utf-8')<$min_num || mb_strlen($_question,'utf-8')>$max_num){
        _alert_back('密码问题不能小于'.$min_num.'位或大于'.$max_num.'位');
    }
    //返回转义密码问题
    return addslashes($_question);
}

/**
 * _check_answer 验证密码答案
 * @access public
 * @param String $_ques 密码问题
 * @param String $_answ 密码答案
 * @param int $min_num 最小位数
 * @param int $max_num 最大位数
 * @return string $_answ 加密密码答案
 */
function _check_answer($_ques,$_answ,$min_num,$max_num){
    //密码答案不能小于2位或大于20位
    if(mb_strlen($_answ,'utf-8')<$min_num || mb_strlen($_answ,'utf-8')>$max_num){
        _alert_back('密码答案不能小于'.$min_num.'位或大于'.$max_num.'位');
    }
    //密码答案不能和密码回答一致
    if($_ques == $_answ){
        _alert_back('密码答案不能和密码问题一致！');
    }
    //返回加密答案
    return sha1($_answ);
}














?>