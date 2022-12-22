-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: ponconsoft
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `iapp_doc_book`
--

DROP TABLE IF EXISTS `iapp_doc_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `iapp_doc_book` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '手册ID',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间',
  `intro` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册介绍',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手册标题',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iapp_doc_book`
--

LOCK TABLES `iapp_doc_book` WRITE;
/*!40000 ALTER TABLE `iapp_doc_book` DISABLE KEYS */;
INSERT INTO `iapp_doc_book` VALUES (20,'2022-12-21 18:14:09','裕语言 3.0 参考文档，包含裕语言 3.0 所有函数的介绍、语法、示例。文档经站长精心校对整理而成。制作不易，感谢支持。','裕语言 3.0 <span class=\"text-danger fw-bold\">参考文档</span>','2022-12-22 15:28:40'),(40,'2022-12-22 13:58:20','《游戏开发功能iGame》是解释型语言，丰富的类库定置简单快速开发你的游戏程序，让开发过程变得娱乐化大众化。是基于libgdx引擎（https://github.com/libgdx/libgdx）的扩展开发，通过大量的开发编程目前已实现游戏的可视化开发。《裕语言》是由计算编程工程师 黄裕先生 为主导，宇恒先生、宇辰先生等工程师共同参与完成开发，定制以及实现成型代码功能，其代码简单方便的编写体验是一大亮点。裕语言的开发游戏程序语言，全面向公众开放平台，任何有兴趣的人都可以参与开放设计自己的程序。\r\n《游戏开发功能iGame》所有的预设代码命名采用 拼音开头字母/ 全拼等。整体符合主流，采用面向对象方式编程，所有代码都由根对象延伸，简入深出的系统性学习。支持导入原生android 所有的SDK；所有代码都编译成 java代码，再编译成dex文件。','iGame 1.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:28:18'),(41,'2022-12-22 13:59:33','《游戏开发功能iGame》是解释型语言，丰富的类库定置简单快速开发你的游戏程序，让开发过程变得娱乐化大众化。是基于libgdx引擎（https://github.com/libgdx/libgdx）的扩展开发，通过大量的开发编程目前已实现游戏的可视化开发。《裕语言》是由计算编程工程师 黄裕先生 为主导，宇恒先生、宇辰先生等工程师共同参与完成开发，定制以及实现成型代码功能，其代码简单方便的编写体验是一大亮点。裕语言的开发游戏程序语言，全面向公众开放平台，任何有兴趣的人都可以参与开放设计自己的程序。\r\n《游戏开发功能iGame》所有的预设代码命名采用 拼音开头字母/ 全拼等。整体符合主流，采用面向对象方式编程，所有代码都由根对象延伸，简入深出的系统性学习。支持导入原生android 所有的SDK；所有代码都编译成 java代码，再编译成dex文件。','iGame 中文编程 1.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:47:39'),(42,'2022-12-22 14:05:08','1. 出错后报错信息，显示在调试日志里。\r\n2. 语法完整参照java语法 和 Android的api\r\n3. 融合裕语言代码，写法和使用方式有所不同。\r\n4. 入口文件必须为 mian.iyu 如果全部采用此语言开发，可以在入口文件加一个uigo跳转。\r\n5. 更多不同点可以自行探索。\r\n6. java语言相对复杂，更多教程资料可以自己百度找找。\r\n7. 注意java的类都是需要导入完整包名的，否则会出错。可以使用 import 或 imports 进行导入包名。','iJava 3.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:28:25'),(51,'2022-12-22 14:25:07','JavaScript一种直译式脚本语言，是一种动态类型、弱类型、基于原型的语言，内置支持类型。它的解释器被称为JavaScript引擎，为浏览器的一部分，广泛用于客户端的脚本语言，最早是在HTML（标准通用标记语言下的一个应用）网页上使用，用来给HTML网页增加动态功能。\r\n在1995年时，由Netscape公司的Brendan Eich，在网景导航者浏览器上首次设计实现而成。因为Netscape与Sun合作，Netscape管理层希望它外观看起来像Java，因此取名为JavaScript。但实际上它的语法风格与Self及Scheme较为接近。\r\n为了取得技术优势，微软推出了JScript，CEnvi推出ScriptEase，与JavaScript同样可在浏览器上运行。为了统一规格，因为JavaScript兼容于ECMA标准，因此也称为ECMAScript。','iJS 3.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:28:07'),(52,'2022-12-22 14:26:23','Lua 是一种轻量小巧的脚本语言，用标准C语言编写并以源代码形式开放， 其设计目的是为了嵌入应用程序中，从而为应用程序提供灵活的扩展和定制功能。\r\nLua 是巴西里约热内卢天主教大学（Pontifical Catholic University of Rio de Janeiro）里的一个研究小组，由Roberto Ierusalimschy、Waldemar Celes 和 Luiz Henrique de Figueiredo所组成并于1993年开发。 \r\nLuaJava项目由 Carlos Cassino 在2004年开发创建，上传开源，并未作出使用限制。以及 Thiago Ponte 作为主要代码贡献者，在2005年和2007年等进行了更新。 \r\niApp引用了他们的项目基础，并进行了升级和修复BUG','iLua 3.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:28:12'),(53,'2022-12-22 14:27:16','《裕语言》是一基于java的扩展性脚本语言，丰富的类库定置简单快速编程开发你的应用程序，让编程开发过程变得简单化、大众化。《裕语言》是由游改乐计算编程工程师 黄裕先生、宇恒先生 定制以及实现成型代码功能，其代码简单方便的编写体验是一大亮点，目前还会有更多强大的功能完善中。裕语言V3.0是基于iApp平台上运行的程序语言，任何有兴趣的人都可以参与开放设计自己的代码程序。','裕语言 3.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:27:58'),(54,'2022-12-22 15:27:22','《裕语言V5》是解释型语言，丰富的类库定置简单快速开发你的应用程序，让开发过程变得娱乐化大众化。《裕语言》是由计算编程工程师 黄裕先生 为主导，宇恒先生、宇辰先生等工程师共同参与完成开发，定制以及实现成型代码功能，其代码简单方便的编写体验是一大亮点。裕语言的开发应用程序语言，全面向公众开放平台，任何有兴趣的人都可以参与开放设计自己的程序。\r\n《裕语言V5》所有的预设代码命名采用 拼音开头字母/ 全拼等。整体符合主流，采用面向对象方式编程，所有代码都由根对象延伸，简入深出的系统性学习。支持导入原生android 所有的SDK；所有代码都编译成 java代码，再编译成dex文件。','裕语言 5.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:27:51'),(55,'2022-12-22 15:49:15','1. 出错后报错信息，显示在调试日志里。\r\n2. 语法完整参照java语法 和 Android的api\r\n3. 融合裕语言代码，写法和使用方式有所不同。\r\n4. 入口文件必须为 mian.iyu 如果全部采用此语言开发，可以在入口文件加一个uigo跳转。\r\n5. 更多不同点可以自行探索。\r\n6. java语言相对复杂，更多教程资料可以自己百度找找。\r\n7. 注意java的类都是需要导入完整包名的，否则会出错。可以使用 import 或 imports 进行导入包名。','裕语言 6.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:50:35'),(56,'2022-12-22 15:51:57','《裕语言V5》是解释型语言，丰富的类库定置简单快速开发你的应用程序，让开发过程变得娱乐化大众化。《裕语言》是由计算编程工程师 黄裕先生 为主导，宇恒先生、宇辰先生等工程师共同参与完成开发，定制以及实现成型代码功能，其代码简单方便的编写体验是一大亮点。裕语言的开发应用程序语言，全面向公众开放平台，任何有兴趣的人都可以参与开放设计自己的程序。\r\n《裕语言V5》所有的预设代码命名采用 拼音开头字母/ 全拼等。整体符合主流，采用面向对象方式编程，所有代码都由根对象延伸，简入深出的系统性学习。支持导入原生android 所有的SDK；所有代码都编译成 java代码，再编译成dex文件。','裕语言中文编程 5.0 <span class=\"text-primary\">官方文档</span>','2022-12-22 15:52:08');
/*!40000 ALTER TABLE `iapp_doc_book` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-12-22 16:52:07
