<?php
/**
 * This file is a part of the Radium Framework core.
 * Please be cautious editing this file,
 *
 * @category Analytica
 * @package  Energia
 * @author   Franklin Gitonga
 * @link     https: //radiumthemes.com/
 */
add_filter( 'analytica_customizer_controls', 'analytica_admin_add_customizer_site_footer_control' );
/**
 * [analytica_theme_defaults description]
 */
function analytica_admin_add_customizer_site_footer_control( $controls ) {

    $default    = Analytica\Options::defaults();
    $core       = analytica();

    $new_controls = [
        [
            'id'      => 'site-footer',
            'section' => 'footer_general',
            'type'    => 'switch',
            'label'   => esc_html__( 'Enable Footer' , 'analytica' ),
            'default'   => $default['site-footer'],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
        ],

        [
            'id'      => 'site-footer-widgets',
            'section' => 'footer_general',
            'type'    => 'switch',
            'label'   => esc_html__( 'Enable Footer Widgets' , 'analytica' ),
            'default'   => $default['site-footer-widgets'],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'site-footer-width',
            'section' => 'footer_general',
            'type'    => 'switch',
            'label'   => esc_html__( 'Footer fullwidth' , 'analytica' ),
            'default'   => $default['site-footer-width'],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
                [
                    'setting'  => 'site-layout',
                    'operator' => '!=',
                    'value'    => 'boxed',
                ],
            ],
            'partial_refresh' => [
                'site-footer' => [
                    'selector'        => '.site-footer',
                    'render_callback' => function() {
                        ob_start();

                        do_action( 'analytica_before_footer' );
                        do_action( 'analytica_footer' );
                        do_action( 'analytica_after_footer' );

                        $output = ob_get_contents();
                        ob_end_clean();

                        return $output;
                    },
                ],
            ],
        ],

        [
            'id'      => 'site-footer-layout',
            'section' => 'footer_general',
            'type'    => 'radio-image',
            'label'   => esc_html__( 'Footer Layout', 'analytica' ),
            'desc'    => esc_html__( 'Select a layout for the footer.', 'analytica' ),
            'options' => [
                'layout-1'  => $core->theme_url . '/assets/admin/images/footer/footer-1.png',
                'layout-2'  => $core->theme_url . '/assets/admin/images/footer/footer-2.png',
                'layout-3'  => $core->theme_url . '/assets/admin/images/footer/footer-3.png',
                'layout-4'  => $core->theme_url . '/assets/admin/images/footer/footer-4.png',
                'layout-5'  => $core->theme_url . '/assets/admin/images/footer/footer-5.png',
                'layout-6'  => $core->theme_url . '/assets/admin/images/footer/footer-6.png',
                'layout-7'  => $core->theme_url . '/assets/admin/images/footer/footer-7.png',
                'layout-8'  => $core->theme_url . '/assets/admin/images/footer/footer-8.png',
                'layout-9'  => $core->theme_url . '/assets/admin/images/footer/footer-9.png',
                'layout-10' => $core->theme_url . '/assets/admin/images/footer/footer-10.png',
                'layout-11' => $core->theme_url . '/assets/admin/images/footer/footer-11.png',
                'layout-12' => $core->theme_url . '/assets/admin/images/footer/footer-12.png',
            ],
            'default'   => $default['site-footer-layout'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
                [
                    'setting'  => 'site-footer-widgets',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'partial_refresh' => [
                'site-footer' => [
                    'selector'        => '.site-footer',
                    'render_callback' => function() {
                        ob_start();

                        do_action( 'analytica_before_footer' );
                        do_action( 'analytica_footer' );
                        do_action( 'analytica_after_footer' );

                        $output = ob_get_contents();
                        ob_end_clean();

                        return $output;
                    },
                ],
            ],
        ],

        [
            'id'              => 'site-theme-badge',
            'section'         => 'footer_general',
            'transport'       => 'postMessage',
            'label'           => esc_html__( 'Support', 'analytica' ) . ' ' . analytica()->theme_title,
            /* translators: %1$s: Theme name */
            'desc'            => sprintf( esc_html__( 'Support %1$s by displaying the %1$s badge on your site.', 'analytica' ), analytica()->theme_title ),
            'type'            => 'switch',
            'default'   => $default['site-theme-badge'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
        ],

        [
            'id'              => 'site-back-to-top',
            'section'         => 'footer_general',
            'type'            => 'switch',
            'transport'       => 'postMessage',
            'label'           => esc_html__( 'Back to Top Button', 'analytica' ),
            'default'   => $default['site-back-to-top'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
        ],

        [
            'id'      => 'site-footer-padding',
            'type'    => 'spacing',
            'label'   => esc_html__( 'Footer padding', 'analytica' ),
            'section' => 'footer_general',
            'default'   => $default['site-footer-padding'],
            'transport' => 'auto',
            'output'    => [
                [
                    'property' => 'padding',
                    'element'  => '.site-footer .site-footer-widgets',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'site-footer-border-style',
            'type'    => 'select',
            'label'   => esc_html__( 'Border style', 'analytica' ),
            'section' => 'footer_general',
            'default'   => $default['site-footer-border-style'],
            'transport' => 'auto',
            'choices' => [
                'solid' => 'solid',
            ],
            'output'    => [
                [
                    'property' => 'border-style',
                    'element'  => '.site-footer',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'site-footer-border',
            'type'    => 'spacing',
            'label'   => esc_html__( 'Border', 'analytica' ),
            'section' => 'footer_general',
            'default'   => $default['site-footer-border'],
            'transport' => 'auto',
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'        => 'footer-border-color',
            'section'   => 'footer_general',
            'type'      => 'color',
            'transport' => 'auto',
            'label'     => esc_html__( 'Border Color' , 'analytica' ),
            'default'   => $default['footer-border-color'],
            'output'    => [
                [
                    'property' => 'border-color',
                    'element'  => '.site-footer',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        // Footer colors
        [
            'id'              => 'footer-text-color',
            'section'         => 'footer_color',
            'type'            => 'color',
            'transport'       => 'auto',
            'label'           => esc_html__( 'Text Color' , 'analytica' ),
            'default'   => $default['footer-text-color'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'output' => [
                [
                    'property' => 'color',
                    'element'  => [
                        '.site-footer',
                        '.site-footer .site-footer-widgets',
                        '.site-footer .widget-area',
                    ],
                ],
            ],
        ],

        [
            'id'              => 'footer-headers-color',
            'section'         => 'footer_color',
            'type'            => 'color',
            'transport'       => 'auto',
            'label'           => esc_html__( 'Headings Color' , 'analytica' ),
            'default'   => $default['footer-headers-color'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'output' => [
                [
                    'property' => 'color',
                    'element'  => [
                        '.site-footer .site-footer-widgets .widget-area h1',
                        '.site-footer .site-footer-widgets .widget-area h2',
                        '.site-footer .site-footer-widgets .widget-area h3',
                        '.site-footer .site-footer-widgets .widget-area h4',
                        '.site-footer .site-footer-widgets .widget-area h5',
                        '.site-footer .site-footer-widgets .widget-area h6',
                        '.site-footer .site-footer-widgets .widget-area input:not([type=submit]):not([type=file])',
                        '.site-footer .site-footer-widgets .widget-area label',
                        '.site-footer .site-footer-widgets .widget-area legend',
                        '.site-footer .site-footer-widgets .widget-area select',
                        '.site-footer .site-footer-widgets .widget-area textarea',
                        '.site-footer .site-footer-widgets .widget-area .widget-title',
                        '.site-footer .site-footer-widgets .widget-area #wp-calendar caption',
                    ],
                ],
            ],
        ],

        [
            'id'              => 'footer-accent-color',
            'section'         => 'footer_color',
            'type'            => 'color',
            'transport'       => 'auto',
            'label'           => esc_html__( 'Accent Color' , 'analytica' ),
            'default'   => $default['footer-accent-color'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'output' => [
                [
                    'property' => 'border-left-color',
                    'element'  => [
                        '.site-footer .section-title .widget-title',
                    ],
                ],

                [
                    'property' => 'background-color',
                    'element'  => [
                        '.site-footer .section-title .widget-title:after',
                        '.site-footer .section-title .widget-title:before',
                    ],
                ],
            ],
        ],

        [
            'id'              => 'footer-link-color',
            'section'         => 'footer_color',
            'type'            => 'color',
            'transport'       => 'auto',
            'label'           => esc_html__( 'Link Color' , 'analytica' ),
            'default'   => $default['footer-link-color'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'output' => [
                [
                    'property' => 'color',
                    'element'  => [
                        '.site-footer .widget-wrap a',
                        '.site-footer ul li a',
                        '.site-footer .site-footer-widgets ul li a',
                        '.site-footer a',
                    ],
                ],
            ],
        ],

        [
            'id'          => 'footer-background',
            'section'     => 'footer_color',
            'type'        => 'background',
            'transport'   => 'auto',
            'label'       => esc_html__( 'Choose a background', 'analytica' ),
            'description' => esc_html__( 'The background you specify here will apply to the footer area', 'analytica' ),
            'default'   => $default['footer-background'],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'output' => [
                [
                    'element' => '.site-footer',
                ],
            ],
        ],

        [
            'id'      => 'footer-colophon',
            'section' => 'footer_copyright',
            'type'    => 'switch',
            'label'   => esc_html__( 'Enable colophon' , 'analytica' ),
            'default'   => $default['footer-colophon'],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
            'conditions' => [
                [
                    'setting'  => 'site-footer',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'footer-colophon-width',
            'section' => 'footer_copyright',
            'type'    => 'switch',
            'label'   => esc_html__( 'Footer colophon fullwidth' , 'analytica' ),
            'default'   => $default['footer-colophon-width'],
            'options' => [
                1 => esc_attr__( 'Enable', 'analytica' ),
                0 => esc_attr__( 'Disable', 'analytica' ),
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
                [
                    'setting'  => 'site-layout',
                    'operator' => '!=',
                    'value'    => 'boxed',
                ],
            ],
            'partial_refresh' => [
                'site-footer' => [
                    'selector'        => '.site-colophon',
                    'render_callback' => function() {
                        ob_start();

                        analytica_do_colophon();

                        $output = ob_get_contents();
                        ob_end_clean();

                        return $output;
                    },
                ],
            ],
        ],

        [
            'id'              => 'site-footer-copyright-text',
            'section'         => 'footer_copyright',
            'transport'       => 'postMessage',
            'type'            => 'textarea',
            'label'           => esc_html__( 'Copyright Text' , 'analytica' ),
            'default'   => $default['site-footer-copyright-text'],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
            'js_vars' => [
                [
                    'element'  => '.site-copyright',
                    'function' => 'html',
                ],
            ],
        ],

        [
            'id'      => 'footer-colophon-padding',
            'type'    => 'spacing',
            'label'   => esc_html__( 'Colophon Padding', 'analytica' ),
            'section' => 'footer_copyright',
            'default'   => $default['footer-colophon-padding'],
            'transport' => 'auto',
            'output'    => [
                [
                    'property' => 'padding',
                    'element'  => '.site-colophon',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'footer-colophon-border-style',
            'type'    => 'select',
            'label'   => esc_html__( 'Colophon border style', 'analytica' ),
            'section' => 'footer_copyright',
            'default'   => $default['footer-colophon-border-style'],
            'transport' => 'auto',
            'choices' => [
                'solid' => 'solid',
            ],
            'output'    => [
                [
                    'property' => 'border-style',
                    'element'  => '.site-colophon',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'      => 'footer-colophon-border',
            'type'    => 'spacing',
            'label'   => esc_html__( 'Colophon border', 'analytica' ),
            'section' => 'footer_copyright',
            'default'   => $default['footer-colophon-border'],
            'transport' => 'auto',
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'        => 'footer-colophon-border-color',
            'section'   => 'footer_copyright',
            'type'      => 'color',
            'transport' => 'auto',
            'label'     => esc_html__( 'Colophon Border Color' , 'analytica' ),
            'default'   => $default['footer-colophon-border-color'],
            'output'    => [
                [
                    'property' => 'border-color',
                    'element'  => '.site-colophon',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'        => 'footer-colophon-color',
            'section'   => 'footer_copyright',
            'type'      => 'color',
            'transport' => 'auto',
            'label'     => esc_html__( 'Colophon Color' , 'analytica' ),
            'default'   => $default['footer-colophon-color'],
            'output'    => [
                [
                    'property' => 'color',
                    'element'  => '.site-colophon',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'        => 'footer-colophon-links-color',
            'section'   => 'footer_copyright',
            'type'      => 'color',
            'transport' => 'auto',
            'label'     => esc_html__( 'Colophon Links Color' , 'analytica' ),
            'default'   => $default['footer-colophon-links-color'],
            'output'    => [
                [
                    'property' => 'color',
                    'element'  => '.site-colophon .site-creds a',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

        [
            'id'        => 'footer-colophon-background-color',
            'section'   => 'footer_copyright',
            'type'      => 'color',
            'transport' => 'auto',
            'label'     => esc_html__( 'Colophon Background Color' , 'analytica' ),
            'default'   => $default['footer-colophon-background-color'],
            'output'    => [
                [
                    'property' => 'background-color',
                    'element'  => '.site-colophon',
                ],
            ],
            'conditions' => [
                [
                    'setting'  => 'footer-colophon',
                    'operator' => '==',
                    'value'    => true,
                ],
            ],
        ],

    ];

    $controls = array_merge( $controls, $new_controls );

    return $controls;
}

add_action( 'customize_register', 'analytica_add_footer_panels_and_sections' );
/**
 * Create the customizer panels and sections
 */
function analytica_add_footer_panels_and_sections( $wp_customize ) {
    $wp_customize->add_panel( 'site-footer', [
        'priority' => 24,
        'title'    => esc_html__( 'Site Footer', 'analytica' ),
    ] );

    $wp_customize->add_section( 'footer_general', [
        'title'    => esc_html__( 'General', 'analytica' ),
        'panel'    => 'site-footer',
        'priority' => 25,
    ] );

    $wp_customize->add_section( 'footer_color', [
        'title'    => esc_html__( 'Colors', 'analytica' ),
        'panel'    => 'site-footer',
        'priority' => 26,
    ] );

    $wp_customize->add_section( 'footer_copyright', [
        'title'    => esc_html__( 'Copyright', 'analytica' ),
        'panel'    => 'site-footer',
        'priority' => 27,
    ] );
}
