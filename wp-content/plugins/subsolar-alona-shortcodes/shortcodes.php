<?php


/*===========================================================*/
/*	Button
/*===========================================================*/

if ( !function_exists('sdesigns_button') ) {
	function sdesigns_button( $atts, $content = null ) {
		$defaults = array(
			'to' => '#'
			);
		extract( shortcode_atts( $defaults, $atts ) );

		return '<a href="' . $to . '" class="button">'. do_shortcode($content) .'</a>';
	}
	add_shortcode( 'button', 'sdesigns_button' );
}


/*===========================================================*/
/*	Blockquote
/*===========================================================*/

if ( !function_exists('sdesigns_blockquote') ) {
	function sdesigns_blockquote( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );

		return '<blockquote>'. do_shortcode($content) .'</blockquote>';
	}
	add_shortcode( 'blockquote', 'sdesigns_blockquote' );
}


/*===========================================================*/
/*	Highlight
/*===========================================================*/

if ( !function_exists('sdesigns_highlight') ) {
	function sdesigns_highlight( $atts, $content = null ) {
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );

		return '<span class="highlight">'. do_shortcode($content) .'</span>';
	}
	add_shortcode( 'highlight', 'sdesigns_highlight' );
}


/*===========================================================*/
/*	Tabs
/*===========================================================*/

if ( !function_exists('sdesigns_tabs') ) {
	function sdesigns_tabs( $atts, $content = null ) {

		if( isset( $GLOBALS['tabs_count'] ) )
			$GLOBALS['tabs_count']++;
		else
			$GLOBALS['tabs_count'] = 0;

		$GLOBALS['tabs_default_count'] = 0;

		extract( shortcode_atts( array(), $atts ) );

		$ul_class = 'nav nav-tabs';

		$div_class = 'tab-content';

		$id = 'custom-tabs-'. $GLOBALS['tabs_count'];

		$atts_map = sdesigns_attribute_map( $content );

    	// Extract the tab titles for use in the tab widget.
		if ( $atts_map ) {
			$tabs = array();
			$GLOBALS['tabs_default_active'] = true;
			foreach( $atts_map as $check ) {
				if( !empty($check["tab"]["active"]) ) {
					$GLOBALS['tabs_default_active'] = false;
				}
			}
			$i = 0;
			foreach( $atts_map as $tab ) {
				$tabs[] = sprintf(
					'<li%s><a href="#%s" data-toggle="tab">%s</a></li>',
					( !empty($tab["tab"]["active"]) || ($GLOBALS['tabs_default_active'] && $i == 0) ) ? ' class="active"' : '',
					'custom-tab-' . $GLOBALS['tabs_count'] . '-' . sanitize_title( $tab["tab"]["title"] ),
					$tab["tab"]["title"]
					);
				$i++;
			}
		}
		return sprintf(
			'<ul class="%s" id="%s">%s</ul><div class="%s">%s</div>',
			esc_attr( $ul_class ),
			esc_attr( $id ),
			( $tabs )  ? implode( $tabs ) : '',
			esc_attr( $div_class ),
			do_shortcode( $content )
			);
	}
	add_shortcode( 'tabs', 'sdesigns_tabs' );
}


if ( !function_exists('sdesigns_tab') ) {
	function sdesigns_tab( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'title'   => false,
			'active'  => false
			), $atts ) );

		if( $GLOBALS['tabs_default_active'] && $GLOBALS['tabs_default_count'] == 0 ) {
			$active = true;
		}
		$GLOBALS['tabs_default_count']++;

		$class  = 'tab-pane';
		$class .= ( $active == 'true' ) ? ' active' : '';

		$id = 'custom-tab-'. $GLOBALS['tabs_count'] . '-'. sanitize_title( $title );

		return sprintf(
			'<div id="%s" class="%s">%s</div>',
			esc_attr( $id ),
			esc_attr( $class ),
			do_shortcode( $content )
			);

	}
	add_shortcode( 'tab', 'sdesigns_tab' );
}

/*===========================================================*/
/*	Accordion
/*===========================================================*/

if ( !function_exists('sdesigns_collapsibles') ) {
	function sdesigns_collapsibles( $atts, $content = null ) {

		if( isset($GLOBALS['collapsibles_count']) )
			$GLOBALS['collapsibles_count']++;
		else
			$GLOBALS['collapsibles_count'] = 0;

		extract( shortcode_atts( array(), $atts ) );

		$id = 'custom-collapse-'. $GLOBALS['collapsibles_count'];

		return sprintf(
			'<div class="panel-group" id="'. esc_attr( $id ) .'">'. do_shortcode( $content ) .'</div>'
			);
	}
	add_shortcode('collapsibles', 'sdesigns_collapsibles');
}

if ( !function_exists('sdesigns_collapse') ) {
	function sdesigns_collapse( $atts, $content = null ) {

		extract( shortcode_atts( array(
			"title"   => false,
			"active"  => false
			), $atts ) );

		$collapse_class = 'panel-collapse collapse';
		$collapse_class .= ( $active == 'true' )  ? ' in' : ' collapse';

		$parent = 'custom-collapse-'. $GLOBALS['collapsibles_count'];
		$current_collapse = $parent . '-'. sanitize_title( $title );

		return sprintf(
			'<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#' . $parent . '" href="#' .  $current_collapse . '">' . $title . '</a>
				</h4>
			</div>
			<div id="' . $current_collapse . '" class="' . esc_attr( $collapse_class ) . '">
				<div class="panel-body">' . do_shortcode( $content ) . '</div>
			</div>
		</div>'
		);
	}
	add_shortcode('collapse', 'sdesigns_collapse');
}

/*===========================================================*/
/*	Columns
/*===========================================================*/

if ( !function_exists('sdesigns_row') ) {
	function sdesigns_row( $atts, $content = null ) {
		return '<div class="row">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'row', 'sdesigns_row' );
}
if ( !function_exists('sdesigns_one_half') ) {
	function sdesigns_one_half( $atts, $content = null ) {
		return '<div class="col-md-6">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'one_half', 'sdesigns_one_half' );
}

if ( !function_exists('sdesigns_one_third') ) {
	function sdesigns_one_third( $atts, $content = null ) {
		return '<div class="col-md-4">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'one_third', 'sdesigns_one_third' );
}

if (!function_exists('sdesigns_one_fourth') ) {
	function sdesigns_one_fourth( $atts, $content = null ) {
		return '<div class="col-md-3">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'one_fourth', 'sdesigns_one_fourth' );
}

if ( !function_exists('sdesigns_two_thirds') ) {
	function sdesigns_two_thirds( $atts, $content = null ) {
		return '<div class="col-md-8">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'two_thirds', 'sdesigns_two_thirds' );
}

if ( !function_exists('sdesigns_three_fourths') ) {
	function sdesigns_three_fourths( $atts, $content = null ) {
		return '<div class="col-md-9">'
		.do_shortcode($content).
		'</div>';
	}
	add_shortcode( 'three_fourths', 'sdesigns_three_fourths' );
}


?>