<?php
/**
 * Plugin Name: Woo Product Design BenignSource
 * Plugin URI: http://www.benignsource.com/
 * Description: Woo Product Design make your products with different designs and style!
 * Author: BenignSource
 * Author URI: http://www.benignsource.com/
 * Version: 1.0
 * Tested up to: 5.9
 */

defined( 'ABSPATH' ) or exit;

// Check if WooCommerce is active and bail if it's not
if ( ! WooCommerceProductDesignBenignSource::is_woocommerce_activecpbs() ) {
	return;
}

class WooCommerceProductDesignBenignSource {

	private $pdbs_product_design = false;
	

	/** plugin version number */
	const VERSION = '1.0';

	/** @var WooCommerceProductDesignBenignSource single bsproductdesign of this plugin */
	protected static $bsproductdesign;
	

	/** plugin version name */
	const VERSION_OPTION_NAME = 'woocommerce_product_design_db_version';


	/*
	 * WooCommerce is known to be active and initialized
	 */
	public function __construct() {
		// Installation
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) $this->install();

		add_action( 'init',             array( $this, 'load_translation' ) );
		add_action( 'woocommerce_init', array( $this, 'init' ) );
	}


	/**
	 * Cloning instances is forbidden due to singleton pattern.
	 */
	public function __clone() {

		/* translators: Placeholders: %s - plugin name */
		_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( 'You cannot clone instances of %s.', 'woo-product-design-benignsource' ), 'Woo Product Design BenignSource' ), '1.0' );
	}


	/*
	 * Unserializing instances is forbidden due to singleton pattern.
	 */
	public function __wakeup() {

		/* translators: Placeholders: %s - plugin name */
		_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( 'You cannot unserialize instances of %s.', 'woo-product-design-benignsource' ), 'Woo Product Design BenignSource' ), '1.0' );
	}

    /**
	 * Init Woo Product Design extension once we know WooCommerce is active
	 */
	public function init() {
		// backend stuff
		add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'woo_product_design_write_panel_tab' ) );
		add_action( 'woocommerce_product_write_panels',     array( $this, 'woo_product_design_write_panel' ) );
		add_action( 'woocommerce_process_product_meta',     array( $this, 'woo_product_design_save_data' ), 10, 2 );
		

// Actions
add_filter( 'woocommerce_before_add_to_cart_button', 'product_payment_option' );
add_action( 'woocommerce_single_product_summary', 'product_design_benignsource_logo' );
add_filter( 'woocommerce_product_thumbnails', 'product_design_benignsource_sample_text' );



function product_design_benignsource_logo() {
global $wp_query;
$pdbs_product_design_logo = maybe_unserialize( get_post_meta( $wp_query->post->ID, 'pdbs_woo_product_design', true ) );
foreach ( $pdbs_product_design_logo as $productdesign ){  
if ($productdesign['logo'] == null ){

} else{
echo '<a href="' . $productdesign['logolink'] . '"><img src="' . $productdesign['logo'] . '" alt="' . $productdesign['logotitle'] . '" width="150px" border="0px" title="' . $productdesign['logotitle'] . '" /></a>';
  }
 }
}

function product_design_benignsource_sample_text() {
global $wp_query;
$pdbs_product_design_text = maybe_unserialize( get_post_meta( $wp_query->post->ID, 'pdbs_woo_product_design', true ) );
foreach ( $pdbs_product_design_text as $productdesign ){  
if ($productdesign['sample_text'] == null ){

} else{
echo '<h4 style="text-align: center;">' . $productdesign['sample_text'] . '</h4>';
  }
 }
}


function product_design_benignsource() {
global $wp_query;
$pdbs_product_design = maybe_unserialize( get_post_meta( $wp_query->post->ID, 'pdbs_woo_product_design', true ) );
foreach ( $pdbs_product_design as $productdesign ){
$productcpbs = new WC_Product($productdesign['pdproductid']);
echo '<!--Woo Product Design BenignSource-->';
echo '<div style="background:url(' . $productdesign['product_image_background'] . ');width:100%; float:left;height:' . $productdesign['product_header_height'] . ';">';
echo '<div style="width:90%;margin:0 auto;">
<div style="width:50%;margin-top:50px; float:left;opacity: 0.7; margin-right:10px; background:' . $productdesign['layout_onecolor'] . '; padding:20px; font-size:' . $productdesign['layout_textonesize'] . '; color:' . $productdesign['layout_textonecolor'] . '; font-family:' . $productdesign['layout_textonefontfamily'] . ';font-style:' . $productdesign['layout_textonefontstyle'] . ';">' . $productdesign['layouttextone'] . '</div>';
echo '</div></div>';
echo '<!--Woo Product Design BenignSource-->';
  }
 }
