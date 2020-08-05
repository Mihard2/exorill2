<?php
namespace Elementor;

if(!defined('ABSPATH')) exit;

class OSF_Elementor_Table_Widget extends Widget_Base {

	public  function get_name(){
		return 'opal-table';
	}

	public function get_title() {
		return 'Opal Table';
	}

	public function get_categories() {
		return [ 'opal-addons' ];
	}


	protected function get_repeater_controls($repeater, $condition = [] ){

		$repeater->add_control('table_text',
			[
				'label'         => esc_html__('Text', 'strollik-core'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [ 'active' => true ],
				'placeholder'   => 'Text',
				'condition'     => array_merge( $condition, [] ),
			]
		);

		$repeater->add_control('table_icon_selector',
			[
				'label'        => esc_html__('Icon Type','strollik-core'),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'font-awesome-icon',
				'options'      =>[
					'font-awesome-icon' => esc_html__('Font Awesome Icon','strollik-core'),
					'custom-image'     => esc_html__('Custom Image','strollik-core'),
				],
				'condition'     => array_merge( $condition, [] ),
			]
		);

		$repeater->add_control('table_cell_icon',
			[
				'label'         => esc_html__('Icon', 'strollik-core'),
				'type'          => Controls_Manager::ICON,
				'label_block'   => true,
				'condition'     => array_merge( $condition, [
					'table_icon_selector'   => 'font-awesome-icon'
				] ),
			]
		);

		$repeater->add_control('table_cell_icon_img',
			[
				'label'        => esc_html__('Custom Image','strollik-core'),
				'type'         => Controls_Manager::MEDIA,
				'condition'     => array_merge( $condition, [
					'table_icon_selector'   => 'custom-image'
				] ),
			]
		);

		$repeater->add_control('table_cell_icon_align',
			[
				'label'         => esc_html__('Icon Position', 'strollik-core'),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'before',
				'options'       => [
					'top'           => esc_html__('Top', 'strollik-core'),
					'before'        => esc_html__('Before', 'strollik-core'),
					'after'         => esc_html__('After', 'strollik-core'),
				],
				'condition'	=> array_merge( $condition, [] ),
				'label_block'   => true,
			]
		);

		$repeater->add_control('table_cell_icon_spacing',
			[
				'label'         => esc_html__('Icon Spacing', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'condition'	=> array_merge( $condition, [] ),
				'selectors'     => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .opal-table-text .opal-table-cell-icon-before'   => 'margin-right: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .opal-table-text .opal-table-cell-icon-after'    => 'margin-left: {{SIZE}}px',
					'{{WRAPPER}} {{CURRENT_ITEM}} .opal-table-text.opal-table-cell-top .opal-table-cell-icon-top'    => 'margin-bottom: {{SIZE}}px',
				],
				'separator'     => 'below',
			]
		);

		$repeater->add_control('table_cell_row_span',
			[
				'label'         => esc_html__('Row Span', 'strollik-core'),
				'type'          => Controls_Manager::NUMBER,
				'title'         => esc_html__('Enter the number of rows for the cell', 'strollik-core'),
				'default'       => 1,
				'min'           => 1,
				'max'           => 10,
				'condition'     => array_merge( $condition, [] ),
			]
		);

		$repeater->add_control('table_cell_span',
			[
				'label'         => esc_html__('Column Span', 'strollik-core'),
				'type'          => Controls_Manager::NUMBER,
				'title'         => esc_html__('Enter the number of columns for the cell', 'strollik-core'),
				'default'       => 1,
				'min'           => 1,
				'max'           => 10,
				'condition'     => array_merge( $condition, [] ),
			]
		);

		$repeater->add_responsive_control('table_cell_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				],
				'condition'     => array_merge( $condition, [
					'table_cell_icon_align!' => 'top'
				] ),
			]
		);

		$repeater->add_responsive_control('table_cell_top_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'flex-start'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
				],
				'condition'     => array_merge( $condition, [
					'table_cell_icon_align' => 'top'
				] ),
			]
		);

	}

	protected function _register_controls(){

		$this->start_controls_section('table_data_section',
			[
				'label'     => esc_html__('Data', 'strollik-core'),
			]
		);

		$this->add_control('table_data_type',
			[
				'label'     => esc_html__('Data Type', 'strollik-core'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'custom'    => esc_html__('Custom', 'strollik-core'),
					'csv'       => 'CSV' . esc_html__(' File','strollik-core')
				],
				'default'   => 'custom'
			]);

		$this->add_control('table_csv_type',
			[
				'label'     => esc_html__('File Type', 'strollik-core'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'file'      => esc_html__('Upload FIle', 'strollik-core'),
					'url'       => esc_html__('Remote File','strollik-core')
				],
				'condition' => [
					'table_data_type'   => 'csv',
				],
				'default'   => 'file'
			]);

		$this->add_control('table_csv',
			[
				'label'     => esc_html__('Upload CSV File', 'strollik-core'),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'table_data_type'   => 'csv',
					'table_csv_type'    => 'file'
				]
			]);

		$this->add_control('table_csv_url',
			[
				'label'     => esc_html__('File URL', 'strollik-core'),
				'type'      => Controls_Manager::TEXT,
				'label_block'   => true,
				'condition' => [
					'table_data_type'   => 'csv',
					'table_csv_type'    => 'url'
				]
			]);

		$this->end_controls_section();

		$this->start_controls_section('table_head_section',
			[
				'label'     => esc_html__('Head', 'strollik-core'),
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$head_repeater = new Repeater();

		$this->get_repeater_controls($head_repeater, array() );

		$this->add_control('table_head_repeater',
			[
				'label'         => esc_html__('Cell', 'strollik-core'),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $head_repeater->get_controls(),
				'default'       => [
					[
						'table_text'    => esc_html__('First Head', 'strollik-core'),
					],
					[
						'table_text'    => esc_html__('Second Head', 'strollik-core'),
					],
					[
						'table_text'    => esc_html__('Third Head', 'strollik-core'),
					]
				],
				'title_field'   =>  '{{{ table_text }}}',
				'prevent_empty' => false
			]
		);

		//Text Align

		$this->end_controls_section();

		$this->start_controls_section('table_body_section',
			[
				'label'     => esc_html__('Body', 'strollik-core'),
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$body_repeater = new Repeater();

		$body_repeater->add_control('table_elem_type',
			[
				'label'     => esc_html__('Type', 'strollik-core'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'cell'      => esc_html__('Cell', 'strollik-core'),
					'row'       => esc_html__('Row', 'strollik-core'),
				],
				'default'   => 'cell'
			]
		);

		$body_repeater->add_control('table_cell_type',
			[
				'label'     => esc_html__('Cell Type', 'strollik-core'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'td'        => esc_html__('Body', 'strollik-core'),
					'th'        => esc_html__('Head', 'strollik-core'),
				],
				'default'   => 'td',
				'condition'     => [
					'table_elem_type'   => 'cell'
				]
			]
		);

		$this->get_repeater_controls( $body_repeater, array( 'table_elem_type' => 'cell' ) );

		$body_repeater->add_control('table_link_switcher',
			[
				'label'         => esc_html__('Link', 'strollik-core'),
				'type'          => Controls_Manager::SWITCHER,
				'condition'     => [
					'table_elem_type'   => 'cell'
				]
			]
		);

		$body_repeater->add_control('table_link_selection',
			[
				'label'         => esc_html__('Link Type', 'strollik-core'),
				'type'          => Controls_Manager::SELECT,
				'options'       => [
					'url'   => esc_html__('URL', 'strollik-core'),
					'link'  => esc_html__('Existing Page', 'strollik-core'),
				],
				'default'       => 'url',
				'label_block'   => true,
				'condition'		=> [
					'table_link_switcher'	=> 'yes',
					'table_elem_type'       => 'cell'
				]
			]
		);

		$body_repeater->add_control('table_link',
			[
				'label'         => esc_html__('Link', 'strollik-core'),
				'type'          => Controls_Manager::URL,
				'default'       => [
					'url'   => '#',
				],
				'placeholder'   => 'https://premiumaddons.com/',
				'label_block'   => true,
				'separator'     => 'after',
				'condition'     => [
					'table_elem_type'       => 'cell',
					'table_link_switcher'	=> 'yes',
					'table_link_selection'  => 'url'
				]
			]
		);

		$this->add_control('table_body_repeater',
			[
				'label' 	=> __( 'Rows', 'strollik-core' ),
				'type' 		=> Controls_Manager::REPEATER,
				'default' 	=> [
					[
						'table_elem_type'           => 'row',
					],
					[
						'table_elem_type' 			=> 'cell',
						'table_text'                => esc_html__( 'Column #1', 'strollik-core' ),
					],
					[
						'table_elem_type' 			=> 'cell',
						'table_text'                => esc_html__( 'Column #2', 'strollik-core' ),
					],
					[
						'table_elem_type'           => 'cell',
						'table_text'                => esc_html__( 'Column #3', 'strollik-core' ),
					],
					[
						'table_elem_type'           => 'row',
					],
					[
						'table_elem_type'           => 'cell',
						'table_text'                => esc_html__( 'Column #1', 'strollik-core' ),
					],
					[
						'table_elem_type'           => 'cell',
						'table_text'                => esc_html__( 'Column #2', 'strollik-core' ),
					],
					[
						'table_elem_type'           => 'cell',
						'table_text'                => esc_html__( 'Column #3', 'strollik-core' ),
					],
				],
				'fields' 			=> array_values( $body_repeater->get_controls() ),
				'title_field' 		=> '{{ table_elem_type }}: {{{ table_text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('table_display',
			[
				'label'         => esc_html__('Display Options', 'strollik-core'),
			]
		);

		$this->add_responsive_control('table_width',
			[
				'label'         => esc_html__('Width', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%'],
				'range'         => [
					'px'    => [
						'min'   => 1,
						'max'   => 700
					]
				],
				'selectors'     => [
					'{{WRAPPER}} .elementor-widget-container' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control('table_responsive',
			[
				'label' 		=> esc_html__( 'Responsive', 'strollik-core' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'description'   => esc_html__( 'Enables scroll on mobile.', 'strollik-core' ),
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control('table_align',
			[
				'label'         => esc_html__( 'Table Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'flex-start'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'center',
				'selectors'     => [
					'{{WRAPPER}}' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('table_head_style',
			[
				'label'         => esc_html__('Head', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs('table_head_style_tabs');

		$this->start_controls_tab('table_odd_head_odd_style',
			[
				'label'     => esc_html__('Odd', 'strollik-core'),
			]
		);

		$this->add_control('table_odd_head_color',
			[
				'label'         => esc_html__('Text Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_odd_head_hover_color',
			[
				'label'         => esc_html__('Text Hover Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_odd_head_icon_color',
			[
				'label'         => esc_html__('Icon Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text i' => 'color: {{VALUE}};'
				],
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'table_odd_head_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'          => 'table_odd_head_text_shadow',
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text'
			]
		);

		$this->add_control('table_odd_head_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_odd_head_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_head_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd)'
			]
		);

		$this->add_control('table_odd_head_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_head_hover_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd):hover'
			]
		);

		$this->end_popover();

		$this->add_responsive_control('table_odd_head_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(odd) .opal-table-text' => 'justify-content: {{VALUE}};',
				],
				'condition'     => [
					'table_data_type' => 'csv'
				] ,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('table_head_even_style',
			[
				'label'     => esc_html__('Even', 'strollik-core'),
			]
		);

		$this->add_control('table_even_head_color',
			[
				'label'         => esc_html__('Text Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_even_head_hover_color',
			[
				'label'         => esc_html__('Text Hover Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_even_head_icon_color',
			[
				'label'         => esc_html__('Icon Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text i' => 'color: {{VALUE}};'
				],
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'table_even_head_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'          => 'table_even_head_text_shadow',
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text'
			]
		);

		$this->add_control('table_even_head_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_even_head_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_head_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even)'
			]
		);

		$this->add_control('table_even_head_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_head_hover_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even):hover'
			]
		);

		$this->end_popover();

		$this->add_responsive_control('table_even_head_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell:nth-child(even) .opal-table-text' => 'justify-content: {{VALUE}};',
				],
				'condition'     => [
					'table_data_type' => 'csv'
				] ,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_head_rows_border',
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell',
				'separator'     => 'before'
			]
		);

		$this->add_responsive_control('table_head_padding',
			[
				'label'         => esc_html__('Padding', 'strollik-core'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row th.opal-table-cell .opal-table-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('table_row_style',
			[
				'label'         => esc_html__('Rows', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs('table_row_style_tabs');

		$this->start_controls_tab('table_odd_row_odd_style',
			[
				'label'     => esc_html__('Odd', 'strollik-core'),
			]
		);

		$this->add_control('table_odd_row_color',
			[
				'label'         => esc_html__('Text Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell .opal-table-text' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_odd_row_hover_color',
			[
				'label'         => esc_html__('Text Hover Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell .opal-table-text:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_row_row_icon_color',
			[
				'label'         => esc_html__('Icon Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell .opal-table-text i' => 'color: {{VALUE}};'
				],
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'table_odd_row_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell .opal-table-text'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'          => 'table_odd_row_text_shadow',
				'selector'      => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell .opal-table-text'
			]
		);

		$this->add_control('table_odd_row_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_odd_row_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_row_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell'
			]
		);

		$this->add_control('table_odd_row_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_row_hover_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(odd) .opal-table-cell:hover'
			]
		);

		$this->end_popover();

		$this->end_controls_tab();

		$this->start_controls_tab('table_row_even_style',
			[
				'label'     => esc_html__('Even', 'strollik-core'),
			]
		);

		$this->add_control('table_even_row_color',
			[
				'label'         => esc_html__('Text Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell .opal-table-text' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_even_row_hover_color',
			[
				'label'         => esc_html__('Text Hover Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell .opal-table-text:hover' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_row_even_icon_color',
			[
				'label'         => esc_html__('Icon Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell .opal-table-text i' => 'color: {{VALUE}};'
				],
				'condition' => [
					'table_data_type'   => 'custom'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'table_even_row_typo',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
				'selector'      => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell .opal-table-text'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'          => 'table_even_row_text_shadow',
				'selector'      => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell .opal-table-text'
			]
		);

		$this->add_control('table_even_row_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_even_row_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_row_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell'
			]
		);

		$this->add_control('table_even_row_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_row_hover_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table tbody tr:nth-of-type(even) .opal-table-cell:hover'
			]
		);

		$this->end_popover();

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_row_border',
				'separator'		=> 'before',
				'selector'      => '{{WRAPPER}} .opal-table .opal-table-row td.opal-table-cell'
			]
		);

		$this->add_responsive_control('table_odd_row_padding',
			[
				'label'         => esc_html__('Padding', 'strollik-core'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row td.opal-table-cell .opal-table-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section('table_col_style',
			[
				'label'         => esc_html__('Columns', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE
			]
		);

		$this->start_controls_tabs('table_col_style_tabs');

		$this->start_controls_tab('table_odd_col_odd_style',
			[
				'label'     => esc_html__('Odd', 'strollik-core'),
			]
		);

		$this->add_control('table_odd_col_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_odd_col_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_col_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row .opal-table-cell:nth-child(odd)'
			]
		);


		$this->add_control('table_odd_col_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_odd_col_hover_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row .opal-table-cell:nth-child(odd):hover'
			]
		);

		$this->end_popover();

		$this->add_responsive_control('table_odd_col_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row .opal-table-cell:nth-child(odd) .opal-table-text' => 'justify-content: {{VALUE}};',
				],
				'condition'     => [
					'table_data_type' => 'csv'
				] ,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('table_col_even_style',
			[
				'label'     => esc_html__('Even', 'strollik-core'),
			]
		);

		$this->add_control('table_even_col_background_popover',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();

		$this->add_control('table_even_col_background_heading',
			[
				'label'             => esc_html__('Normal', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_col_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row .opal-table-cell:nth-child(even)'
			]
		);

		$this->add_control('table_even_col_hover_background_heading',
			[
				'label'             => esc_html__('Hover', 'strollik-core'),
				'type'              => Controls_Manager::HEADING
			]);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_even_col_hover_background',
				'types'             => [ 'classic', 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table .opal-table-row .opal-table-cell:nth-child(even):hover'
			]
		);

		$this->end_popover();

		$this->add_responsive_control('table_even_col_align',
			[
				'label'         => esc_html__( 'Alignment', 'strollik-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'      => [
						'title'=> esc_html__( 'Left', 'strollik-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center'    => [
						'title'=> esc_html__( 'Center', 'strollik-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right'     => [
						'title'=> esc_html__( 'Right', 'strollik-core' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default'       => 'left',
				'selectors'     => [
					'{{WRAPPER}} .opal-table .opal-table-row td.opal-table-cell:nth-child(even) .opal-table-text' => 'justify-content: {{VALUE}};',
				],
				'condition'     => [
					'table_data_type' => 'csv'
				] ,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section('table_sort_style',
			[
				'label'         => esc_html__('Sort', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE,
				'condition'     => [
					'table_sort'    => 'yes',
					'table_data_type!'  => 'csv'
				]
			]
		);

		$this->add_control('table_sort_color',
			[
				'label'         => esc_html__('Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_sort_hover_color',
			[
				'label'         => esc_html__('Hover Color', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_2,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table thead .opal-table-cell:hover .opal-table-sort-icon:before' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control('table_sort_background',
			[
				'label'         => esc_html__('Background', 'strollik-core'),
				'type'          => Controls_Manager::COLOR,
				'scheme'        => [
					'type'      => Scheme_Color::get_type(),
					'value'     => Scheme_Color::COLOR_1,
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before' => 'background: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_sort_border',
				'selector'      => '{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before'
			]
		);

		$this->add_control('table_sort_border_radius',
			[
				'label'         => esc_html__('Border Radius', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'          => 'table_sort_box_shadow',
				'selector'      => '{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before'
			]
		);

		$this->add_responsive_control('table_sort_padding',
			[
				'label'         => esc_html__('Padding', 'strollik-core'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table thead .opal-table-cell .opal-table-sort-icon:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('table_search_style',
			[
				'label'         => esc_html__('Search', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE,
				'condition'     => [
					'table_search'    => 'yes'
				]
			]
		);

		$this->add_control('table_search_width',
			[
				'label'         => esc_html__('Width', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'range'         => [
					'px'    => [
						'min'   => 1,
						'max'   => 300
					],
					'em'    => [
						'min'   => 1,
						'max'   => 20
					]
				],
				'selectors'     => [
					'{{WRAPPER}} .opal-table-search-field' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_search_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table-search-field',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_search_border',
				'selector'      => '{{WRAPPER}} .opal-table-search-field',
			]
		);

		$this->add_control('table_search_border_radius',
			[
				'label'         => esc_html__('Border Radius', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table-search-field' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'table_container_search_shadow',
				'selector'      => '{{WRAPPER}} .opal-table-search-field',
			]
		);

		$this->add_responsive_control('table_search_margin',
			[
				'label'         => esc_html__('Margin', 'strollik-core'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table-search-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control('table_search_padding',
			[
				'label'         => esc_html__('Padding', 'strollik-core'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table-search-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section('table_style',
			[
				'label'         => esc_html__('Table', 'strollik-core'),
				'tab'           => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'table_background',
				'types'             => [ 'classic' , 'gradient' ],
				'selector'          => '{{WRAPPER}} .opal-table',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'table_border',
				'selector'      => '{{WRAPPER}} .opal-table',
			]
		);

		$this->add_control('table_border_radius',
			[
				'label'         => esc_html__('Border Radius', 'strollik-core'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', '%' ,'em'],
				'selectors'     => [
					'{{WRAPPER}} .opal-table' => 'border-radius: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'table_box_shadow',
				'selector'      => '{{WRAPPER}} .opal-table',
			]
		);

		$this->end_controls_section();

	}

	protected function get_table_head(){
		$settings = $this->get_settings_for_display();


		$head = '';

		$this->add_render_attribute('table_head', 'class', 'opal-table-head');

		$this->add_render_attribute('table_row', 'class', 'opal-table-row');

		?>

		<thead <?php echo $this->get_render_attribute_string('table_head'); ?>>

		<tr <?php echo $this->get_render_attribute_string('table_row'); ?>>

			<?php foreach($settings['table_head_repeater'] as $index => $head_cell ) {

				$head_cell_text = $this->get_repeater_setting_key('table_text','table_head_repeater', $index);

				$this->add_render_attribute('head-cell-' . $index , 'class', 'opal-table-cell');
				$this->add_render_attribute('head-cell-' . $index , 'class', 'elementor-repeater-item-' . $head_cell['_id']);

				$this->add_render_attribute('head-text-' . $index, 'class', 'opal-table-text');

				if( 'top' == $head_cell['table_cell_icon_align'] && ('' != $head_cell['table_cell_icon'] || '' != $head_cell['table_cell_icon_img']['url'] ) ){
					$this->add_render_attribute('head-text-' . $index, 'class', 'opal-table-cell-top');
				}

				$this->add_render_attribute($head_cell_text, 'class', 'opal-table-inner');

				$this->add_inline_editing_attributes($head_cell_text, 'basic');

				if( $head_cell['table_cell_span'] > 1 ){
					$this->add_render_attribute('head-cell-'. $index,'colspan', $head_cell['table_cell_span']);
				}
				if( $head_cell['table_cell_row_span'] > 1 ){
					$this->add_render_attribute('head-cell-'. $index,'rowspan', $head_cell['table_cell_row_span']);
				}

				$head .= '<th ' . $this->get_render_attribute_string('head-cell-'. $index) . '>';
				$head .= '<span ' . $this->get_render_attribute_string('head-text-'. $index) . '>';
				if( '' != $head_cell['table_cell_icon'] || '' != $head_cell['table_cell_icon_img']['url']){

					$this->add_render_attribute('cell-icon-' . $index , 'class', 'opal-table-cell-icon-' . $head_cell['table_cell_icon_align']);
					$this->add_render_attribute('head-text-' . $index, 'class', 'opal-table-text');

					$head .= '<span ' . $this->get_render_attribute_string( 'cell-icon-' . $index ) . '>';
					if($head_cell['table_icon_selector'] == 'font-awesome-icon'){
						$head .= '<i class="' . esc_attr( $head_cell['table_cell_icon'] ) . '"></i>';
					} else {
						$head .= '<img src="' . esc_attr( $head_cell['table_cell_icon_img']['url'] ) . '">';
					}

					$head .= '</span>';
				}

				$head .= '<span ' . $this->get_render_attribute_string($head_cell_text) . '>' . $head_cell['table_text'] . '</span>';
				if ( 'yes' === $settings['table_sort'] ) {
					$head .= '<span class="opal-table-sort-icon opal-icon-sort fa fa-sort"></span>';
					$head .= '<span class="opal-table-sort-icon opal-icon-sort-up fa fa-sort-up"></span>';
					$head .= '<span class="opal-table-sort-icon opal-icon-sort-down fa fa-sort-down"></span>';
				}
				$head .= '</span>';
				$head .= '</th>';

			}

			echo $head;

			?>

		</tr>

		</thead>

	<?php }

	protected function is_first_elem_row() {
		$settings = $this->get_settings();

		if ( 'row' === $settings['table_body_repeater'][0]['table_elem_type'] )
			return false;

		return true;
	}

	protected function get_table_body(){

		$settings = $this->get_settings();

		$body = '';

		$counter 		= 1;

		$cell_counter 	= 0;

		$row_count 		= count( $settings['table_body_repeater'] );

		$this->add_render_attribute('table_body', 'class', 'opal-table-body');

		$this->add_render_attribute('table_row', 'class', 'opal-table-row');

		?>

		<tbody <?php echo $this->get_render_attribute_string('table_body'); ?>>
		<?php if($this->is_first_elem_row()) { ?>
			<tr <?php echo $this->get_render_attribute_string('table_row'); ?>
		<?php } ?>
		<?php foreach($settings['table_body_repeater'] as $index => $elem){

			$html_tag = 'span';

			$body_cell_text = $this->get_repeater_setting_key('table_text','table_body_repeater', $index);

			if( 'yes' == $elem['table_link_switcher']) {
				$html_tag = 'a';
				if($elem['table_link_selection'] == 'url'){
					$this->add_render_attribute('body-cell-text-' . $counter, 'href', $elem['table_link']['url']);
				} else {
					$this->add_render_attribute('body-cell-text-' . $counter, 'href', get_permalink($elem['table_existing_link']));
				}
				if($elem['table_link']['is_external']){
					$this->add_render_attribute('body-cell-text-' . $counter, 'target', '_blank');
				}
				if($elem['table_link']['nofollow']){
					$this->add_render_attribute('body-cell-text-' . $counter, 'rel', 'nofollow');
				}
			}

			if($elem['table_elem_type'] == 'cell'){
				$this->add_render_attribute('body-cell-' . $counter , 'class', 'opal-table-cell');
				$this->add_render_attribute('body-cell-' . $counter , 'class', 'elementor-repeater-item-' . $elem['_id']);

				$this->add_render_attribute('body-cell-text-' . $counter, 'class', 'opal-table-text');

				if( 'top' == $elem['table_cell_icon_align'] && ('' != $elem['table_cell_icon'] || '' != $elem['table_cell_icon_img']['url'] ) ){
					$this->add_render_attribute('body-cell-text-' . $counter, 'class', 'opal-table-cell-top');
				}

				$this->add_render_attribute($body_cell_text, 'class', 'opal-table-inner');

				$this->add_inline_editing_attributes($body_cell_text, 'basic');
				if( $elem['_id'] ){
					$this->add_render_attribute('body-cell-'.$counter,'id', $elem['_id']);
				}
				if( $elem['table_cell_span'] > 1 ){
					$this->add_render_attribute('body-cell-'. $counter,'colspan', $elem['table_cell_span']);
				}
				if( $elem['table_cell_row_span'] > 1 ){
					$this->add_render_attribute('body-cell-'. $counter,'rowspan', $elem['table_cell_row_span']);
				}

				$body .= '<' . $elem['table_cell_type'] . ' ' . $this->get_render_attribute_string('body-cell-' .$counter) . '>';
				$body .= '<' . $html_tag . ' ' . $this->get_render_attribute_string('body-cell-text-'.$counter ) . '>';
				if( '' != $elem['table_cell_icon'] || '' != $elem['table_cell_icon_img']['url']){
					$this->add_render_attribute('cell-icon-' . $counter , 'class', 'opal-table-cell-icon-' . $elem['table_cell_icon_align']);
					$body .= '<span ' . $this->get_render_attribute_string( 'cell-icon-' . $counter ) . '>';
					if($elem['table_icon_selector'] == 'font-awesome-icon'){
						$body .= '<i class="' . esc_attr( $elem['table_cell_icon'] ) . '"></i>';
					} else {
						$body .= '<img src="' . esc_attr( $elem['table_cell_icon_img']['url'] ) . '">';
					}
					$body .= '</span>';
				}
				$body .= '<span ' . $this->get_render_attribute_string($body_cell_text) . '>' . $elem['table_text'] . '</span>';
				$body .= '</span>';
				$body .= '</' . $html_tag .'>';
				$body .= '</' . $elem['table_cell_type'] .'>';
			} else {

				$this->add_render_attribute( 'body-row-' . $counter, 'class', 'opal-table-row' );
				$this->add_render_attribute( 'body-row-' . $counter, 'class', 'elementor-repeater-item-' . $elem['_id'] );

				if ( $counter > 1 && $counter < $row_count ) {
					$body .= '</tr><tr ' . $this->get_render_attribute_string( 'body-row-' . $counter ) . '>';

				} else if ( $counter === 1 && false === $this->is_first_elem_row() ) {
					$body .= '<tr ' . $this->get_render_attribute_string( 'body-row-' . $counter ) . '>';
				}

				$cell_counter = 0;
			}

			$counter++;
		}

		echo $body; ?>
		</tr>
		</tbody>

	<?php }


	protected function render(){
		$settings = $this->get_settings();

		$this->add_render_attribute('table_wrap', 'class', 'opal-table-wrap');
		if($settings['table_responsive'] == 'yes'){
			$this->add_render_attribute('table_wrap', 'class', 'opal-table-responsive');
		}

		$this->add_render_attribute('table', 'class', 'opal-table');

		if($settings['table_search'] == 'yes'){
			$this->add_render_attribute('table', 'class', 'opal-table-search');
		}

		if($settings['table_sort'] == 'yes'){
			$this->add_render_attribute('table', 'class', 'opal-table-sort');
		}

		$table_settings = [
			'sort'      => ($settings['table_sort'] == 'yes') ? true : false,
			'sortMob'   => ($settings['table_sort_mob'] == 'yes') ? true : false,
			'search'    => ($settings['table_search'] == 'yes') ? true : false,
			'dataType'  => $settings['table_data_type'],
			'csvFile'   => ($settings['table_csv_type'] == 'file') ? $settings['table_csv']['url'] : $settings['table_csv_url']
		];

		$this->add_render_attribute('table', 'data-settings', wp_json_encode($table_settings));
		?>

		<div <?php echo $this->get_render_attribute_string('table_wrap'); ?>>
			<?php if($settings['table_search'] == 'yes') : ?>
				<div class="opal-table-search-wrap">
					<input type="text" id="opal-table-search-field" class="opal-table-search-field" placeholder="Live Search...">
				</div>

			<?php endif; ?>
			<table <?php echo $this->get_render_attribute_string('table'); ?>>

				<?php $this->get_table_head(); ?>
				<?php if(!empty($settings['table_body_repeater'])) : $this->get_table_body(); endif; ?>

			</table>
		</div>

	<?php }

}