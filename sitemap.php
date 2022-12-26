<?php
require('./include/config.php');
require('./include/init.php');
/**
 * 生成站点地图
 */
class Site_map
{
    /**
     * URL 列表
     */
    public array $url_list;
    /**
     * 输出格式：txt、xml
     */
    public string $format;
    /**
     * 站点域名
     * 
     * 如果站点位于二级目录，则填 `http://domain/path`，注意结尾没有斜杠
     */
    public string $domain = 'http://iapp.apee.top';
    public function __construct()
    {
        $this->url_list = [$this->domain];
        $this->format = $_GET['format'] ?? 'txt';
        $this->get_books_url();
        $this->get_article_url();
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
            $url = $this->domain . '/book_' . $id . '.html';
            array_push($this->url_list, $url);
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
            $url = $this->domain . '/article_' . $id . '.html';
            array_push($this->url_list, $url);
        }
    }
}

$site_map = new Site_map();
if ($site_map->format == 'txt') {
    header('Content-Type: text/plain; charset=utf-8');
    foreach ($site_map->url_list as $url) {
        echo $url . PHP_EOL;
    }
} elseif ($site_map->format == 'xml') {
    header('Content-Type: text/xml; charset=utf-8');
    ini_set('date.timezone', 'Asia/Shanghai');
    $lastmod = date('Y-m-d\TH:i:s+08:00');
    echo '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
    foreach ($site_map->url_list as $url) {
        if (preg_match('/book_(\d+).html/', $url)) {
            $priority = 0.8;
        } elseif (preg_match('/article_(\d+).html/', $url)) {
            $priority = 0.64;
        } elseif ($url == $site_map->domain) {
            $priority = 1.0;
        } else {
            $priority = 0.3;
        }
        echo '
    <url>
        <loc>' . $url . '</loc>
        <lastmod>' . $lastmod . '</lastmod>
        <priority>' . $priority . '</priority>
    </url>';
    }
    echo '
</urlset>';
}
