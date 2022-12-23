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
     * 站点描述（对部分页面有效）
     */
    public static string $description = '这是一个专注于分享 iApp 开发技术的网站，由热爱 iApp 的开发者创建。';
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
