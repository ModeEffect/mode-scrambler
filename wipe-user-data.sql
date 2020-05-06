-- WP Users
UPDATE wp_users SET user_email = concat(substring_index(user_email, '@', 1), FLOOR(rand() * 90000 + 10000), '@test.local');
UPDATE wp_users SET display_name = concat('Test User ', FLOOR(rand() * 90000 + 10000));
UPDATE wp_users SET user_login = concat(substring_index(user_email, '@', 1), FLOOR(rand() * 90000 + 10000), '@test.local');

-- WP User Meta
UPDATE wp_usermeta SET meta_value = 'Test' WHERE meta_key = 'first_name';
UPDATE wp_usermeta SET meta_value = 'User' WHERE meta_key = 'last_name';