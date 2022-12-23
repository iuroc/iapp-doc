<?php
require('./include/config.php');
require('./include/init.php');
header('Content-Type: text/plain; charset=utf-8');
/**
 * 生成站点地图
 */
class Site_map
{
    /**
     * URL 列表
     */
    public string $urls;
    /**
     * 站点域名
     * 
     * 如果站点位于二级目录，则填 `http://domain/path`
     */
    public string $domain = 'http://iapp.apee.top';
    public function __construct()
    {
        $this->urls = $this->domain . PHP_EOL;
        $type = $_GET['type'] ?? 'txt';
        if ($type == 'txt') {
            $this->get_books_url();
            $this->get_article_url();
        }
    }
    /**
     * 获取手册 URL 列表
     */
    public function get_books_url()
    {
        $table = Config::$table['book'];
        $sql = "SELECT `id` FROM `$table`";
        $result = mysqli_query(Init::$conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $this->urls .= $this->domain . '/book_' . $id . '.html' . PHP_EOL;
        }
    }
    /**
     * 获取手册 URL 列表
     */
    public function get_article_url()
    {
        $table = Config::$table['article'];
        $sql = "SELECT `id` FROM `$table`";
        $result = mysqli_query(Init::$conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $this->urls .= $this->domain . '/article_' . $id . '.html' . PHP_EOL;
        }
    }
}

$site_map = new Site_map();
echo $site_map->urls;
