=== GoogleGraph ===
Contributors: jvrtanoski
Donate link: http://tsba.mobi
Tags: google, graphs, charts, geo-chart
Requires at least: 3.8
Tested up to: 3.9.1
Stable tag: 0.2.1
License: CC BY-NC 4.0
License URI: http://creativecommons.org/licenses/by-nc/4.0/

Plugin allows the blog authors to add simple but effective geo-chart, bar-charts or line graphs in their blogs using Google's Chart .js library.

== Description ==
Plugin that will allow the blog authors to add simple but effective geo-chart, bar-charts or line graphs in their blogs. 
The plug-in provides shortcodes for each chart type. The short codes can be placed anywhere in the text of the post/page
and the plug-in will render the chart in the place of the short code. The data for the chart is placed in form of table
insite the shortcode tag. For more details see the samples in the FAQ section.
The charts are based on Google's Javascript charts library, and the format of the data table is determined by the library itself.
For more details see the help pages of the Google Chart library.


== Installation ==
1. Upload the content of the ZIP archive to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Use shortcodes in the text where you want the chart to appear


== Frequently Asked Questions ==
= Supported shortcodes =
* geoChart
* lineChart
* columnChart
* barChart
* pieChart

= General format of the shortcodes =

The detailed user manual can be found on our website http://tsba.mobi/project/googlegraph-wp-plug-in/

The shortcodes in this plug-in have general format of [tpeOfGraph] data [/typeOfGraph]. The data in the shortcodes is in JSON format as expected by Google's JavaScript library.
For more details on the supported options for each chart, refer to the google's developer page at https://google-developers.appspot.com/chart/interactive/docs/gallery

= Geo Chart =
`[geoChart width="700px" height="700px" ]
	['Country', 'Popularity'],
	['Germany', 200],
	['United States', 300],
	['Brazil', 400],
	['Canada', 500],
	['France', 600],
	['RU', 700]
[/geoChart]`

Google geo chart supports the "market" mode of display, and also allows you to specify the region of interest. We had exposed this functionality to the short code in order to achieve the following type of charts:

`[geoChart width="700px" height="700px" displaymode="markers" region="MK"]
	['City', 'Population', 'Area'],
	['Skopje', 2761477, 1285.31],
	['Bitola', 1324110, 181.76],
	['Prilep', 959574, 117.27],
	['Ohrid', 907563, 130.17],
	['Shtip', 655875, 158.9],
	['Gevgelija', 607906, 243.60],
	['Resen', 380181, 140.7],
	['Kriva Palanka', 371282, 102.41],
	['Kavadarci', 67370, 213.44],
	['Negotino', 52192, 43.43],
	['Tetovo', 38262, 11]
[/geoChart]`

We have also added the ability to control the colour gradient

`[geoChart width="700px" height="700px" colorstart="#e7711c" colorend="#4374e0"]
	['Country', 'Popularity'],
	['Germany', 200],
	['United States', 300],
	['Brazil', 400],
	['Canada', 500],
	['France', 600],
	['RU', 700]
[/geoChart]`

= Line Chart =

The line chart short is activated by a short code [  lineChart  ].

`[lineChart width="600px" height="500px" 
	legend="{ position: 'top', maxLines: 1 }" 
	vaxis="{title: '$k', titleTextStyle: {color: 'black'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'black'}}" curvetype="none"]
		['Year', 'Sales', 'Expenses'],
		['2004',  1000,      400],
		['2005',  1170,      460],
		['2006',  660,       1120],
		['2007',  1030,      540]
[/lineChart]`

We have also enabled the "function" rendering in order to create smooth curved line charts as in this example

`[lineChart curvetype="function" width="600px" height="500px" stacked="1" 
	legend="{ position: 'top', maxLines: 1 }" 
	vaxis="{title: '$k', titleTextStyle: {color: 'black'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'black'}}" 
	curvetype="function"]
		['Year', 'Sales', 'Expenses'],
		['2004',  1000,      400],
		['2005',  1170,      460],
		['2006',  660,  1120],
		['2007',  1030,      540]
[/lineChart]`

