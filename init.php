<?php

/**
 * 初始化
 */
class Init
{
    /**
     * 数据库连接
     */
    public static mysqli $conn;

    public static function get_conn(): mysqli
    {
        $conn = mysqli_connect(Config::$mysql['host'], Config::$mysql['user'], Config::$mysql['pass'], Config::$mysql['db']);
        return $conn;
    }
    /**
     * 初始化数据表
     */
    public static function init_tables()
    {
        Init::init_table_book();
        Init::init_table_article();
    }
    /**
     * 创建手册表
     */
    public static function init_table_book()
    {
        $table = Config::$table['book'];
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` int NOT NULL AUTO_INCREMENT COMMENT '手册ID',
            `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
            `intro` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册介绍',
            `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册标题',
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;";
        mysqli_query(Init::$conn, $sql);
    }
    /**
     * 创建文章表
     */
    public static function init_table_article()
    {
        $table = Config::$table['article'];
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` int NOT NULL AUTO_INCREMENT COMMENT '文章ID',
            `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章标题',
            `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '文章内容',
            `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
            `book_id` int NULL DEFAULT NULL COMMENT '所属手册ID',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `book_id`(`book_id` ASC) USING BTREE,
            CONSTRAINT `iapp_doc_article_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `iapp_doc_book` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
        ) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;";
        mysqli_query(Init::$conn, $sql);
    }
}
Init::$conn = Init::get_conn();
Init::init_tables();
