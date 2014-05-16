<?php
/*
Plugin Name: GoogleGraph
Plugin URI: http://tsba.mobi/google-graph
Description: Generate Google Chart.
Version: 0.2.1
Author: Jordan Vrtanoski
Author Email: jordan.vrtanoski@tsba.mobi
License:

  Copyright 2014 Jordan Vrtanoski <jordan.vrtanoski@tsba.mobi>

  This program is free software; you can redistribute it and/or modify
  it under the terms of the Creative Commons Attribution-NonCommercial 4.0 
  International (CC BY-NC 4.0)

  You can use this script in your non-commercial work by you must give credits
  to us by placing the following <a> tag on a visable arrea on your web site:

  <a href="http://tsba.mobi" title="Premium WordPress Developers">GoogleGraphs by TSBA.mobi</a>

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  http://creativecommons.org/licenses/by-nc/4.0/

  The chart is supported by Google Visualisation API (Google Charts). The javascript
  is owned by Google.
  https://google-developers.appspot.com/chart/interactive/docs/gallery
*/

class GoogleGraph {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'GoogleGraph';
	const slug = 'googlegraph';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_googlegraph' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_googlegraph' ) );
	}
  
	/**
	 * Runs when the plugin is activated
	 */  
	function install_googlegraph() {
		// do not generate any output here
	}
  
	/**
	 * Runs when the plugin is initialized
	 */
	function init_googlegraph() {
		// Setup localization
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		// Load JavaScript and stylesheets
		$this->register_scripts_and_styles();

		// Register the shortcode [barGraph]
		add_shortcode( 'lineChart', array( &$this, 'render_linechart' ) );
		add_shortcode( 'columnChart', array( &$this, 'render_column' ) );
		add_shortcode( 'barChart', array( &$this, 'render_bargraph' ) );
		add_shortcode( 'pieChart', array( &$this, 'render_piechart' ) );
		add_shortcode( 'geoChart', array( &$this, 'render_geochart' ) );
	
		if ( is_admin() ) {
			//this will run when in the WordPress admin
		} else {
			//this will run when on the frontend
		}

		/*
		 * TODO: Define custom functionality for your plugin here
		 *
		 * For more information: 
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'your_action_here', array( &$this, 'action_callback_method_name' ) );
		add_filter( 'your_filter_here', array( &$this, 'filter_callback_method_name' ) );    
	}

    function render_linechart($atts, $content = null) {
         return $this->render_chart('LineChart', $atts, $content);
    }

    function render_column($atts, $content = null) {
         return $this->render_chart('ColumnChart', $atts, $content);
    }

    function render_bargraph($atts, $content = null) {
         return $this->render_chart('BarChart', $atts, $content);
    }

    function render_piechart($atts, $content = null) {
         return $this->render_chart('PieChart', $atts, $content);
    }

    function render_geochart($atts, $content = null) {
         return $this->render_chart('GeoChart', $atts, $content);
    }   

	function action_callback_method_name() {
		// TODO define your action method here
	}

	function filter_callback_method_name() {
		// TODO define your filter method here
	}

	function render_chart($type, $atts, $content) {
		// Extract the attributes
		extract(shortcode_atts(array(
			'width' => '600px', //foo is a default value
			'height' => '400px',
			'title' => '',
			'stacked' => 'false',
			'legend' => "{position: 'bottom', maxLines: 3}",
			'vaxis' => "{title: 'Y',  titleTextStyle: {color: 'red'}}",
			'haxis' => "{title: 'X',  titleTextStyle: {color: 'red'}}",
			'curvetype' => NULL,
			'displaymode' => NULL,
			'region' => NULL,
			'colorstart' => NULL,
			'colorend' => NULL
			), $atts));
		// you can now access the attribute values using $attr1 and $attr2

    global $item_id;
    $item_id++;
    
    // Prepare the curve option for line chart types
    $otheroptions="";
    if ($type === "LineChart") {
	    if (!is_null($curvetype)) {
       		$otheroptions= $otheroptions."curveType: '$curvetype',";
    	}
    }

    if ($type === "GeoChart") {
	    if (!is_null($displaymode)) {
       		$otheroptions= $otheroptions."displayMode: '$displaymode',";
    	}
	    if (!is_null($region)) {
       		$otheroptions= $otheroptions."region: '$region',";
    	}
	    if (!is_null($colorstart) && !is_null($colorend)) {
       		$otheroptions= $otheroptions."colorAxis: {colors: ['$colorstart', '$colorend']} ,";
    	}
    }
       
    $str = <<<EOT
		
    <div id="chart_div_$item_id" class="gc_$type" style="width: $width; height: $height;"></div>
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			$content
        ]);

        var options = {
          $otheroptions
          title: '$title',
          vAxis: $vaxis,
          hAxis: $haxis,
          isStacked: $stacked,
          legend: $legend
        };

        var chart = new google.visualization.$type(document.getElementById('chart_div_$item_id'));
        chart.draw(data, options);
      }
    </script>

EOT;
		return $str;
	}
  
	/**
	 * Registers and enqueues stylesheets for the administration panel and the
	 * public facing site.
	 */
	private function register_scripts_and_styles() {
	    wp_register_script( self::slug . '-jsapi-script', 'https://www.google.com/jsapi');
	    wp_enqueue_script( self::slug . '-jsapi-script');
	    
	} // end register_scripts_and_styles
	
	/**
	 * Helper function for registering and enqueueing scripts and styles.
	 *
	 * @name	The 	ID to register with WordPress
	 * @file_path		The path to the actual file
	 * @is_script		Optional argument for if the incoming file_path is a JavaScript source file.
	 */
	private function load_file( $name, $file_path, $is_script = false ) {

		$url = plugins_url($file_path, __FILE__);
		$file = plugin_dir_path(__FILE__) . $file_path;

		if( file_exists( $file ) ) {
			if( $is_script ) {
				wp_register_script( $name, $url, array('jquery') ); //depends on jquery
				wp_enqueue_script( $name );
			} else {
				wp_register_style( $name, $url );
				wp_enqueue_style( $name );
			} // end if
		} // end if

	} // end load_file
  
} // end class
new GoogleGraph();

?>