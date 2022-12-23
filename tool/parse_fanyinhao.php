<?php
require('../include/config.php');
require('../include/init.php');
require('../include/public_fun.php');
/**
 * 去除一层反引号
 */
class Parse_fanyinhao extends Public_fun
{
    public function __construct()
    {
        // 危险操作，先关闭了
        die();
        $this->must_login();
        $this->parse();
    }
    /**
     * 开始替换重复的反引号
     */
    public function parse()
    {
        $table = Config::$table['article'];
        $sql = "UPDATE `$table` SET `content` = REPLACE(content, '\\\\\\\\', '\\\\')";
        mysqli_query(Init::$conn, $sql);
    }
}
new Parse_fanyinhao();
echo '处理完成';
