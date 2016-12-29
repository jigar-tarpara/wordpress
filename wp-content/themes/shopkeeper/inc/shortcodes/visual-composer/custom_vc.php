<?php

// remove elements
vc_remove_element("vc_wp_search");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_links");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_posts_slider");
vc_remove_element("vc_posts_grid");
vc_remove_element("vc_carousel");
vc_remove_element("vc_cta_button");
vc_remove_element("vc_cta_button2");
vc_remove_element("vc_button");
vc_remove_element("vc_flickr");
vc_remove_element("vc_gallery");
vc_remove_element("vc_images_carousel");
vc_remove_element("vc_tour");
vc_remove_element("vc_gmaps");
vc_remove_element("vc_message");
vc_remove_element("vc_round_chart");
vc_remove_element("vc_line_chart");

//vc_remove_param("vc_row", "full_width");

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Row Type (Deprecated)",
	"param_name" => "type",
	"value" => array(
		"Full Width" => "full_width",
		"Boxed" => "boxed"
	)
));

/*vc_add_param("vc_row", array(
	"type"			=> "colorpicker",
	"holder"		=> "div",
	"class" 		=> "hide_in_vc_editor",
	"admin_label" 	=> true,
	"heading"		=> "Font Color",
	"param_name"	=> "font_color",
	"value"			=> "#000",
));*/

vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Height",
	"param_name" => "height",
	"value" => "",
	"description" => ""
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Columns Height",
	"param_name" => "columns_height",
	"value" => array(
		"Normal" => "normal_height",
		"Fit Columns Height" => "adjust_cols_height"
	)
));

// [vc_row_inner]
vc_add_param("vc_row_inner", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Row Type (Deprecated)",
	"param_name" => "type",
	"value" => array(
		"Full Width" => "full_width",
		"Boxed" => "boxed"
	)
));

/*vc_add_param("vc_text_separator", array(
	"type" => "textfield",
	"class" => "hide_in_vc_editor",
	"admin_label" => false,
	"heading" => "Font Size",
	"param_name" => "font_size",
	"value" => "",
	"description" => "ex.: 18px"
));*/

/*vc_add_param("vc_text_separator", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => false,
	"heading" => "Border",
	"param_name" => "style",
	"value" => array(
		"No Border" => "no_border",
		"Border" => "border"
	)
));*/

/*vc_add_param("vc_button2", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Style",
	"param_name" => "style",
	"value" => array(
		"Square" => "square",
		"Square Outlined" => "square_outlined",
		"Rouded" => "rounded",
		"Rouded Outlined" => "rounded_outlined",
		"Link" => "link"
	)
));

vc_add_param("vc_button2", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Align",
	"param_name" => "align",
	"value" => array(
		"Left" => "left",
		"Center" => "center",
		"Right" => "right"
	)
));

vc_add_param("vc_button2", array(
	"type"			=> "colorpicker",
	"holder"		=> "div",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading"		=> "Text Color",
	"param_name"	=> "text_color",
	"value"			=> "#fff",
));

vc_add_param("vc_button2", array(
	"type"			=> "colorpicker",
	"holder"		=> "div",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading"		=> "Background Color",
	"param_name"	=> "bg_color",
	"value"			=> "#000",
	"dependency" 	=> Array('element' => "style", 'value' => array('square','rounded'))
));
*/

/*vc_add_param("vc_single_image", array(
	"type" => "textfield",
	"class" => "hide_in_vc_editor",
	"admin_label" => false,
	"heading" => "Image size",
	"param_name" => "img_size",
	"value" => "full",
	"description" => 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.'
));

vc_add_param("vc_pie", array(
	"type" => "dropdown",
	"class" => "hide_in_vc_editor",
	"admin_label" => true,
	"heading" => "Type",
	"param_name" => "pie_type",
	"value" => array(
		"With Pie" => "with_pie",
		"Without Pie" => "without_pie"
	)
));*/