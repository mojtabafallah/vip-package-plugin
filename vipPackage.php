<?php
/*
Plugin Name: VIP Package
Plugin URI:
Description: این پلاگین برای سطح بندی کاربران برای دانلود محصولات می باشد
Author: MR W01F
Version: 1.0.0
Author URI: https://github.com/mojtabafallah13/
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_role("vip1",
    "سطح اول");
add_role("vip2",
    "سطح دوم");
add_role("vip3",
    "سطح سوم");
include "app/metabox/level-product.php";