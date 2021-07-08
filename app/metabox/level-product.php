<?php
function vip_add_meta_product()
{
    add_meta_box("vip-product", 'درجه این محصول', function () {
        include "views/v-level-product.php";
    },
        'product');
}

add_action('add_meta_boxes', 'vip_add_meta_product');


add_action('save_post_product', 'action_save_product_data', 20);
function action_save_product_data($post_id)
{
    if (isset($_POST['level-product'])) {
        update_post_meta($post_id, 'vip-level', $_POST['level-product']);
    }
}

add_filter('woocommerce_loop_add_to_cart_link', 'ybc_shop_before_after_btn', 10, 3);

function ybc_shop_before_after_btn($add_to_cart_html, $product, $args)
{
    $add_to_cart_html = "asdasdsad";
    // Before text or HTML here
    $before = '<p>Before custom text here</p>';

    // After text or HTML here
    $after = '<p>After custom text here</p>';

    return $before . $add_to_cart_html . $after;
}


add_filter('woocommerce_is_purchasable', 'command', 10, 2);

function command($value, $product)
{


    $level = get_post_meta($product->get_ID(), "vip-level", true);
    $user_meta = get_userdata(get_current_user_id());
    $user_roles = $user_meta->roles;

    if ($level == "سطح اول" && implode($user_roles) == "vip1") {
        return $value;

    } elseif ($level == "سطح دوم" && (implode($user_roles) == "vip2" || implode($user_roles) == "vip1")) {
        return $value;
    } elseif ($level == "سطح سوم" && (implode($user_roles) == "vip3" || implode($user_roles) == "vip2" || implode($user_roles) == "vip1")) {
        return $value;
    } else {
        // return $value;
    }


}

function custom_woocommerce_update_order($order_id)
{
// get role customer
    $order = wc_get_order($order_id);
    $order_status = $order->status;
    $customer = $order->get_customer_id();
    $user = get_userdata($customer);
    $user_roles = $user->roles;

    // get product

    $items = $order->get_items();
    $level_product="";
    foreach ($items as $item) {
        $id_item = $item->get_product_id();
        $level_product = get_post_meta($id_item, "vip-level", true);
    }


    if ($order_status == 'completed') {

        if (in_array("vip3", $user_roles)) {

            if ($level_product == "سطح سوم") {
                $user = new WP_User($customer);
                $user->roles;
//            $user->add_role('power_member');
//            $user->roles; // ["subscriber", "power_member"]
                $user->set_role('vip2');
                $user->roles;
            }

        } elseif (in_array("vip2", $user_roles)) {
            if ($level_product == "سطح دوم") {
                $user = new WP_User($customer);
                $user->roles;
//            $user->add_role('power_member');
//            $user->roles; // ["subscriber", "power_member"]
                $user->set_role('vip1');
                $user->roles;
            }
        } elseif (in_array("vip1", $user_roles)) {
            if ($level_product == "سطح اول") {
                $user = new WP_User($customer);
                $user->roles;
//            $user->add_role('power_member');
//            $user->roles; // ["subscriber", "power_member"]
                $user->set_role('vip3');
                $user->roles;
            }
        }

    }

}


add_action('woocommerce_update_order', 'custom_woocommerce_update_order', 10, 1);

