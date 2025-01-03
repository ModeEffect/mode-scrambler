<?php
/*
Plugin Name: ModeEffect Scrambler
Plugin URI: https://modeeffect.com/
Description: Wipe sensitive user data and WooCommerce customer data.
Version: 1.0.0
Author: KevinBrent
Author URI: https://modeeffect.com/
Contributors: KevinBrent
Text Domain: mode-scrambler
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Requires PHP: 8.0
Package: Mode_Scrambler
*/

namespace Mode\Scrambler;

use WP_CLI;
use wpdb;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MODE_SCRAMBLER_VERSION', '1.0.0' );

class Scrambler {
    
    protected string $environment;
    
    private string $email = 'modeeffect.com';

    public function __construct( ) {
        $this->environment = wp_get_environment_type();
    }

    private function validate() {

        if ( 'production' === $this->environment ) {
            WP_CLI::log( __( 'You are not allowed to run this command on production.', 'mode-scrambler' ) );
            die();
        }
    }

    private function set_properties( array $args ): void {

        foreach ( $args as $key => $value ) {

            if ( property_exists( $this, $key ) ) {
                $this->$key = $value;
            }
            else {
                WP_CLI::log( sprintf( '"%s" is not a valid argument!!', $key ) );
                die();
            }

        }

    }
    
    private function get_like() {
        global $wpdb;

        return '%' . $wpdb->esc_like( esc_sql( $this->email ) ) . '%';
    }
    
    private function email_formula( $column, $string = '@test.local' ): string {
        return sprintf( "concat(substring_index($column, '@', 1), FLOOR(rand() * 90000 + 10000), '%s')", $string );
    }

    private function name_formula( $string ): string {
        return sprintf( "concat('%s', FLOOR(rand() * 90000 + 10000) )", $string );
    }

    public function wp( $args, $assoc_args ) {

        global $wpdb;

        $this->validate();
        $this->set_properties( $assoc_args );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->users
            SET user_email = {$this->email_formula( 'user_email' )} 
            WHERE user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->users 
            SET display_name = {$this->name_formula( 'Test User ' )} 
            WHERE user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->users 
            SET user_login = {$this->email_formula( 'user_email' )} 
            WHERE user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( "UPDATE $wpdb->usermeta SET meta_value = {$this->name_formula( 'Test' )} WHERE meta_key = 'first_name';" );
        $wpdb->query( "UPDATE $wpdb->usermeta SET meta_value = {$this->name_formula( 'User' )} WHERE meta_key = 'last_name';" );

        WP_CLI::log( __( 'WordPress user data scrambled successfully!', 'mode-scrambler' ) );

    }

    public function wc( $args, $assoc_args ) {
        global $wpdb;

        $this->validate();
        $this->set_properties( $assoc_args );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->usermeta um
            INNER JOIN $wpdb->users u
                ON u.ID = um.user_id
            SET um.meta_value = {$this->email_formula( 'um.meta_value' )} 
            WHERE um.meta_key LIKE '%_email'
                AND u.user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->usermeta um
            INNER JOIN $wpdb->users u
                ON u.ID = um.user_id
            SET um.meta_value = {$this->name_formula( 'Test' )} 
            WHERE um.meta_key LIKE '%_first_name'
                AND u.user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->usermeta um
            INNER JOIN $wpdb->users u
                ON u.ID = um.user_id
            SET um.meta_value = {$this->name_formula( 'Customer' )} 
            WHERE um.meta_key LIKE '%_last_name'
                AND u.user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->usermeta um
            INNER JOIN $wpdb->users u
                ON u.ID = um.user_id
            SET um.meta_value = '123 East Main' 
            WHERE um.meta_key LIKE '%_address_1'
                AND u.user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );

        $wpdb->query( $wpdb->prepare(
            "
            UPDATE $wpdb->usermeta um
            INNER JOIN $wpdb->users u
                ON u.ID = um.user_id
            SET um.meta_value = '(888) 555-1212' 
            WHERE um.meta_key LIKE '%_phone'
                AND u.user_email NOT LIKE %s
            ",
            $this->get_like()
        ) );


        WP_CLI::log( __( 'WooCommerce customer data scrambled successfully!', 'mode-scrambler' ) );

    }

    public function version() {
        WP_CLI::log( sprintf( 'Scrambler Version: %s', MODE_SCRAMBLER_VERSION ) );
    }

}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'scramble', new Scrambler() );
}
