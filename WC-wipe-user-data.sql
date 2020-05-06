-- WC User Meta
UPDATE wp_usermeta SET meta_value = 'Test' WHERE meta_key = 'billing_first_name';
UPDATE wp_usermeta SET meta_value = 'User' WHERE meta_key = 'billing_last_name';
UPDATE wp_usermeta SET meta_value = '123 East Main' WHERE meta_key = 'billing_address_1';
UPDATE wp_usermeta SET meta_value = 'test@email.com' WHERE meta_key = 'billing_email';
UPDATE wp_usermeta SET meta_value = '(888) 555-1212' WHERE meta_key = 'billing_phone';
UPDATE wp_usermeta SET meta_value = 'Test' WHERE meta_key = 'shipping_first_name';
UPDATE wp_usermeta SET meta_value = 'User' WHERE meta_key = 'shipping_last_name';
UPDATE wp_usermeta SET meta_value = '123 East Main' WHERE meta_key = 'shipping_address_1';
UPDATE wp_usermeta SET meta_value = 'test@email.com' WHERE meta_key = 'shipping_email';
UPDATE wp_usermeta SET meta_value = '(888) 555-1212' WHERE meta_key = 'shipping_phone';

-- WP Post Meta
UPDATE wp_postmeta SET meta_value = 'Test' WHERE meta_key = '_billing_first_name';
UPDATE wp_postmeta SET meta_value = 'User' WHERE meta_key = '_billing_last_name';
UPDATE wp_postmeta SET meta_value = '123 East Main' WHERE meta_key = '_billing_address_1';
UPDATE wp_postmeta SET meta_value = 'test@email.com' WHERE meta_key = '_billing_email';
UPDATE wp_postmeta SET meta_value = '(888) 555-1212' WHERE meta_key = '_billing_phone';
UPDATE wp_postmeta SET meta_value = 'Test' WHERE meta_key = '_shipping_first_name';
UPDATE wp_postmeta SET meta_value = 'User' WHERE meta_key = '_shipping_last_name';
UPDATE wp_postmeta SET meta_value = '123 East Main' WHERE meta_key = '_shipping_address_1';
UPDATE wp_postmeta SET meta_value = 'test@email.com' WHERE meta_key = '_shipping_email';
UPDATE wp_postmeta SET meta_value = '(888) 555-1212' WHERE meta_key = '_shipping_phone';