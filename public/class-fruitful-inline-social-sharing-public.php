<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://fruitfulwp.com/
 * @since      1.0.0
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @author     Fruitfull <info@fruitfulwp.com>
 */
class Fruitful_Inline_Social_Sharing_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     *
     * @var string The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     *
     * @var string The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/fruitful-inline-social-sharing-public.css', array(), $this->version, 'all');
        wp_enqueue_style('font-awesome', plugin_dir_url(__FILE__).'css/font-awesome.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/fruitful-inline-social-sharing-public.js', array('jquery'), $this->version, false);

        wp_localize_script(
            $this->plugin_name,
            'ajaxurl',
            admin_url('admin-ajax.php')
        );
    }

    public function add_shortcode($content)
    {
        $post_type = get_post_type();

        $data = get_option('APF_FISS_AdminPage');
        $get_post_type = $data['fiss_general']['fiss_post_type'];

        if (!$get_post_type[$post_type]) {
            return $content;
        }

        $shortcode = '[iss]';

        if (in_the_loop()) { //Simply make sure that these changes effect the main query only

            $closing_p = '</p>';
            $paragraphs = explode($closing_p, wptexturize($content));

            $data = get_option('APF_FISS_AdminPage');

            $count = count($paragraphs);
            $paragraph_number = $data['fiss_general']['paragraph_number'] > 0 ? $data['fiss_general']['paragraph_number'] : 4;

            $totals = array_chunk($paragraphs, $paragraph_number, true);

            $new_paras = array();

            foreach ($totals as $key_total => $total) {
                $p = array();

                foreach ($total as $key_paras => $paragraph) {
                    $word_count = count(explode(' ', $paragraph));
                    if (preg_match('~<(?:img|ul|li)[ >]~', $paragraph) || $word_count < 10) {
                        $p[$key_paras] = 0;
                    } else {
                        $p[$key_paras] = 1;
                    }
                }

                $m = array();

                foreach ($p as $key => $value) {
                    if (1 === $value &&  $key > min(array_keys($p)) && $p[$key] === $p[$key - 1] &&  !$m) {
                        $m[] = $key;
                    } elseif (!array_key_exists($key + 1, $p) && !$m) {
                        $m[] = 'no-ad';
                    }
                }

                foreach ($total as $key_para => $para) {
                    if (!in_array('no_ad', $m) && $key_para === $m[0]) {
                        $new_paras['ad'.$m[0]] = $shortcode;
                        $new_paras[$key_para] = $para;
                    } else {
                        $new_paras[$key_para] = $para;
                    }
                }
            }
            /**-----------------------------------------------------------------------------
             *
             *  $content should be a string, not an array. $new_paras is an array, which will
             *  not work. $new_paras are converted to a string with implode, and then passed
             *  to $content which will be our new content
             *
            *------------------------------------------------------------------------------*/
            $content = implode(' ', $new_paras);
        }

        return $content;
    }

    public function shortcode($atts)
    {
        $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http')."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $data = get_option('APF_FISS_AdminPage');

        // UTMs
        $utm_medium = $data['fiss_utms']['utm_medium'];
        $utm_campaign = $data['fiss_utms']['utm_campaign'];

        // Social
        $fiss_twiter_handle = $data['fiss_social']['fiss_twiter_handle'];
        $fiss_social_list = array_key_exists('fiss_social_list', $data['fiss_social']) ? $data['fiss_social']['fiss_social_list'] : array(
            'facebook' => false,
            'google' => false,
            'linkedin' => false,
            'twitter' => false,
            'whatsapp' => false,
        );

        // Box
        $hide_counter = $data['fiss_social']['fiss_hide_counter'];

        $message = $data['fiss_general']['fiss_message'];
        $fiss_border = (isset($data['fiss_box']['fiss_border']['fiss_border_enable']) and $data['fiss_box']['fiss_border']['fiss_border_enable']) ?
            $data['fiss_box']['fiss_border']['fiss_border_style'].' '.$data['fiss_box']['fiss_border']['fiss_border_width'].'px '.$data['fiss_box']['fiss_border']['fiss_border_color'] : '';

        ob_start();
        include plugin_dir_path(dirname(__FILE__)).'public/partials/shortcode.php';
        $content = ob_get_clean();

        return $content;
    }
}
