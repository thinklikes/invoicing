-- phpMyAdmin SQL Dump
-- version 4.7.0-dev
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2016 at 10:00 AM
-- Server version: 5.7.12
-- PHP Version: 7.0.5-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taiwan`
--

-- --------------------------------------------------------

--
-- Table structure for table `addressbook`
--

CREATE TABLE `addressbook` (
  `no` int(5) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名稱',
  `tel_1` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '電話一',
  `tel_2` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '電話二',
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '手機',
  `fax` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '傳真',
  `remark` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '備註',
  `status` int(2) NOT NULL COMMENT '1:傑瑀2:高雄大容3:台北大容4:台中大容5:國群6:國貿局7:網路公司8:公會9:檢驗局'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tb`
--

CREATE TABLE `admin_tb` (
  `ad_id` int(10) NOT NULL,
  `ad_account` varchar(50) NOT NULL,
  `ad_pw` varchar(60) NOT NULL,
  `ad_name` varchar(50) NOT NULL COMMENT '姓名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_tb`
--

INSERT INTO `admin_tb` (`ad_id`, `ad_account`, `ad_pw`, `ad_name`) VALUES
(1, 'taiwan', '$2y$10$LZxJXXuofi3u5o0KArqyp.vekneIHdNaUJmbXZRgjZIMJtVrRvPH.', '台灣帳號'),
(2, 'admin', '$2y$10$EN879lNDgVuddqbnhOV0sODzMYo9iavKogvqd6tbGDCAQ3zMRGj/K', '管理員'),
(3, 'joy', '$2y$10$LZxJXXuofi3u5o0KArqyp.vekneIHdNaUJmbXZRgjZIMJtVrRvPH.', '喬伊');

-- --------------------------------------------------------

--
-- Table structure for table `admsetup`
--

CREATE TABLE `admsetup` (
  `auto_id` int(5) NOT NULL,
  `system_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '系統名稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admsetup`
--

INSERT INTO `admsetup` (`auto_id`, `system_name`) VALUES
(1, '顧客關係管理系統');

-- --------------------------------------------------------

--
-- Table structure for table `approval_code`
--

CREATE TABLE `approval_code` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL,
  `date` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '重取授權碼之原因',
  `check_result` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '檢查結果',
  `operator` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '處理人員',
  `cost_YN` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0' COMMENT '是否收費',
  `cost` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '收費金額',
  `soft_type` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '軟體種類',
  `machine_code` char(4) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '機器碼',
  `app_code` char(13) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '授權碼',
  `hardware_con` int(1) NOT NULL DEFAULT '1' COMMENT '1:有硬體合約0:軟體'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='授權碼';

--
-- Dumping data for table `approval_code`
--

INSERT INTO `approval_code` (`no`, `c_id`, `date`, `reason`, `check_result`, `operator`, `cost_YN`, `cost`, `soft_type`, `machine_code`, `app_code`, `hardware_con`) VALUES
(1, 1, '1050315', '電腦損壞', '更新後正常', '管理員', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `assess`
--

CREATE TABLE `assess` (
  `assess_id` int(50) NOT NULL,
  `assess_company` varchar(50) NOT NULL,
  `assess_product` varchar(50) NOT NULL,
  `assess_class` varchar(50) NOT NULL,
  `assess_price` int(20) NOT NULL,
  `assess_discount` int(20) NOT NULL,
  `assess_cost` int(20) NOT NULL,
  `assess_style` int(20) NOT NULL,
  `assess_pchome` int(20) NOT NULL,
  `assess_yahoo` int(20) NOT NULL,
  `assess_taobao` int(20) NOT NULL,
  `assess_tmall` int(20) NOT NULL,
  `assess_dangdang` int(20) NOT NULL,
  `assess_jd` int(20) NOT NULL,
  `assess_added` varchar(10) NOT NULL,
  `assess_develop` varchar(10) NOT NULL,
  `assess_parity` varchar(10) NOT NULL,
  `assess_chen` varchar(10) NOT NULL,
  `assess_liu` varchar(10) NOT NULL,
  `assess_comment` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assess`
--

INSERT INTO `assess` (`assess_id`, `assess_company`, `assess_product`, `assess_class`, `assess_price`, `assess_discount`, `assess_cost`, `assess_style`, `assess_pchome`, `assess_yahoo`, `assess_taobao`, `assess_tmall`, `assess_dangdang`, `assess_jd`, `assess_added`, `assess_develop`, `assess_parity`, `assess_chen`, `assess_liu`, `assess_comment`) VALUES
(1, '晁邦國際', '66666', '美食特產(茶/飲料)', 123, 9999, 132, 9999, 123, 123, 9999, 13, 5465, 4, '否', '陳盈蓉', '陳盈蓉', '否', '否', '84');

-- --------------------------------------------------------

--
-- Table structure for table `company_system`
--

CREATE TABLE `company_system` (
  `auto_id` int(50) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `mailbox` varchar(5) DEFAULT NULL COMMENT '郵箱NO',
  `company_abb` varchar(20) NOT NULL COMMENT '公司簡稱',
  `company_contact` varchar(30) NOT NULL COMMENT '聯絡人',
  `company_con_tel` varchar(15) DEFAULT NULL COMMENT '聯絡人電話',
  `company_con_email` varchar(50) DEFAULT NULL COMMENT '聯絡人信箱',
  `company_con_fax` varchar(15) DEFAULT NULL COMMENT '聯絡人傳真',
  `company_tel` varchar(15) DEFAULT NULL COMMENT '公司電話',
  `company_fax` varchar(15) DEFAULT NULL COMMENT '公司傳真',
  `company_add` varchar(100) DEFAULT NULL COMMENT '公司地址',
  `VTA_NO` int(8) NOT NULL COMMENT '統一編號',
  `internet_phone` varchar(12) NOT NULL COMMENT '網路電話號碼',
  `company_remark` varchar(200) DEFAULT NULL COMMENT '公司備註',
  `company_status` int(1) NOT NULL DEFAULT '1' COMMENT '1:購買2:租用3:不使用'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company_system`
--

INSERT INTO `company_system` (`auto_id`, `company_name`, `mailbox`, `company_abb`, `company_contact`, `company_con_tel`, `company_con_email`, `company_con_fax`, `company_tel`, `company_fax`, `company_add`, `VTA_NO`, `internet_phone`, `company_remark`, `company_status`) VALUES
(1, '一德報關有限公司', '121', '一德', '顏s-7956', '231-5341', 'itcb.it121@msa.hinet.net', '', '231-5341', '201-9321', '高雄市苓雅區海邊路46號9F-5', 22254920, '1234-987-654', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_service`
--

CREATE TABLE `customer_service` (
  `auto_id` int(50) NOT NULL,
  `customer_time` datetime NOT NULL,
  `customer_id` int(50) NOT NULL,
  `customer_ser` varchar(50) NOT NULL,
  `customer_mode` varchar(50) NOT NULL,
  `customer_contact` varchar(500) NOT NULL,
  `customer_how` varchar(500) NOT NULL,
  `customer_boss` varchar(50) NOT NULL,
  `customer_close` varchar(50) NOT NULL,
  `customer_comment` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer_service`
--

INSERT INTO `customer_service` (`auto_id`, `customer_time`, `customer_id`, `customer_ser`, `customer_mode`, `customer_contact`, `customer_how`, `customer_boss`, `customer_close`, `customer_comment`) VALUES
(152, '2013-12-04 09:55:14', 1, '林昀芊', 'E-mail', ' 康兒喜有詢問幾點問題:\r\n1.	台魅網的標價是否已確定:回答對方台魅網價錢已確定\r\n2.	他請我們上康兒喜官網註冊會員，以利爾後下單訂購標價的建立。\r\n3.	他詢問上週公司通知LINE帳號建立….等相關問題\r\n\r\n原始信件內容如下:\r\n林小姐您好：\r\n您附件中的價位與上次給的不同，是否已經確定為最後標價？我的附件已按照您這次的標價，重新標定康兒喜官網建議售價，煩請您確認後與我聯繫。\r\n另外請您盡快上康兒喜官網註冊會員，讓我能進行您的等級修改，以利爾後您下單訂購標價的建立。\r\n還有上週貴公司通知LINE帳號建立，我已MAIL給您連結ID，但至今尚無加好友訊息，也無人再與我聯繫，可有專門負責人員處裡？是趙先生？高小姐？還是您呢？若不是趙先生的話，最好是能提供給我負責人員的行動電話，好讓我能即時聯繫，我的電話：0915579001，煩請您與我聯繫。感謝您。\r\n\r\n', '已發信告知廠商台魅網價錢為確定價格。\r\n客服部已經上康兒喜官網註冊', '', '否', ''),
(153, '2014-01-07 08:05:41', 0, '趙禹誠', 'E-mail', '電子報錯誤內容如下:\r\n1.	第五項商品-台灣頂級手採茶葉組連結的商品網頁錯誤。\r\n2.	第七項商品-康喜佑而高優質奶粉連結的商品為12罐裝的網頁而非3罐裝的網頁\r\n3.	第八項商品-屏科大薄鹽醬油連結的商品網頁錯誤。\r\n', '已寄發信件給劉總處理', '', '是', ''),
(154, '2014-01-09 17:55:58', 0, '趙禹誠', 'E-mail', '因商品缺貨，因而延後出貨時間\r\n回應方式:由于农历年前厂商供货紧张，故蜂蜜花粉寒天目前缺货中，商品预计1月21日出货，适逢年节期间物流已无送货，预计商品到达您府上时间为2月8日或2月10日，请问李先生是否愿意等待，或需要改订其他商品', '已先確認亞奇米無相同之商品，並於網站上尋找相同產品替代，尋問運費與送達時間，但無適合替代的相同商品，於是已寄發信件給劉總，尋問解決方法，並寄信件告知客戶，是否願意等待，或改訂其它商品\r\n', '', '否', '等候客戶回應中'),
(155, '2014-01-09 16:29:18', 1, '蔡曉凌', 'E-mail', '商品名称:優雅紳士通勤大禮包 商品编号:A0108000005\r\n是有两个箱包还是一个箱包？ \r\n', '您好，关于您询问的问题\r\n优雅绅士通勤大礼包是内容物有\r\n一、19吋拉杆旅行箱＊１个（颜色随机出货）\r\n二、商务休闲电脑包＊１个\r\n\r\n以上是本网站针对您的问题所回覆的答覆，谢谢您的询问\r\n若有任何疑问欢迎再来信询问，祝您购物愉快，谢谢!!\r\n', '', '否', '寄E-mail詢問'),
(156, '2014-01-29 10:05:17', 1, '沈怡雯', 'Phone', '廠商晁邦因運費未確認，故商品無法上架。', '已多次詢問晁邦運費金額，並告知無運費商品將無法上架，由於晁邦無法立刻回應，於是將其商品下架，等候晁邦回應。', '', '否', ''),
(157, '2014-02-17 16:34:50', 1, '郭倩瑜', 'E-mail', '東西太貴了!沒競爭優勢!', '您好，本網站的商品價格已含運送至大陸的運費，請問哪些商品價格您覺得太貴？我們可以依您的需求來討論，謝謝。', '', '是', ''),
(158, '2014-02-17 16:36:18', 1, '郭倩瑜', 'E-mail', '什么东西吗,贵得要死,', '您好，本網站的商品價格已含運送至大陸的運費，請問哪些商品價格您覺得太貴？我們可以依您的需求來討論，謝謝。', '', '是', ''),
(159, '2014-02-21 17:15:11', 1, '沈怡雯', 'E-mail', '李炎先生反應商品價格  真的贵吗', '先將本網站產品進行比價，並製成比價表後，於留言板回應李炎先生如下:\r\n您好，本網站的商品均為台灣製造生產，目前網站價格已含運送至大陸的運費，同質商品做以下的比價給您參考，\r\n台灣花草巫婆美腿大作戰花草茶12入 \r\n台灣魅力網商品網址 http://t.cn/8F8VSiK\r\n天貓商品網址 http://t.cn/8F8V96t\r\n全球購商品網址 http://t.cn/8F8VCa9\r\n異質商品做以下的比價給您參考，\r\n頂級高山手採金萱茶(半斤)300g\r\n台灣魅力網商品網址 http://t.cn/8F8Vhr7\r\n京東商品網址 http://t.cn/8F8VL00\r\n淘寶商品網址 http://t.cn/8F8VbGe\r\n天貓商品網址 http://t.cn/8F8Vq4J\r\n以上相關資料已mail一份給您做參考，謝謝您的提問。', '', '是', ''),
(160, '2014-02-21 17:23:36', 1, '林昀芊', 'Wechat', '客戶透過QQ詢問WE0020F牛樟元氣錠【90 粒/瓶 36g】補貨中，是否可下訂寄送大陸', '首先先詢問客戶需要的確定數量後，電話詢問廠商無現貨需幾天可到貨，廠商確認可到公司之日期，馬上QQ告知客戶可到貨日和運送相關問題，客戶確認沒問題，開放此商品數量讓客戶下單，客戶確認下單後馬上向廠商訂貨，等待廠商商品到貨', '', '是', '客戶透過QQ詢問');

-- --------------------------------------------------------

--
-- Table structure for table `customer_service_2`
--

CREATE TABLE `customer_service_2` (
  `no` int(11) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '客戶編號',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '內容',
  `quote` int(1) DEFAULT NULL COMMENT '是否報價',
  `quote_contact` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '報價內容',
  `cost` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '費用',
  `remark` text COLLATE utf8_unicode_ci COMMENT '備註',
  `operator` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '操作者',
  `in_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '日期',
  `in_time` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '時間',
  `last_operator` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最後修改人',
  `last_date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最後修改日期',
  `last_time` char(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '最後修改時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer_service_2`
--

INSERT INTO `customer_service_2` (`no`, `c_id`, `content`, `quote`, `quote_contact`, `cost`, `remark`, `operator`, `in_date`, `in_time`, `last_operator`, `last_date`, `last_time`) VALUES
(1, 1, '測試hash', 1, '500', '500', '500', '管理員', '1050603', '14:28:26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cust_maintain`
--

CREATE TABLE `cust_maintain` (
  `no` int(11) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '公司編號',
  `soft_end_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '軟約到期日',
  `contract_amount` int(5) NOT NULL COMMENT '合約台數',
  `actual_amount` int(5) NOT NULL COMMENT '實際台數',
  `newcust_end` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '新客戶到期',
  `hardware_end_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '硬約到期日',
  `year` int(3) NOT NULL COMMENT '年度',
  `cost` varchar(7) COLLATE utf8_unicode_ci NOT NULL COMMENT '年度維修費用',
  `send_contract` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '送合約日期',
  `contract` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '已簽約',
  `invoice` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '已送發票',
  `charge` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '收款',
  `remark` text COLLATE utf8_unicode_ci NOT NULL COMMENT '備註'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='維護';

--
-- Dumping data for table `cust_maintain`
--

INSERT INTO `cust_maintain` (`no`, `c_id`, `soft_end_date`, `contract_amount`, `actual_amount`, `newcust_end`, `hardware_end_date`, `year`, `cost`, `send_contract`, `contract`, `invoice`, `charge`, `remark`) VALUES
(1, 0, '1080205', 2, 2, 'asdfsdf', '1070405', 105, '20000', '1050101', '1090404', '1100605', '1100509', 'asdfasdfasfdasdfasdfasdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `cust_no_purchase`
--

CREATE TABLE `cust_no_purchase` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '公司編號',
  `IP_VAT` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '固定IP或統編',
  `before_soft` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '原使用軟體',
  `inst_date` char(9) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '安裝日期',
  `instructor` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '輔導人員'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='未購客戶';

-- --------------------------------------------------------

--
-- Table structure for table `cust_purchase`
--

CREATE TABLE `cust_purchase` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '公司編號',
  `company_status` int(1) NOT NULL COMMENT '廠商使用系統狀態',
  `soft_contract` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT '軟體合約',
  `soft_end_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '軟體合約到期日',
  `hardware_contract` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT '硬體合約',
  `hardware_end_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '硬體合約到期日',
  `buy_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '購買日期',
  `DCS` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DES` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DAS` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DGL` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DCST` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `topdf` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '購PDF轉檔',
  `X501` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `export_file` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '匯出轉檔',
  `py_program` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '汎宇方案',
  `py_offset` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '汎宇方案 抵維護合約',
  `IP_address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '固定IP位置',
  `customs_brokers` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '報關行',
  `cb_com` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司',
  `area` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '轄區',
  `user_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '關貿貿捷用戶代碼',
  `user_pw` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '關貿貿捷密碼',
  `com_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司或連線人之E-MAIL',
  `principal` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '負責人',
  `net` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '網路',
  `inst_date` char(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '安裝日期',
  `before_soft` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '原使用軟體',
  `contract_amount` int(5) DEFAULT NULL COMMENT '合約台數',
  `actual_amount` int(5) DEFAULT NULL COMMENT '實際台數',
  `wan_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '旺旺友聯,環成帳號',
  `wan_pw` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '旺旺友聯,環成密碼',
  `wan_inst_date` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '設定旺旺友聯,程式帳號日期',
  `FDA_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'FDA帳號,X601',
  `remark` text COLLATE utf8_unicode_ci COMMENT '備註',
  `mk_trans` int(1) DEFAULT NULL COMMENT '貿捷用關貿傳輸',
  `EDI_trans` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'EDI傳輸',
  `change_mk_date` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '變更關貿貿捷日期',
  `trans_account` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '關貿(汎宇)貿E網傳送帳號',
  `change_fy_date` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '變更汎宇貿捷日期',
  `customs_clearance_net` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '通關網路',
  `mailbox_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '郵箱代號',
  `mailbox_pw` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '郵箱密碼',
  `addressee_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '收件人代碼'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='已購客戶';

--
-- Dumping data for table `cust_purchase`
--

INSERT INTO `cust_purchase` (`no`, `c_id`, `company_status`, `soft_contract`, `soft_end_date`, `hardware_contract`, `hardware_end_date`, `buy_date`, `DCS`, `DES`, `DAS`, `DGL`, `DCST`, `topdf`, `X501`, `export_file`, `py_program`, `py_offset`, `IP_address`, `customs_brokers`, `cb_com`, `area`, `user_id`, `user_pw`, `com_email`, `principal`, `net`, `inst_date`, `before_soft`, `contract_amount`, `actual_amount`, `wan_id`, `wan_pw`, `wan_inst_date`, `FDA_id`, `remark`, `mk_trans`, `EDI_trans`, `change_mk_date`, `trans_account`, `change_fy_date`, `customs_clearance_net`, `mailbox_code`, `mailbox_pw`, `addressee_code`) VALUES
(1, 1, 1, '', '', '', '', '', '1', '1', '1', '1', '', '', '', '', '', '', '', '1', '', '高雄市', 'tfs0336', '2442', 'itcb.it121@msa.hinet.net', '郭建牣', '關貿,汎宇', '', '', 0, 0, 'TW23331170', '23331170', '', '700221', '', 1, '關貿', '980703', '123456789999', '', '123', '123', '321', '555');

-- --------------------------------------------------------

--
-- Table structure for table `cust_rent`
--

CREATE TABLE `cust_rent` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '客戶編號',
  `7-11` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8_unicode_ci COMMENT '備註',
  `soft_end_date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '軟體合約到期日',
  `rent_start_date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '租用起始日期',
  `DCS` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DES` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DAS` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DGL` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DCST` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `topdf` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '購PDF轉檔',
  `X501` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'X501',
  `export_file` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '博連匯出轉檔',
  `IP_address` char(19) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '固定IP位置',
  `com_email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '公司或連線人之E-MAIL',
  `principal` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '負責人',
  `net` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '網路',
  `inst_date` char(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '安裝日期',
  `before_soft` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '原使用軟體',
  `guan_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '關貿貿捷用戶代碼',
  `guan_pw` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '關貿貿捷密碼',
  `contract_amount` int(5) DEFAULT NULL COMMENT '合約台數',
  `actual_amount` int(5) DEFAULT NULL COMMENT '實際台數',
  `remark_2` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `wan_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '旺旺友聯環成帳號',
  `wan_pw` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '旺旺友聯環成密碼',
  `wan_inst_date` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '設定旺旺友聯程式帳號日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='租用客戶';

-- --------------------------------------------------------

--
-- Table structure for table `das`
--

CREATE TABLE `das` (
  `no` int(11) NOT NULL,
  `c_id` int(5) DEFAULT NULL COMMENT '客戶名稱',
  `version` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '版本',
  `contract_period` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '合約期間',
  `contract_buy` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '購買日期',
  `up_money` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '百年蟲升級費',
  `up_remark` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '升級備註',
  `server_address` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DAS主機位置',
  `server_amount` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DAS台數',
  `remark` text COLLATE utf8_unicode_ci COMMENT '備註說明',
  `contract_YN` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '有無買賣合約',
  `declaration_no` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT '付費修改報單號碼'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='DAS';

-- --------------------------------------------------------

--
-- Table structure for table `export`
--

CREATE TABLE `export` (
  `eid` int(8) NOT NULL,
  `com_id` int(8) NOT NULL COMMENT '客戶編號',
  `platform` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '使用平台',
  `test_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '申請測試帳號日期',
  `VTA` int(8) NOT NULL COMMENT '統編',
  `test_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '測試帳號',
  `certificate_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '憑證帳號',
  `two_way_test` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '雙向測試',
  `three_wat_test` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '三向測試',
  `porg_inst` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '程式安裝',
  `server_OS` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '主機系統',
  `work_station` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '已安裝工作站的電腦名稱',
  `trans_version` int(5) DEFAULT NULL COMMENT '改版內容',
  `trans_version_date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '改版日期',
  `trans_version_note` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '改版備註',
  `table_join` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '新舊table合併',
  `formal_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '申請正式帳號日期',
  `formal_platform` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '正式使用平台',
  `formal_id` int(11) NOT NULL COMMENT '正式帳號',
  `formal_pw` int(11) NOT NULL COMMENT '正式帳號密碼',
  `responsible_offer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '專責人員',
  `responsible_offer_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '專責人員代碼',
  `set_id_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '帳號設定日期',
  `formal_start` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '正式啟用EDI2',
  `test_amount` int(2) NOT NULL COMMENT '測試家數',
  `prog_inst_ok_amou` int(2) NOT NULL COMMENT '程式安裝完成家數',
  `prog_id_ok_amou` int(2) NOT NULL COMMENT '正式帳號設定家數',
  `prog_enable_ok_amou` int(2) NOT NULL COMMENT '正式啟用家數',
  `reward` int(2) NOT NULL COMMENT '符合申請獎勵金資格',
  `all_cust` int(2) NOT NULL COMMENT '全部資格',
  `certificate_extension` int(11) NOT NULL COMMENT '進口測試憑證展延'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='關港貿客戶(出)';

-- --------------------------------------------------------

--
-- Table structure for table `import`
--

CREATE TABLE `import` (
  `i_id` int(8) NOT NULL,
  `com_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '公司名稱',
  `platform` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '使用平台',
  `test_date` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '申請測試帳號日期',
  `VTA` int(8) NOT NULL COMMENT '統編',
  `test_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '測試帳號',
  `prog_inst_date` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '程式安裝',
  `PL-01.08.04` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PL-01.08.04版',
  `PL-01.09.05` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PL-01.09.05版NX601',
  `PL-01.09.06` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PL-01.09.06版車門',
  `PL-01.10.01` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PL-01.10.01',
  `table_join` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT '新舊表格合併'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='關港貿客戶(進)';

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `mid` int(2) NOT NULL,
  `menu_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '選單名稱',
  `menu_class` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'class',
  `menu_url` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '網址'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`mid`, `menu_name`, `menu_class`, `menu_url`) VALUES
(1, '客戶資料管理', 'fa fa-fw fa-user', 'company_system.php'),
(7, '客戶服務資訊', 'fa fa-users', 'customer_service_system.php'),
(8, '更新資料', 'glyphicon glyphicon-level-up', 'update_kao_system.php');

-- --------------------------------------------------------

--
-- Table structure for table `plan_db`
--

CREATE TABLE `plan_db` (
  `auto_id` int(50) NOT NULL,
  `plan_member` varchar(50) NOT NULL,
  `plan_title` varchar(100) NOT NULL,
  `plan_project` varchar(2000) NOT NULL,
  `plan_time` varchar(50) NOT NULL,
  `plan_boss` varchar(50) NOT NULL,
  `plan_added` varchar(50) NOT NULL,
  `plan_comment` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plan_db`
--

INSERT INTO `plan_db` (`auto_id`, `plan_member`, `plan_title`, `plan_project`, `plan_time`, `plan_boss`, `plan_added`, `plan_comment`) VALUES
(21, '高鳳儀', '網路票選人氣伴手禮! 花好茶香禮盒+鳳梨酥', ' 沒吃過這個，別說你認識台灣！\r\n\r\n秒殺【台灣本土鳳梨酥+花草荼養生禮盒】征服你的口腹之慾，絕不妥協！\r\n\r\n年節最喜氣洋洋，自用歡喜，送禮大方，台灣網購秒殺1萬盒的人氣禮盒！！\r\n\r\n　　\r\n\r\n《花香鳳梨酥(桂花+薰衣草+玫瑰+蔓越莓+洛神花)+花草巫婆養生茶(薰衣安神飲+仙橙酸甜飲)\r\n\r\n》\r\n', '2013/11/29-2013/12/29', '', '否', 'BM0070GBM0076G'),
(14, '高鳳儀', '吃了讓你飛上火星休閒點心~ 核桃椰棗+火星糖', '吃了讓您飛上火星最牛休閒點心~核桃椰棗+火星糖  \r\n  \r\n～豐富營養包裹在香脆的核桃椰棗 裡，每一口都是美麗的承諾！\r\n傳說中地球上最好吃的糖果~連火星人都愛吃\r\n\r\n 糖果，是甜蜜與幸福的延伸，而「火星糖」的糖果，不但把幸福具體化，更把好吃的口感以及健康的食材融化在嘴內。「火星糖」只賣一種糖果，卻可以客製化做成各式個性化包裝，因而成為台灣網路受歡迎的訂購小禮。\r\n\r\n    「火星糖」的創辦人周小姐是家庭主婦，會開始做糖果是因為先生喝茶很喜歡配甜點，她想到：「如果能有一種點心是能滿足口慾，又可兼顧健康不知有多好？」因為有了這樣的想法，「火星糖」從此誕生。不添加任何香精、色素的「火星糖」，是以焦糖加上純鮮奶與寒天經過四小時熬煮，再加入自行低溫烘焙的夏威夷豆與杏仁果，創造出有如太妃糖的濃郁口感。但是和太妃糖不同的是，「火星糖」的口感是軟中帶Q不黏牙 ，而且加的完全是天然食材，因此使火星糖成為老少皆喜歡的小點心。\r\n\r\n       除了好吃沒話說，周小姐說：「我們很花心思在禮物包裝上，並為不同的客人做個人需求的訂做，希望讓收到的不僅甜在嘴裡，心也能充滿了滿滿的幸福。」 \r\n', '2013/11/29-2013/12/29', '', '是', ''),
(15, '高鳳儀', '連老外也來搶食的本土點心~核桃椰棗+综合水果乾', '連老外也來搶食的本土點心~核桃椰棗+综合水果乾\r\n\r\n～豐富營養包裹在香脆的核桃椰棗 裡，每一口都是美麗的承諾！\r\n\r\n \r\n\r\n巫婆精心調配計算，魔法比例完美混合，每咬一口都令人驚喜滿足，營養健康零負擔，是全家人都適合的營養零嘴！\r\n 土產零嘴冠車～【台灣鮮果虹園水果乾】！！\r\n聞名中外，連老外也瘋狂團購的台灣本土水果乾，手腳太慢可就搶不到囉!\r\n\r\n給您多重口味(燕巢芭樂/關廟鳳梨/台南玉井芒果/宜蘭黃金棗)一次滿足\r\n', '2013/11/29-2013/12/29', '', '是', 'BM0050GIC0011G'),
(17, '高鳳儀', '台灣秒殺超值組合!!冬戀 珈琲系 禮盒', ' 沒吃過這個，別說你認識台灣！\r\n\r\n秒殺【台灣手工餅乾+魔法椰棗堅果+異國風味波泰尼克咖啡】征服你的口腹之慾，絕不妥協！\r\n\r\n年節最喜氣洋洋，自用歡喜，送禮大方，台灣網購秒殺1萬盒的人氣禮盒！！\r\n', '2013/11/29-2013/12/29', '', '是', 'BM0073G'),
(18, '高鳳儀', '值得等待的好滋味~堅果森林+火星糖', '值得等待的好滋味~堅果森林+火星糖 \r\n \r\n\r\n堅果森林～豐富營養包裹在香脆的堅果裡，每一口都是美麗的承諾！\r\n\r\n \r\n\r\n巫婆精心調配計算，魔法比例完美混合，每咬一口都令人驚喜滿足，營養健康零負擔，是全家人都適合的營養零嘴！ \r\n\r\n傳說中地球上最好吃的糖果~連火星人都愛吃\r\n傳說中地球上最好吃的糖果~連火星人都愛吃\r\n\r\n 糖果，是甜蜜與幸福的延伸，而「火星糖」的糖果，不但把幸福具體化，更把好吃的口感以及健康的食材融化在嘴內。「火星糖」只賣一種糖果，卻可以客製化做成各式個性化包裝，因而成為台灣網路受歡迎的訂購小禮。\r\n\r\n    「火星糖」的創辦人周小姐是家庭主婦，會開始做糖果是因為先生喝茶很喜歡配甜點，她想到：「如果能有一種點心是能滿足口慾，又可兼顧健康不知有多好？」因為有了這樣的想法，「火星糖」從此誕生。不添加任何香精、色素的「火星糖」，是以焦糖加上純鮮奶與寒天經過四小時熬煮，再加入自行低溫烘焙的夏威夷豆與杏仁果，創造出有如太妃糖的濃郁口感。但是和太妃糖不同的是，「火星糖」的口感是軟中帶Q不黏牙 ，而且加的完全是天然食材，因此使火星糖成為老少皆喜歡的小點心。\r\n\r\n       除了好吃沒話說，周小姐說：「我們很花心思在禮物包裝上，並為不同的客人做個人需求的訂做，希望讓收到的不僅甜在嘴裡，心也能充滿了滿滿的幸福。」 \r\n\r\n \r\n', '2013/11/29-2013/12/29', '', '否', 'BM0066GMC0003G'),
(19, '高鳳儀', '季節限定限量禮盒!!秋趣', '  沒吃過這個，別說你認識台灣！\r\n\r\n秒殺【台灣本土鳳梨酥+養身冷泡飲禮盒】征服你的口腹之慾，絕不妥協！\r\n\r\n年節最喜氣洋洋，自用歡喜，送禮大方，台灣網購秒殺1萬盒的人氣禮盒！！\r\n\r\n　　\r\n\r\n《花香鳳梨酥(桂花+薰衣草+玫瑰+蔓越莓+洛神花)～精巧五種口味，挑戰您的味蕾，清爽留香！\r\n\r\n台灣鳳梨酥嬋連人氣網購冠軍已經長達八年時間，台灣各家傳統業者無所不用其極研發新口味以饗老饕，每每為傳統食品藝術加注新鮮元素，創造豐富營養層次，創造口味驚奇！！\r\n\r\n原味的鳳梨酥已經是網購冠軍，業者創新研發《純鮮花草茶》融合原有醇香鳳梨酥的傳統口感，更添加了幸福魔法，讓鳳梨酥一躍登上國際舞台，成為觀光客入境台灣，秒殺不手軟的超人氣首選伴手禮！！\r\n', '2013/11/29-2013/12/29', '', '是', 'BM0072G'),
(20, '高鳳儀', ' 紓壓安定神經,給您一夜好覺 花好茶香禮盒', '《花草巫婆養生茶(神定好眠～薰衣安神飲+消油解膩～仙橙酘甜飲) 》\r\n台灣最潮的新養生主流！', '2013/11/29-2013/12/29', '', '否', 'BM0070G'),
(22, '高鳳儀', '觀光客來台灣必買禮盒~調理茶飲+鳳梨酥', '台灣花草茶擺脫黃臉婆~限量花香鳳梨酥給您幸福好姿味\r\n \r\n秒殺【台灣本土鳳梨酥+花草荼養生禮盒】征服你的口腹之慾，絕不妥協！\r\n\r\n年節最喜氣洋洋，自用歡喜，送禮大方，台灣網購秒殺1萬盒的人氣禮盒！！\r\n\r\n　　\r\n\r\n《花香鳳梨酥(桂花+薰衣草+玫瑰+蔓越莓+洛神花)+花草巫婆養生茶(金盏玫瑰飲+迷迭香茅飲)\r\n\r\n》\r\n', '2013/11/29-2013/12/29', '', '否', 'BM0069GBM0076G'),
(23, '高鳳儀', '加量不加價~紮實的好味道~冷泡飲 玫瑰錫蘭', '有過想喝個茶卻臨時找不到有熱水泡的的窘境?,花草巫婆聽到普羅大眾的心聲了,花草巫婆為此特別推出冷泡式茶飲,無論是上班族、學生、開車族或是登山族，只要有買得到礦泉水，就可以將茶葉置入，靜泡若干個小時後，味道更香醇甘美,任何時光都可以享受既好喝又保健的冷泡茶。\r\n \r\n冷泡茶的好處在於茶葉不會因為高溫而變質，減少單寧酸的釋出，可避免苦澀味的產生並保留原始的甜味。但如果使用原本熱泡的比例，做出的冷泡茶的口感是非常清淡的，想想為何市售冷泡茶能夠不增加重量卻維持相同氣味？花草巫婆不使用取巧的方式，冷泡茶包是市售冷泡茶的1.5倍重，原料嚴選絕不吝嗇，讓冷泡茶也能有紮實的好味道。', '2013/11/29-2013/12/29', '', '否', 'BM0019G'),
(24, '高鳳儀', '加量不加價~紮實的好味道~冷泡飲 檸香梅子', ' 誰規定喝茶一定只能用熱水泡~冷泡飲 檸香梅子\r\n                                                          加量不加價~紮實的好味道\r\n               \r\n有過想喝個茶卻臨時找不到有熱水泡的的窘境?,花草巫婆聽到普羅大眾的心聲了,花草巫婆為此特別推出冷泡式茶飲,無論是上班族、學生、開車族或是登山族，只要有買得到礦泉水，就可以將茶葉置入，靜泡若干個小時後，味道更香醇甘美,任何時光都可以享受既好喝又保健的冷泡茶。\r\n \r\n冷泡茶的好處在於茶葉不會因為高溫而變質，減少單寧酸的釋出，可避免苦澀味的產生並保留原始的甜味。但如果使用原本熱泡的比例，做出的冷泡茶的口感是非常清淡的，想想為何市售冷泡茶能夠不增加重量卻維持相同氣味？花草巫婆不使用取巧的方式，冷泡茶包是市售冷泡茶的1.5倍重，原料嚴選絕不吝嗇，讓冷泡茶也能有紮實的好味道。\r\n \r\n ', '2013/11/29-2013/12/29', '', '否', 'BM0018G'),
(25, '高鳳儀', '花小錢買健康~ㄣㄣ不塞車~讓你甜蜜心花開', '花小錢買健康~ㄣㄣ不塞車~讓你甜蜜心花開\r\n\r\n \r\n\r\n                             你有ㄣㄣ的困擾嗎?除了平時要多攝取食物的千纖維,以及規律的運動外\r\n\r\n                             也可以多補充加有苘香的荼飲,帶有蘋果香味讓您身體輕爽一整天,並可以\r\n\r\n                              幫助腸胃更順暢~~ㄣㄣ不塞車\r\n\r\n \r\n\r\n                                              \r\n', '2013/11/29-2013/12/29', '', '否', 'BM0013GYA0263G'),
(26, '高鳳儀', '台灣最潮的新養生主流~紫蘇甜心甜蜜蜂蜜飲', '台灣最潮的新養生主流~紫蘇甜心甜蜜蜂蜜飲\r\n\r\n                                  清新宜人的紫蘇清香混合薑的味道~ 讓妳在冬天從內到外散發出甜甜的香氣,氣色紅潤起來,助妳當溫暖美人\r\n\r\n                   四季裡，蜜蜂在花叢裡穿梭採蜜，陽光溫暖的灑落大地，風微微的吹著，嗡~嗡聲交織的生命之歌，\r\n\r\n蜂蜜-上天給我們的恩賜，泡一杯蜂蜜飲，我們心懷感恩，感謝大地所賜的禮物；\r\n\r\n或是坐在大樹下，任陽光穿透過樹梢灑落在身上，光的照拂下，喝一杯身心都得到了滿足。\r\n', '2013/11/29-2013/12/29', '', '否', 'BM0007GYA0272G'),
(27, '翟楚雲', '懷舊好滋味~原味魷魚絲(五入)', '记忆中小时候最爱吃的零食，浮现出当年与兄弟姊妹抢著吃的温馨画面，\r\n使用新鲜鱿鱼，反覆的熏烤与火侯的掌握 再加上细心烘焙之后，保留海的原味，是下酒泡茶的最佳良伴。', '2013/12/02-2014/01/02', '', '是', ''),
(28, '翟楚雲', '懷舊好滋味~原味魷魚絲(五入)', '記憶中小時候最愛吃的零食，浮現出當年與兄弟姊妹搶著吃的溫馨畫面，\r\n使用新鮮魷魚，反覆的燻烤與火侯的掌握 再加上細心烘焙之後，保留海的原味，是下酒泡茶的最佳良伴。', '2013/12/02-2013/12/02', '', '是', ''),
(29, '翟楚雲', '茶韻回甘一整天 台灣手採烏龍茶禮盒組(三入)', '茶韻回甘一整天 台灣手採烏龍茶禮盒組(三入)\r\n \r\n●純正台灣在地好茶\r\n●香氣清香持久，茶湯明亮見底\r\n●採用PET網無毒無菌三角立體茶包\r\n\r\n「茶者，南方嘉木也」唐代茶聖陸羽說的第一句話,茶經是第一本關於茶的書籍,內容討論茶的歷史,茶的器具,製茶過程,後世茶農繼承了茶經精神，繼續發展茶道文化。\r\n\r\n現代人隨著生活品質的提高,已由飲茶提升到品茶,喝茶是一種精神享受,也是一種藝術,茶不單單只是飲品,是生活上的一種態度,不僅能修身養性,靜心,產生定力。\r\n\r\n茶之鄉-松柏嶺\r\n松柏嶺,有茶葉王國之稱,是茶園最密集的地區,位居在八卦山海拔約500公尺的南投縣名間鄉,舊名為松柏坑,有特殊的地形、氣候以及紅色土壤,造就了最適合的栽種茶葉的環境。\r\n\r\n商品介紹\r\n採自台灣南投縣松柏嶺烏龍茶，品質優異，散發淡淡茶香，口感甜潤滑順，茶湯呈明亮的金黃色，耐泡性佳，多次沖泡依然甘醇芬芳。\r\n\r\n茶包的外觀設計有如粽子一般，採用PET網無毒無菌、堅韌耐用、兼具耐高溫特特性，交錯的四個角在沖泡熱水時完全挺起，讓立體茶包裡的原片茶葉能夠完全舒展，釋出清澈高品質的茶湯，比一般市售的平裝茶包所釋出的茶湯品質好上很多。\r\n\r\n商品規格\r\n禮盒規格:4兩三入禮盒\r\n禮盒尺寸:長:31.6X寬:17.4X高:7.8(cm)\r\n提袋尺寸:正寬33.5X側寬:8.4X高:20.2(cm)\r\n裝箱數量:三入(一盒20包)\r\n茶包類型:三角立體茶包\r\n紙箱尺寸:長:75X寬:41X高:47(cm)\r\n', '', '', '否', ''),
(30, '翟楚雲', '冬季保養最佳選擇 薰衣草手製皂(6入)', '洗淨你的遍體鱗傷！競爭的年代生活如戰場，忙錄已經是家常便飯，唯有洗澡的靜謐時光，得以安然自處撫慰療傷。你的身體需要更溫柔的元素，每一個滑溜的瞬間撫觸，都成繞指柔；即便是鎩羽而歸，有了這塊精緻滑嫩的手工香皂，澡堂也可以變成淨化心靈的天堂。', '', '', '否', 'ON0003C'),
(31, '翟楚雲', '冬季保養最佳選擇 薰衣草植萃經典禮盒組', '一年四季當中，冬季是最需要保養的季節，頭皮的保養是\r\n更不能疏忽掉的，薰衣草植萃的洗髮露，能滋養秀髮及頭皮，強健髮質，使秀髮光澤亮麗，再搭配ACO&USDA有機認證薰衣草精油，舒緩你的精氣神，還有乳油木果薰衣草護唇膏，有效紓緩外在環境對嬌嫩敏感的唇部肌膚所造成的傷害，保護雙唇柔軟健康。', '', '', '否', 'ON0001F'),
(32, '翟楚雲', '冬季保養最佳選擇 薰衣草乳油木果唇蜜(6入)', '在冬天裡，肌膚最怕的殺手就是乾燥，嘴唇也會因此遇到天氣的變化受到傷害，所以我們建議使用薰衣草乳油木果唇蜜來保護我們雙唇，有效長時間滋潤保濕，防止水份流失，展現唇部肌膚柔嫩水亮，給您的雙唇無時無刻的細緻呵護。', '', '', '否', 'ON0010F'),
(33, '翟楚雲', '冬季保養最佳選擇 白皙水煮肌雙面膜組', '冬季的來臨，必須給肌膚最好的享受，世上只有懶女人沒有醜女人，一片全效！滿足妳的全方位美肌需求，每敷一次面膜，就等於做完一次完整的臉部護理，白皙淡斑、緊緻修護、高效保濕，讓臉部肌膚每天就像喝下20大杯水，天天敷天天水嫩，還你白皙的水煮肌。 ', '', '', '否', 'ON0033ITJ0009I'),
(34, '翟楚雲', '冬季保養最佳選擇 檜純沐浴露(600ml/瓶)', '冬天洗澡不怕肌膚乾巴巴，溫和洗淨你一整天的疲勞，添加二次精萃檜木精油，含檜木醇的舒緩效果，使你的肌膚完全放鬆於沐浴之中，釋放身體的勞累，宛如專業spa級的高級享受，不管是洗手、洗臉、洗澡皆適用，隨時讓你保持肌膚永久的水嫩感，還原嬰兒般的肌膚。', '', '', '否', 'BG0003C'),
(35, '翟楚雲', '冬季保養最佳選擇 Reavivar牛樟芝頂級面膜 - 一盒五片', '貴婦級的私房養生面膜！打造冬季水潤肌，再豁達的女人都沒辦法坦然面對自己臉上的皺紋，科技上的進步，帶給我們對抗衰老的機會，保養、抗老、緊致、滋養一次搞定，讓你成為凍齡美魔女!', '', '', '否', 'IF0026I'),
(36, '翟楚雲', '冬季保養最佳選擇 蜂王乳精養生保健(1盒30包)', '冬季的來臨，是流行性感冒的盛期，除了外在的保養，平時我們也要注意到身體內在的需求，增強體力，是現代繁忙人重要的需求，最適合上班族，三餐外食族，每天一包，神采奕奕，元氣滿分，隨時保持身體的健康,不受疾病打敗!', '', '', '否', 'IF0006G'),
(37, '翟楚雲', '冬季保養最佳選擇 蜂蜜醋飲組', '蜜蜂勤奮的工作，飛來飛去，來回數萬次，採集累積花朵的精華；辛勞的蜂農，於花朵盛開的季節，帶著蜜蜂們，逐蜜而居。點滴付出，將大自然的美味傳達出來，只為您精釀出最高品質的台灣蜂蜜！', '', '', '否', 'YA0274GYA0273G'),
(38, '翟楚雲', '冬季保養最佳選擇 玫瑰四物黑糖(300g/包)*10包', '冬天來一碗熱呼呼的四物黑糖水，彷彿雪中送炭，溫暖心頭，是人生的一大享受，幫助女性朋友體質，養顏美容，無論是直接食用或沖飲，都有絕妙的口感，讓身體平衡順暢，輕鬆擁有最佳的好氣色，永遠年輕青春好活力！', '', '', '否', 'YA0006G'),
(39, '翟楚雲', '冬季保養最佳選擇 熱敷袋 - 好窩心', '總是一個人孤單的過著冬季嗎?寒冷時卻不知道如何取暖?好窩心熱敷袋是你最好的陪伴，不只溫暖您的身體，愛心的造型更能夠撫慰您的心靈，由100%纯棉和100%天然榖物製成，使用前只需微波加熱1~2分鐘，快速又方便，是居家必備的保暖商品。', '', '', '否', 'SC0008C'),
(40, '翟楚雲', '喝出在地好味道 精選特級阿里山烏龍茶', '「茶者，南方嘉木也」唐代茶聖陸羽說的第一句話,茶經是第一本關於茶的書籍,內容討論茶的歷史,茶的器具,製茶過程,後世茶農繼承了茶經精神，繼續發展茶道文化。\r\n現代人隨著生活品質的提高,已由飲茶提升到品茶,喝茶是一種精神享受,也是一種藝術,茶不單單只是飲品,是生活上的一種態度,不僅能修身養性,靜心,產生定力。', '', '', '否', ''),
(41, '翟楚雲', '台灣魅力過年歡慶特賣-嚴選手作餅乾', '花草巫婆餅乾系列:\r\n網站售價122RMB.成本72.7RMB 市價119.1RMB\r\n部分特價99 RMB\r\n每日隨機選一項80RMB\r\n愛麗絲手工餅乾:\r\n網站售價69RMB 成本28.7RMB 市價63.6\r\n部分特價49RMB\r\n', '2014/01/06-2014/1/12', '', '否', ''),
(42, '詹立正', '2月開心上工有朝氣企劃-第一週', '優雅上班有精神-咖啡&茶\r\n花好茶香礼盒:234\r\n华陀雪莲花茶 30入:86\r\n洋甘菊‧薄荷‧薰衣草:74\r\n栀子花即溶咖啡88\r\n栗子即溶咖啡:89\r\n绝色洛神花草茶共四盒:181\r\n粉红玫瑰花草茶共四盒:181\r\n华陀十二味茶饮 30入:110\r\n东山特调滤泡式咖啡:92\r\n每項折價去尾數+1(234=>229)\r\n為期一週\r\n\r\n', '2014/02/5-2014/02/14', '', '否', ''),
(43, '詹立正', '2月開心上工有朝氣企劃-第二週', '魅力上班有人氣-美容保養品\r\n 美浓蕴玉-眼霜精华面膜礼盒:500\r\n 天根草典 微米黄金箔面膜:245\r\n 全方位机能保湿水(玫瑰):71\r\n 肌因修护精萃:205 \r\n 赋活亮眼凝胶:236\r\n 优白醒肤面膜:286\r\n 轻透晶灿防晒霜:185\r\n 天根草典 柔敏修护面膜:124\r\n 天根草典 胶原蛋白面膜:124\r\n ', '2014/02/14-2014/02/21', '', '否', ''),
(44, '詹立正', '2月開心上工有朝氣企劃-第三週', '健康上班有活力-養生健康食品\r\n天赏极品珍珠燕窝6入:312\r\n华陀原支圆片花旗蔘茶20入:155\r\n美人计美丽元珍珠胶囊 120入:209\r\n美人计活性珍珠粉 90入:259\r\n华陀龙悦鹿茸精胶囊 30入:305\r\nvijin纯纤粹轻盈草本茶 20入:88\r\nvijin纯纤粹美体玫瑰茶 20入:88\r\n美人计青木瓜雪蛤四物铁饮6入:121\r\n英发 蜂王乳精养生保健:374\r\n每項折價去尾數+1(234=>229) 為期一週', '2014/02/21-2014/02/28', '', '否', ''),
(45, '詹立正', '三月婦女節-媽媽寶貝開心購-第四週', '寶寶奶粉\r\n新一代全家福奶粉，守护全家超健康(单罐装)\r\n高优质羊奶粉(1罐装)\r\n稳利固体素(凤梨口味)1罐装\r\n爹地妈咪我要快乐长大~羊奶米胚(1罐装)\r\n稳利固体素(香草口味)单罐\r\n高优质儿童营养强化奶粉(一箱6罐)\r\n新手爸妈抢奶粉!!高优质成长奶粉(1罐超大1600g)\r\n奶瓶清洁剂~奶瓶清洁好乾净(单盒装)\r\n宝宝泡泡好开心~酵素沐浴剂（薰衣草)\r\n滿三百送一百元折價券(限定折價比率10%.活動期間內使用)', '2014/03/24-2014/03/31', '', '是', ''),
(46, '詹立正', '三月婦女節-媽媽寶貝開心購-第三週', '美人珍珠戴滿身-珍珠首飾\r\n爱情物语桃花粉晶手鍊-珍珠\r\n爱情物语桃花粉晶手鍊-垂鍊(珍珠白)\r\n爱情物语简约黑玛瑙耳环-低调\r\n爱情物语气质珍珠耳环-粉贝双心\r\n爱你美梦成真(黑珍珠)\r\n心手相携 手鍊\r\n爱情物语简约黑玛瑙手鍊-低调\r\n爱情物语桃花粉晶项鍊-珊瑚\r\n爱情物语气质珍珠手鍊-珍珠(金)\r\n滿三百送一百元折價券(限定折價比率10%.活動期間內使用)', '2014/03/23-2014/03/17', '', '是', ''),
(47, '詹立正', '三月婦女節-媽媽寶貝開心購-第二週', '精品甜點甜蜜蜜\r\n可可牛奶手工饼乾 (大盒)\r\n芝麻配手工饼乾 (大盒)\r\n杏仁角手工饼乾(大盒)\r\n锡兰红茶手工饼乾 (大盒)\r\n牛轧糖礼盒\r\n送礼超值首选~果漾酥长礼盒(综合)\r\n果漾酥长礼盒(原味凤梨*8)\r\n奶香酥饼手工饼乾-大罐200g\r\n巧克力酥饼手工饼乾-大罐200g\r\n 滿三百送一百元折價券(限定折價比率10%.活動期間內使用)', '2014/03/7-2014/03/14', '', '是', ''),
(48, '詹立正', '三月婦女節-媽媽寶貝開心購-第 一週', '開心保養美麗活\r\nPhycos凡蔻斯 藻红光合BB霜\r\nPhycos凡蔻斯 藻红光合晶漾露\r\n凡蔻斯FU-3 藻旋肽极致羽丝缕面膜\r\nAqua Angelus 梦幻仙境双色眼影(芭比粉, 深海蓝)\r\nAqua Angelus 星鑚璀璨晶盈唇蜜(公主甜心粉)\r\n杏仁酸醒肤凝胶\r\n轻透晶灿防晒霜\r\n赋活亮眼凝胶\r\n美浓蕴玉-眼霜精华面膜礼盒\r\n滿三百送一百元折價券(限定折價比率10%.活動期間內使用)', '2014/03/1-2014/03/07', '', '是', '');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `no` int(5) NOT NULL,
  `school_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '學校名稱',
  `school_contact` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡人',
  `contact_tel` varchar(12) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡人電話',
  `contact_email` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '聯絡人信箱',
  `VTA` int(8) NOT NULL COMMENT '統一編號',
  `school_addr` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '地址',
  `inst_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '安裝日期',
  `acceptance_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '驗收日期',
  `buy_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '購買日期',
  `contract` int(1) NOT NULL COMMENT '合約書',
  `buy_amount` int(4) NOT NULL COMMENT '購買套數',
  `classroom` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '安裝教室',
  `maintain_start` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '保固期間起',
  `maintain_end` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '保固期間迄',
  `soft_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '軟體名稱',
  `remark` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '備註'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='學校';

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `a` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `b` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trans_version`
--

CREATE TABLE `trans_version` (
  `v_id` int(5) NOT NULL,
  `trans_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '改版名稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='改版記錄名稱';

--
-- Dumping data for table `trans_version`
--

INSERT INTO `trans_version` (`v_id`, `trans_name`) VALUES
(1, '改版(一)'),
(2, '改版(二)'),
(3, '6/29說明會'),
(4, '改版(三)'),
(5, '改版(四)'),
(6, '改版(五)'),
(7, '改版(六)'),
(8, '改版(七)'),
(9, '改版(八)'),
(10, 'PL20版'),
(11, 'PL-22版(配合9/16版以上)'),
(12, 'PL-23版(配合9/18版以上)'),
(13, '更新N5203底圖'),
(14, 'PL-24版(配合???版以上)'),
(15, 'PL-01.02.01版(103.12.31前更新)'),
(16, 'PL-01.04.01版');

-- --------------------------------------------------------

--
-- Table structure for table `update_kao`
--

CREATE TABLE `update_kao` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '客戶編號',
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '版本',
  `version_remark` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `memo` varchar(7) COLLATE utf8_unicode_ci NOT NULL COMMENT 'memo',
  `ocean_out` int(1) DEFAULT NULL COMMENT '海運出口',
  `ocean_in` int(1) DEFAULT NULL COMMENT '海運進口',
  `air_out` int(1) DEFAULT NULL COMMENT '空運出口',
  `air_in` int(1) DEFAULT NULL COMMENT '空運進口',
  `transport` int(1) DEFAULT NULL COMMENT '轉運',
  `X101` int(1) DEFAULT NULL,
  `X201` int(1) DEFAULT NULL,
  `X301` int(1) DEFAULT NULL,
  `X301_DN` int(1) DEFAULT NULL,
  `X401` int(1) DEFAULT NULL,
  `X501` int(1) DEFAULT NULL,
  `X601` int(1) DEFAULT NULL,
  `X603` int(1) DEFAULT NULL,
  `car` int(1) DEFAULT NULL COMMENT '車運',
  `application` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '通知申請簽審憑證',
  `voucher_2_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '簽審憑證測試日期雙向',
  `voucher_3_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '簽審憑證測試日期三向',
  `voucher_ok_date` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '簽審憑證核准日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='更新資料_高雄';

-- --------------------------------------------------------

--
-- Table structure for table `update_nan`
--

CREATE TABLE `update_nan` (
  `no` int(8) NOT NULL,
  `c_id` int(8) NOT NULL COMMENT '客戶編號',
  `version` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '版本',
  `memo` varchar(7) COLLATE utf8_unicode_ci NOT NULL COMMENT 'memo',
  `pp_update` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'PORT更新日期',
  `PP_X101_CCCODE` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT '產證X101 CCCODE',
  `X301_update` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'X301檢驗 更新日期',
  `trade_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '國貿局驗證碼',
  `bug_update` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '百年蟲更新日期',
  `bug_cost` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT '百年蟲收費X有軟硬約',
  `X601` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'X601 食品檢驗',
  `hardware_end` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '硬體到期日',
  `X101_ECFA` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'X101-ECFA',
  `DAS_MYSQL` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'DAS MYSQL',
  `revision` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'DAS_MYSQL改版',
  `X101_ECFA_5` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'X101-ECFA 100.03.24 五都更新 國貿局網址',
  `luxury_tax_rev` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '奢侈稅改版',
  `sum_sub` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '應加減費用改為SHOW 0',
  `X101_ECFA_PP_rev` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT 'X101-ECFA 產證改版',
  `remark` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='更新資料_台南';

-- --------------------------------------------------------

--
-- Table structure for table `update_version`
--

CREATE TABLE `update_version` (
  `no` int(11) NOT NULL,
  `c_id` int(8) NOT NULL,
  `pro_permit_update` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '產證更新日期',
  `pro_permit_version` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '產證版本eTrade',
  `program_version` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '程式版本DES',
  `updateEDI` int(1) DEFAULT NULL COMMENT '已更新EDI',
  `updateEDI_date` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '已更新EDI日期',
  `newEDI` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '新EDI版本 DCSEDI(首)',
  `ocean` int(1) DEFAULT NULL COMMENT '海運',
  `air` int(1) DEFAULT NULL COMMENT '空運',
  `DES` int(1) DEFAULT NULL COMMENT 'MYSQL_DCS',
  `DAS` int(1) DEFAULT NULL COMMENT 'MYSQL_DAS',
  `DAS_insdate` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DAS安裝日期',
  `DAS_ver` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DAS 版本',
  `DGL_insdate` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DGL 安裝日期',
  `DGL_ver` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'DGL 版本',
  `D33_edit` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'D33 FORM修改',
  `place` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'K:高雄N:台南'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='版本更新';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addressbook`
--
ALTER TABLE `addressbook`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `admin_tb`
--
ALTER TABLE `admin_tb`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `admsetup`
--
ALTER TABLE `admsetup`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `approval_code`
--
ALTER TABLE `approval_code`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `assess`
--
ALTER TABLE `assess`
  ADD PRIMARY KEY (`assess_id`);

--
-- Indexes for table `company_system`
--
ALTER TABLE `company_system`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `customer_service`
--
ALTER TABLE `customer_service`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `customer_service_2`
--
ALTER TABLE `customer_service_2`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `cust_maintain`
--
ALTER TABLE `cust_maintain`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `cust_no_purchase`
--
ALTER TABLE `cust_no_purchase`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `cust_purchase`
--
ALTER TABLE `cust_purchase`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `cust_rent`
--
ALTER TABLE `cust_rent`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `das`
--
ALTER TABLE `das`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `export`
--
ALTER TABLE `export`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `import`
--
ALTER TABLE `import`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `plan_db`
--
ALTER TABLE `plan_db`
  ADD PRIMARY KEY (`auto_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `trans_version`
--
ALTER TABLE `trans_version`
  ADD PRIMARY KEY (`v_id`);

--
-- Indexes for table `update_kao`
--
ALTER TABLE `update_kao`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `update_nan`
--
ALTER TABLE `update_nan`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `update_version`
--
ALTER TABLE `update_version`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addressbook`
--
ALTER TABLE `addressbook`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_tb`
--
ALTER TABLE `admin_tb`
  MODIFY `ad_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `admsetup`
--
ALTER TABLE `admsetup`
  MODIFY `auto_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `approval_code`
--
ALTER TABLE `approval_code`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `assess`
--
ALTER TABLE `assess`
  MODIFY `assess_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `company_system`
--
ALTER TABLE `company_system`
  MODIFY `auto_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `customer_service`
--
ALTER TABLE `customer_service`
  MODIFY `auto_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `customer_service_2`
--
ALTER TABLE `customer_service_2`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cust_maintain`
--
ALTER TABLE `cust_maintain`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cust_no_purchase`
--
ALTER TABLE `cust_no_purchase`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cust_purchase`
--
ALTER TABLE `cust_purchase`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cust_rent`
--
ALTER TABLE `cust_rent`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `das`
--
ALTER TABLE `das`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `export`
--
ALTER TABLE `export`
  MODIFY `eid` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `import`
--
ALTER TABLE `import`
  MODIFY `i_id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `mid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `plan_db`
--
ALTER TABLE `plan_db`
  MODIFY `auto_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trans_version`
--
ALTER TABLE `trans_version`
  MODIFY `v_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `update_kao`
--
ALTER TABLE `update_kao`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `update_nan`
--
ALTER TABLE `update_nan`
  MODIFY `no` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `update_version`
--
ALTER TABLE `update_version`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