= Column Chart =

The column chart type is activated by a short code [  columnChart  ].

`[columnChart  width="500px" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $000', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'blue'}}"]
		['Year', 'Sales', 'Expenses'],
		['2004', 1000, 400],
		['2005', 1170, 460],
		['2006', 660, 1120],
		['2007', 1030, 540]
[/columnChart]`

Adding a visual style to the columns is very easy and done as annotation on the data in the short code. Here is one example of styled columns

`[columnChart  width="300px" stacked="1" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $000', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'blue'}}"]
		['Year', 'Visitations', { role: 'style' } ],
		['2010', 10, 'color: gray'],
		['2010', 14, 'color: #76A7FA'],
		['2020', 16, 'opacity: 0.2'],
		['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
		['2040', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
[/columnChart]`

Columns can be stacked on top of each other in the following example

`[columnChart  width="500px" stacked="1" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $M', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Period', titleTextStyle: {color: 'blue'}}"]
		['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General','Western', 'Literature', { role: 'annotation' } ],
		['2010', 10, 24, 20, 32, 18, 5, ''],
		['2020', 16, 22, 23, 30, 16, 9, ''],
		['2030', 28, 19, 29, 30, 12, 13, ''],
[/columnChart]`

= Bar Chart =

The bar chart can be created by adding the short code [  barChart  ]

`[barChart  width="500px" stacked="1" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $000', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'blue'}}"]
		['Year', 'Sales', 'Expenses'],
		['2004', 1000, 400],
		['2005', 1170, 460],
		['2006', 660, 1120],
		['2007', 1030, 540]
[/barChart]`

The modified style

`[barChart  width="500px" stacked="1" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $000', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Year', titleTextStyle: {color: 'blue'}}"]
		['Year', 'Visitations', { role: 'style' } ],
		['2010', 10, 'color: gray'],
		['2010', 14, 'color: #76A7FA'],
		['2020', 16, 'opacity: 0.2'],
		['2040', 22, 'stroke-color: #703593; stroke-width: 4; fill-color: #C5A5CF'],
		['2040', 28, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 8; fill-color: #BC5679; fill-opacity: 0.2']
[/barChart]`

and the bars stacked / connected with each other

`[barChart  width="500px" stacked="1" 
	legend="{ position: 'top', maxLines: 2 }" 
	vaxis="{title: 'in $M', titleTextStyle: {color: 'blue'}}" 
	haxis="{title: 'Period', titleTextStyle: {color: 'blue'}}"]
		['Genre', 'Fantasy & Sci Fi', 'Romance', 'Mystery/Crime', 'General','Western', 'Literature', { role: 'annotation' } ],
		['2010', 10, 24, 20, 32, 18, 5, ''],
		['2020', 16, 22, 23, 30, 16, 9, ''],
		['2030', 28, 19, 29, 30, 12, 13, ''],
[/barChart]`

= Pie Chart =

The pie chart is triggered by short code [  pieChart  ]

`[pieChart width="400px" ]
	['Task', 'Hours per Day'],
	['Work',     11],
	['Eat',      2],
	['Commute',  2],
	['Watch TV', 2],
	['Sleep',    7]
[/pieChart]`

At the moment we support only the basic pie chart, however we plan to add the 3D and Donut type soon.

== Screenshots ==
1. Geo Chart
2. Line Chart
3. Bar Chart

== Changelog ==
= 0.1 =
* Initial Release
= 0.2 =
* Minor changes on the readme.txt file
* Cleanup for WordPress.org submission
= 0.2.1 =
* Fixing the versioning across the files
* Moving Screenshots to assets folder

== Upgrade Notice ==
= 0.2 =
Update to have correct version file