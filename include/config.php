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
    /**
     * 网站名称
     */
    public static string $site_title = 'iApp 手册网';
    /**
     * 网站部署路径
     * 
     * 如果是根目录，则留空
     * 
     * 如果是二级目录，则为 `/path`
     * 
     * 如果是三级目录，则为 `/path/path2`
     */
    public static string $site_path = '/iapp-doc';
    /**
     * 是否开启伪静态
     */
    public static bool $url_static = true;
}
