<?php
// wordpressバージョン非表示
remove_action('wp_head', 'wp_generator');

// ログインURLを変更する
define('LOGIN_CHANGE_PAGE', 'write-article.php');
add_action('login_init', 'login_change_init');
add_filter('site_url', 'login_change_site_url', 10, 4);
add_filter('wp_redirect', 'login_change_wp_redirect', 10, 2);

// 指定意外のログインURLは403エラーにする
if (!function_exists('login_change_init')) {
    function login_change_init() {
        if (!defined('LOGIN_CHANGE') || sha1('BLOG_LOGIN_SHA1') != LOGIN_CHANGE) {
            status_header(403);
            exit;
        }
    }
}

// ログイン済みか新設のログインURLの場合はwp-login.phpを置き換える
if (!function_exists('login_change_site_url')) {
    function login_change_site_url($url, $path, $orig_scheme, $blog_id) {
        if ($path == 'wp-login.php' &&
            (is_user_logged_in() || strpos($_SERVER['REQUEST_URI'], LOGIN_CHANGE_PAGE) != false))
            $url = str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $url);
        return $url;
    }
}

// ログアウト時のリダイレクト先の設定
if (!function_exists('login_change_wp_redirect')) {
    function login_change_wp_redirect($location, $status) {
        if (strpos($_SERVER['REQUEST_URI'], LOGIN_CHANGE_PAGE) !== false)
            $location = str_replace('wp-login.php', LOGIN_CHANGE_PAGE, $location);
        return $location;
    }
}


// 記事内の画像パスを書き換える
function replace_image_url ($url) {
    return str_replace(wp_upload_dir()['baseurl'], 'https://blogFiles.bithitkit.com', $url);
}
add_filter('wp_get_attachment_url', 'replace_image_url');
add_filter('attachment_link', 'replace_image_url');

// 画像からclass名を削除する
function image_tag_delete($html) {
    return preg_replace( '/class=[\'"]([^\'"]+)[\'"]/i', '', $html );
}
add_filter('image_send_to_editor', 'image_tag_delete', 10);
add_filter('post_thumbnail_html', 'image_tag_delete', 10);

// Gutenberg無効化したい
add_action( 'wp_enqueue_scripts', 'remove_block_library_style' );
function remove_block_library_style() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
}
