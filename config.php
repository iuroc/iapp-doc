<?php

/**
 * 配置类
 */
class Config
{
    /**
     * 数据库配置信息
     */
    public static array $mysql = [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '12345678',
        'db' => 'ponconsoft'
    ];
    /**
     * 数据表信息
     */
    public static array $table = [
        'book' => 'iapp_doc_book',
        'article' => 'iapp_doc_article',
        'into' => 'iapp_doc_into'
    ];
    /**
     * 管理员信息
     */
    public static array $admin = [
        // 管理员密码
        'password' => '12345678'
    ];
}