function product_payment_option() {
global $wp_query;
$pdbs_product_design = maybe_unserialize( get_post_meta( $wp_query->post->ID, 'pdbs_woo_product_design', true ) );

foreach ( $pdbs_product_design as $productdesign ){
if ($productdesign['payment_method'] == null ){
} else{
echo '<div style="width:100%;">' . $productdesign['payment_method_text'] . '</div>'
?>
<div style="width:100%; padding-bottom:20px;"><?php echo '<img src="' . esc_attr( plugins_url( 'img/', __FILE__ ) ) . '' . $productdesign['payment_method'] . '" alt="Woo Product Design BenignSource" border="0px"> ';?></div>
<?php
   }
  }
 }
}
	/**
	 * Adds Woo Product Design Data postbox in the admin product interface
	 */
public function woo_product_design_write_panel_tab() {
		echo "<li class=\"product_design_tab\"><a href=\"#woocommerce_product_design_benignsource\">" . __( 'Woo Product Design', 'woocommerce_product_design' ) . "</a></li>";
	}

	/**
	 * Adds Woo Product Design Data postbox in the product interface
	 */
public function woo_product_design_write_panel() {
global $post;
// the product

// pull the data out of the database
$pdbs_product_design = maybe_unserialize( get_post_meta( $post->ID, 'pdbs_woo_product_design', true ) );
		if ( empty( $pdbs_product_design ) ) {
			$pdbs_product_design[] = array( 'payment_method' => '', 'logo' => '', 'logotitle' => '', 'logolink' => '', 'layouttextone' => '', 'layout_onecolor' => '', 'layout_textonecolor' => '', 'layout_textonesize' => '', 'layout_textonefontfamily' => '', 'layout_textonefontstyle' => '', 'product_header_height' => '', 'product_image_background' => '',  'pdproductid' => '', 'sample_text' => '' );
}
foreach ( $pdbs_product_design as $productdesign ) {
echo '<div id="woocommerce_product_design_benignsource" class="panel wc-metaboxes-wrapper woocommerce_options_panel">';
?>
<ul class="tabdesignbs">
<li style="color:#FFFFFF; padding:10px; font-size:18px;">Woo Product Design</li>
<li style="float:right;"><?php echo '<img src="' . esc_attr( plugins_url( 'logo_design.jpg', __FILE__ ) ) . '" alt="Woo Product Design BenignSource" border="0px"> ';?></li></ul>
<?php

echo '<div style="padding:15px;">';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;"><i>Select Payment Method To Show</i></div>';
echo '<div style="">';
woocommerce_wp_select( array( 'id' => '_pdbs_product_design_payment_method', 'label' => __( 'Select Payment Method', 'woocommerce_product_design' ), 'name' => $productdesign['payment_method[]'], 'options' => array(
        '' . $productdesign['payment_method'] . ''  => $productdesign['payment_method'],
		'' => 'None',
		'paypal.png' => 'PayPal',
		'visa.png' => 'Visa',
		'master.png' => 'MasterCard',
		'discover.png' => 'Discover',
		'express.png' => 'American Express',
		'pay_visa_master.png' => 'PayPal Visa MasterCard',
		'visa_master.png' => 'Visa MasterCard',
		'visa_master_disc.png' => 'Visa MasterCard Discover',
		'visa_master_disc_expr.png' => 'Visa MasterCard Discover American',
		'small_cart.png' => 'All Card',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';	
woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_payment_method_text', 'label' => __( 'Payment Method Text', 'woocommerce_product_design' ), 'placeholder' => __( 'We Accept', 'woocommerce_product_design' ), 'value' => $productdesign['payment_method_text'], 'style' => 'width:70%;' ) );
echo '</div>';
?>
<?php 
echo '<div style="padding:15px;">';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;"><i>Upload Manufacture / Brand Logo</i></div>';
woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_logo', 'value' => $productdesign['logo'], 'style' => 'display:none;' ) );
?>
<div id="background-product-images" style="padding:10px;">
<div class="inside">
<div id="background_images_container" >
<ul class="product_images">
<?php 
if ($productdesign['logo'] == null ){
echo '<li class="image" style="width:150px;"><div id="upload-logo" style="padding:27px; font-size:16px; cursor:pointer;">Upload Logo</div>';
} else {?>
<li style="width:150px">
<a style="padding:4px; padding-left:15px; padding-right:15px; font-size:14px; background:#330000;border-radius:3px; color:#FFFFFF; text-decoration:none;" href="javascript:void(0);" onclick="return ClearTextBox('_pdbs_product_design_logo');" class="deletelogo" tabindex="0">Delete</a>
<p class="hidelogo" ><img width="150px" src="<?php echo $productdesign['logo']; ?>" /></p>
<?php }?>
</li></ul>
</div></div></div>
<div style="width:100%; margin-top:20px;">
<div style="width:110px; float:left;"><input id="upload-logo" type="button" class="button" value="Upload Logo" /></div>
<div style="width:100px; float:left;padding:5px;"></div>
</div>
<script type="text/javascript">
function ClearTextBox(myInput) {
        var txtBox = document.getElementById(myInput);
        txtBox.value = "";
        return false;
    }	
</script>
<?php
echo '</div>';
echo '<div style="width:100%;padding:15px;">';
woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_logo_title', 'label' => __( 'Title', 'woocommerce_product_design' ), 'placeholder' => __( 'Enter Title', 'woocommerce_product_design' ), 'value' => $productdesign['logotitle'], 'style' => 'width:70%;' ) );

woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_logo_link', 'label' => __( 'Link', 'woocommerce_product_design' ), 'placeholder' => __( 'Enter Link', 'woocommerce_product_design' ), 'value' => $productdesign['logolink'], 'style' => 'width:70%;' ) );
echo '</div>';
echo '<div style="padding:15px;">';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;"><i>Layout One Settings</i></div>';
        woocommerce_wp_textarea_input( array( 'id' => '_pdbs_product_design_layout_textone', 'label' => __( 'Layout Text', 'woocommerce-specification-product' ), 'placeholder' => __( 'HTML and text to display.', 'woocommerce_product_design' ), 'value' => $productdesign['layouttextone'], 'style' => 'width:70%;height:10.5em;' ) );
echo '<div style="">';

woocommerce_wp_select( array( 'id' => '_pdbs_product_design_layout_onecolor', 'label' => __( 'Select Background Color', 'woocommerce_product_design' ), 'name' => $productdesign['layout_onecolor[]'], 'options' => array(
        '' . $productdesign['layout_onecolor'] . ''  => $productdesign['layout_onecolor'],
		'none' => 'None',
		'black' => 'Black',
		'white' => 'White',
        '#fd0101' => 'Red',
        'yellowgreen' => 'Yellowgreen',
		'rosybrown' => 'Rosybrown',
		'aliceblue' => 'Aliceblue',
		'aqua' => 'Aqua',
		'brown' => 'Brown',
		'burlywood' => 'Burlywood',
		'cadetblue' => 'Cadetblue',
		'chocolate' => 'Chocolate',
		'coral' => 'Coral',
		'crimson' => 'Crimson',
		'darkgray' => 'Darkgray',
		'indianred' => 'Indianred',
		'peru' => 'Peru',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';	

echo '<div style="">';

woocommerce_wp_select( array( 'id' => '_pdbs_product_design_layout_textonecolor', 'label' => __( 'Select Text Color', 'woocommerce_product_design' ), 'name' => $productdesign['layout_textonecolor[]'], 'options' => array(
        '' . $productdesign['layout_textonecolor'] . ''  => $productdesign['layout_textonecolor'],
		'black' => 'Black',
		'white' => 'White',
        '#fd0101' => 'Red',
        'yellowgreen' => 'Yellowgreen',
		'rosybrown' => 'Rosybrown',
		'aliceblue' => 'Aliceblue',
		'aqua' => 'Aqua',
		'brown' => 'Brown',
		'burlywood' => 'Burlywood',
		'cadetblue' => 'Cadetblue',
		'chocolate' => 'Chocolate',
		'coral' => 'Coral',
		'crimson' => 'Crimson',
		'darkgray' => 'Darkgray',
		'indianred' => 'Indianred',
		'peru' => 'Peru',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';		
		
echo '<div style="">';

woocommerce_wp_select( array( 'id' => '_pdbs_product_design_layout_textonesize', 'label' => __( 'Select Text Size', 'woocommerce_product_design' ), 'name' => $productdesign['layout_textonesize[]'], 'options' => array(
        '' . $productdesign['layout_textonesize'] . ''  => $productdesign['layout_textonesize'],
		'12px' => '12px',
		'14px' => '14px',
        '16px' => '16px',
        '18px' => '18px',
		'24px' => '24px',
		'30px' => '30px',
		'34px' => '34px',
		'36px' => '36px',
		'38px' => '38px',
		'42px' => '42px',
		'46px' => '46px',
		'48px' => '48px',
		'56px' => '56px',
		'62px' => '62px',
		'68px' => '68px',
		'72px' => '72px',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';

echo '<div style="">';	
woocommerce_wp_select( array( 'id' => '_pdbs_product_design_layout_textonefontfamily', 'label' => __( 'Select Font Family', 'woocommerce_product_design' ), 'name' => $productdesign['layout_textonefontfamily[]'], 'options' => array(
        '' . $productdesign['layout_textonefontfamily'] . ''  => $productdesign['layout_textonefontfamily'],
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Times New Roman", Times, serif' => 'Times New Roman", Times, serif',
        '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
        'Georgia, "Times New Roman", Times, serif' => 'Georgia, "Times New Roman", Times, serif',
		'Verdana, Arial, Helvetica, sans-serif' => 'Verdana, Arial, Helvetica, sans-serif',
		'Geneva, Arial, Helvetica, sans-serif' => 'Geneva, Arial, Helvetica, sans-serif',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';
		
echo '<div style="">';	
woocommerce_wp_select( array( 'id' => '_pdbs_product_design_layout_textonefontstyle', 'label' => __( 'Select Font Style', 'woocommerce_product_design' ), 'name' => $productdesign['layout_textonefontstyle[]'], 'options' => array(
        '' . $productdesign['layout_textonefontstyle'] . ''  => $productdesign['layout_textonefontstyle'],
		'inherit' => 'Inherit',
		'italic' => 'Italic',
        'oblique' => 'Oblique',
    ), 'style' => 'width:70%;' ) );	
	    echo '</div>';
		
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;"><i>Layout Two Settings</i></div>';

echo '<div style="">';
echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Free version if you like it support us and take <a href="http://www.benignsource.com/product/woo-product-design-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;"><i>Select Body Background Image</i></div>';	
echo '<div style="padding:15px;">';	
?>
<div id="background-product-images" style="padding:10px;">
<div class="inside">
<div id="background_images_container" >
<ul class="product_images">
<?php 
if ($productdesign['body_product_image_background'] == null ){
echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Free version if you like it support us and take <a href="http://www.benignsource.com/product/woo-product-design-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';	
} else {?>
<li style="width:60%;"><a style="padding:4px; padding-left:15px; padding-right:15px; font-size:14px; background:#330000;border-radius:3px; color:#FFFFFF; text-decoration:none;" href="javascript:void(0);" onclick="return ClearTextBox('_pdbs_product_design_product_body_background');" class="deletebody" tabindex="0">Delete</a>
<p class="hidebody" >
<img width="500px" src=""/></p>
<?php }?>
</li></ul>
</div>
</div></div>
<div style="width:100%; margin-top:20px;">
<div style="width:110px; float:left;"><input id="" type="button" class="button" value="Upload Image" /></div>
<script type="text/javascript">
function ClearTextBox(myInput) {
        var txtBox = document.getElementById(myInput);
        txtBox.value = "";
        return false;
    }	
</script>
</div>
<?php
echo '</div>';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;margin-top:30px;"><i>Select Header Background Image</i></div>';	
echo '<div style="padding:15px;">';	
echo '<div style="">';
       woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_header_height', 'label' => __( 'Header Height', 'woocommerce_product_design' ), 'placeholder' => __( 'Example: 250px', 'woocommerce_product_design' ), 'value' => $productdesign['product_header_height'], 'style' => 'width:20%;' ) );
echo '</div>';
?>
<?php 
woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_product_image_background', 'value' => $productdesign['product_image_background'], 'style' => 'display:none;' ) );
?>
<div id="background-product-images" style="padding:10px;">
<div class="inside">
<div id="background_images_container">
<ul class="product_images">
<?php 
if ($productdesign['product_image_background'] == null ){
echo '<li class="image" style="width:30%;"><div id="upload-button" style="padding:27px; font-size:16px; cursor:pointer;">Upload Header Background</div>';
} else {?>
<li style="width:60%;"><a style="padding:4px; padding-left:15px; padding-right:15px; font-size:14px; background:#330000;border-radius:3px; color:#FFFFFF; text-decoration:none;" href="javascript:void(0);" onclick="return ClearTextBox('_pdbs_product_design_product_image_background');" class="deleteheader" tabindex="0">Delete</a>
<p class="hideheader" ><img width="400px" src="<?php echo $productdesign['product_image_background']; ?>" /></p>
<?php }?>
</li></ul>
</div></div></div>
<div style="width:100%; margin-top:20px;">
<div style="width:110px; float:left;"><input id="upload-button" type="button" class="button" value="Upload Image" /></div>
<script type="text/javascript">
function ClearTextBox(myInput) {
        var txtBox = document.getElementById(myInput);
        txtBox.value = "";
        return false;
    }	
</script>
</div>
<?php
echo '</div>';
echo '<div style="margin-top:30px;width:90%;padding:15px;">';
echo '<div style="width:90%;">Copy the code before div id="content" class="site-content" after header </div>';
echo '<div style="margin-top:20px;width:90%;"><input onClick="this.select();" value="<?php product_design_benignsource();?>" style="background-color: #F1F2F7;border:1px #CCCCCC solid; width:50%;" /></div>';
echo '<div style="margin-top:20px;width:90%;"><i>it is necessary to do it only once! then all products have custom design will look like as you want.</i></div></div>';
echo '<div style="">';
echo '<div style="padding:15px;border-bottom:1px #e96656 solid;margin-top:30px;"><i>Promote Special Offer or Accessories for this Product</i></div>';
echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Free version if you like it support us and take <a href="http://www.benignsource.com/product/woo-product-design-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';	
echo '</div>';
echo '<div style="">';
woocommerce_wp_text_input( array( 'id' => '_pdbs_product_design_product_sample_text', 'label' => __( 'Sample Text', 'woocommerce_product_design' ), 'placeholder' => __( 'Enter Sample Text', 'woocommerce_product_design' ), 'value' => $productdesign['sample_text'], 'style' => 'width:70%;' ) );
echo '</div>';
echo '<div style="margin-top:30px;padding:15px;"><i>After insert all press "Update"</i></div>';
  }
}
	/*
	 * Saves the data inputed into the product boxes, as post meta data
	 */
	public function woo_product_design_save_data( $post_id, $post ) {
	    $productdesign_payment_method_text = sanitize_text_field( $_POST['_pdbs_product_design_payment_method_text'] );
		$productdesign_logo = sanitize_text_field( $_POST['_pdbs_product_design_logo'] );
		$productdesign_logo_title = sanitize_text_field( $_POST['_pdbs_product_design_logo_title'] );
		$productdesign_logo_link = sanitize_text_field( $_POST['_pdbs_product_design_logo_link'] );
        $productdesign_payment_method = sanitize_text_field( $_POST['_pdbs_product_design_payment_method'] );
		$productdesign_layout_textone = sanitize_text_field( $_POST['_pdbs_product_design_layout_textone'] );
		$productdesign_layout_onecolor = sanitize_text_field( $_POST['_pdbs_product_design_layout_onecolor'] );
		$productdesign_layout_textonecolor = sanitize_text_field( $_POST['_pdbs_product_design_layout_textonecolor'] );
		$productdesign_layout_textonesize = sanitize_text_field( $_POST['_pdbs_product_design_layout_textonesize'] );
		$productdesign_layout_textonefontfamily = sanitize_text_field( $_POST['_pdbs_product_design_layout_textonefontfamily'] );
		$productdesign_layout_textonefontstyle = sanitize_text_field( $_POST['_pdbs_product_design_layout_textonefontstyle'] );
		$productdesign_product_header_height = sanitize_text_field( $_POST['_pdbs_product_design_header_height'] );
		$productdesign_product_image_background = sanitize_text_field( $_POST['_pdbs_product_design_product_image_background'] );
		$productdesign_sample_text = sanitize_text_field( $_POST['_pdbs_product_design_product_sample_text'] );
		// save the data to the database
$pdbs_product_design[] = array( 'payment_method' => $productdesign_payment_method, 'logo' => $productdesign_logo, 'logotitle' => $productdesign_logo_title, 'logolink' => $productdesign_logo_link, 'payment_method_text' => $productdesign_payment_method_text, 'layouttextone' => $productdesign_layout_textone, 'id' => $productdesign_id, 'layout_onecolor' => $productdesign_layout_onecolor, 'layout_textonecolor' => $productdesign_layout_textonecolor, 'layout_textonesize' => $productdesign_layout_textonesize, 'layout_textonefontfamily' => $productdesign_layout_textonefontfamily, 'layout_textonefontstyle' => $productdesign_layout_textonefontstyle, 'product_header_height' => $productdesign_product_header_height, 'product_image_background' => $productdesign_product_image_background, 'sample_text' => $productdesign_sample_text );
update_post_meta( $post_id, 'pdbs_woo_product_design', $pdbs_product_design );	
}
/*
* @return WooCommerceProductDesignBenignSource
*/
public static function bsproductdesign() {
		if ( is_null( self::$bsproductdesign ) ) {
			self::$bsproductdesign = new self();
		}
		return self::$bsproductdesign;
	}
	/*
	 * Checks if WooCommerce is active
	 */
	public static function is_woocommerce_activecpbs() {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
	/**
	 * Run every time.  Used since the activation hook is not executed when updating a plugin
	 */
private function install() {
global $wpdb;
$installed_version = get_option( self::VERSION_OPTION_NAME );
// installed version lower than plugin version?
if ( -1 === version_compare( $installed_version, self::VERSION ) ) {
			// new version number
			update_option( self::VERSION_OPTION_NAME, self::VERSION );
		}
	}
}
/*
 * @return \WooCommerceProductDesignBenignSource
 */
function pdbs_product_design_benign() {
	return WooCommerceProductDesignBenignSource::bsproductdesign();
}
function load_product_design_admin_style() {
wp_enqueue_style( 'product_design_admin_css', plugins_url('style.css', __FILE__) );	
}
add_action( 'admin_enqueue_scripts', 'load_product_design_admin_style' );
function load_product_design_lib_uploader() {
    //Core media script
    wp_enqueue_media();
    // Your custom js file
    wp_register_script( 'product-design-js', plugins_url( 'product-design-uploader.js' , __FILE__ ), array('jquery') );
    wp_enqueue_script( 'product-design-js' );
}
add_action('admin_enqueue_scripts', 'load_product_design_lib_uploader'); ?>
<?php
/**
 * Register BenignSource menu page.
 */
if (! function_exists('bs_register_benignsource_menu_page')){
function bs_register_benignsource_menu_page() {
    add_menu_page(
        __( 'BenignSource', 'BenignSource' ),
        'BenignSource',
        'manage_options',
        'woo-product-design-benignsource/plugins.php',
        '',
        plugins_url( 'woo-product-design-benignsource/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'bs_register_benignsource_menu_page' ); 
}else{
}
?>
<?php
/**
 * The WooCommerceProductDesignBenignSource global object
 */
$GLOBALS['woocommerce_product_design_benignsource'] = pdbs_product_design_benign();?>
