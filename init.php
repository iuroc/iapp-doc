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
        Init::init_table_into();
    }
    /**
     * 创建手册表
     */
    public static function init_table_book()
    {
        $table = Config::$table['book'];
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `id` INT NOT NULL AUTO_INCREMENT COMMENT '手册ID',
            `create_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
            `intro` VARCHAR ( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册介绍',
            `title` VARCHAR ( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册标题',
            PRIMARY KEY ( `id` ) USING BTREE 
        ) ENGINE = INNODB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;";
        mysqli_query(Init::$conn, $sql);
    }
    /**
     * 创建手册和文章的关联关系表
     */
    public static function init_table_into()
    {
        $table = Config::$table['into'];
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (
            `book_id` int NOT NULL COMMENT '手册ID',
            `article_id` int NOT NULL COMMENT '文章ID',
            INDEX `article_id`(`article_id` ASC) USING BTREE,
            INDEX `book_id`(`book_id` ASC) USING BTREE,
            CONSTRAINT `iapp_doc_into_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `iapp_doc_book` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
            CONSTRAINT `iapp_doc_into_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `iapp_doc_article` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
        ) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;";
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
            PRIMARY KEY (`id`) USING BTREE
        ) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;";
        mysqli_query(Init::$conn, $sql);
    }
}
Init::$conn = Init::get_conn();
Init::init_tables();
