<div class="wrap">
    <?php
    global $wp_roles;
    ?>
    <label for="level-product">این محصول برای چه سطحی از کاربر فعال باشد؟</label>



    <select name="level-product" id="level-product">
        <option value>بدون سطح بندی</option>
        <?php
        $data_vip_role = get_post_meta(get_the_ID(), "vip-level", true);
        foreach ($wp_roles->roles as $role) :
            $role_name = $role['name'];
            if (strpos($role_name, 'سطح') !== false): ?>
                <option value="<?php echo $role['name'] ?>" <?php echo $role['name'] == $data_vip_role ? "selected" : "" ?>><?php echo $role['name'] ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>