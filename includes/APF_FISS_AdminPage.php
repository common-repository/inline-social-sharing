<?php
/*
    Plugin Name:    Admin Page Framework Tutorial 01 - Create an Admin Page
    Plugin URI:     http://en.michaeluno.jp/admin-page-framework
    Description:    Creates an admin page with Admin Page Framework v3
    Author:         Michael Uno
    Author URI:     http://michaeluno.jp
    Version:        1.0.2
    Requirements:   PHP 5.2.4 or above, WordPress 3.4 or above. Admin Page Framework 3.0.0 or above
*/

class APF_FISS_AdminPage extends AdminPageFramework {

    /**
     * The set-up method which is triggered automatically with the 'wp_loaded' hook.
     *
     * Here we define the setup() method to set how many pages, page titles and icons etc.
     */
    public function setUp() {

        // Create the root menu - specifies to which parent menu to add.
        $this->setRootMenuPage( 'Settings' );

        // Add the sub menus and the pages.
        $this->addSubMenuItems(
            array(
                'title'     => 'Inline Social Sharing',  // page and menu title
                'page_slug' => 'inline_social_sharing'     // page slug
            )
        );

        $this->addSettingSections(
            'inline_social_sharing',
            array(
                'section_id' => 'fiss_general',
                'title' => 'General',
                'description' => 'Core Settings.',
            ),
            array(
                'section_id' => 'fiss_social',
                'title' => 'Social',
                'description' => 'Social options.',
            )
        );

        $this->addSettingFields(
            'fiss_general',
            array(
                'field_id'          => 'paragraph_number',
                'title'             => 'Inline Box interval appearance',
                'description'       => 'Indicate the number of paragraphs the plugin should respect in order to display the Inline Social Sharing Box.<br/><a href="#">Read our documentation for more info.</a>',
                'type'              => 'number',
                'default'       => 4,
            ),
            array(    // Text Area
                'field_id'      => 'fiss_message',
                'type'          => 'text',
                'title'         => 'Message',
                'description'   => 'BE BOLD! A good message catch more shares! <a href="https://fruitfulwp.com/inline-social-sharing" target="blank">Unlock advanced Box style and message option with Inline Social Sharing PRO plugin</a>.',
                'default'       => '',
                'attributes'    => array(
                    'field' => array(
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array(
                'field_id'              => 'fiss_post_type',
                'title'                 => __( 'Post Type', 'admin-page-framework-loader' ),
                'type'                  => 'posttype')
        );

        $this->addSettingFields(
            'fiss_social',
            array(
                'field_id'      => 'fiss_social_list',
                'title'         => __( 'Multiple', 'fruitful-inline-social-sharing' ),
                'type'          => 'checkbox',
                'label'         => array(
                    'facebook'  => __( 'Facebook', 'fruitful-inline-social-sharing' ),
                    'google' => __( 'Google+', 'fruitful-inline-social-sharing' ) ,
                    'linkedin'   => __( 'Linkedin', 'fruitful-inline-social-sharing' ),
                    'twitter'  => __( 'Twitter', 'fruitful-inline-social-sharing' ),
                    //'whatsapp'  => __( 'Whatsapp', 'fruitful-inline-social-sharing' ),
                ),
                'default'       => array(
                    'facebook'  => false,
                    'google' => false,
                    'linkedin'   => false,
                    'twitter'  => false,
                    //'whatsapp'  => false,
                ),
                'after_label'   => '',
            ),
            array(
                'field_id'      => 'fiss_hide_counter',
                'title'         => __( 'Hide counter', 'fruitful-inline-social-sharing' ),
                'type'          => 'checkbox',
                'default'   => false,
            ),
            array(    // Text Area
                'field_id'      => 'fiss_twiter_handle',
                'type'          => 'text',
                'title'         => 'Twiter handle',
                'description'   => 'Please, include @, like @fruitfulwp',
                'default'       => '@',
                'attributes'    => array(
                    'field' => array(
                        'style' => 'width: 100%;' // since the rich editor does not accept the cols attribute, set the width by inline-style.
                    ),
                ),
            ),
            array( // Submit button
                'field_id'      => 'submit_button',
                'type'          => 'submit',
            )
        );



    }

    public function load_inline_social_sharing( $oAdminPage ) {



    }

	public function do_inline_social_sharing() {

		ob_start();
		include plugin_dir_path(dirname(__FILE__)).'admin/partials/pro.php';
		echo ob_get_clean();

	}

    /**
     * The pre-defined validation callback method.
     *
     * Notice that the method name is validation_{instantiated class name}_{field id}.
     *
     * @param    string|array    $sInput        The submitted field value.
     * @param    string|array    $sOldInput    The old input value of the field.
     */
    public function validation_APF_FISS_AdminPage_fiss_social_fiss_twiter_handle( $sInput, $sOldInput ) {

        // Set a flag
        $_bIsValid = true;
        // Prepare an field error array.
        $_aErrors  = array();

        if ($sInput != '' and substr($sInput, 0, 1) != '@') {

            $sInput = '@' . $sInput;
        }


        return $sInput;

    }


}

// Instantiate the class object.
new APF_FISS_AdminPage;
