<?php
/**
 * @package FUMC_CC
 * @version 0.1
 */
/*
Plugin Name: FUMC Credit Card Form
Plugin URI: http://hneufeld.com
Description: This provides a credit card processing form for First UMC, Pensacola
Author: Henry Neufeld
Version: 0.1
Author URI: http://henryneufeld.com
*/

// Let's hook in our function with the javascript files with the wp_enqueue_scripts hook
 
add_action( 'wp_enqueue_scripts', 'fumc_enqueue_javascript' );
 
// Register some javascript files, because we love javascript files. Enqueue a couple as well
 
function fumc_enqueue_javascript() {
 
	wp_register_script( 'fumc_math_scripts', plugins_url() . '/fumc_cc/cc.js');
	 
	if ( is_page() ) {
		wp_enqueue_script('fumc_math_scripts');
	}
 
}
function FUMC_OutputForm($atts) {
	?>
		<p>Thank you for using the secure and convenient online giving option at First United Methodist Church of Pensacola.  Your donations allow us, as the body of Christ, to continue ministering to the community and the world.  Without you, this would not be possible.</p>
		<hr>
		<h3>Budget</h3>
		<p>Donations to the general operating budget are strongly encouraged, but specific designated funds or special contributions to missions are available below.</p>
		
		<form action="https://www.usaepay.com/interface/epayform/" onsubmit="return beforeSubmit(this)" id="epayform">
			<input type="hidden" name="UMkey" value="pmEJ49OXsn0DBMA7aGZ31tWS27k7rZFc">
			<input type="hidden" name="UMcommand" value="sale">
			<div style="margin: 0.2in">
			<table align="center" width="500px" border="0">
			<tr><td>- Operating Fund: </td><td colspan="2"><input type="text" name="OperatingFund" value="0.00" onChange = "addCharge()"></td></tr>
			<tr><td>- Missions: </td><td colspan="2"><input type="text" name="Missions" value="0.00" onChange = "addCharge()"></td></tr>
			<tr><td>- Living Trust: </td><td><input type="text" name="LivingTrust" value="0.00" onChange = "addCharge()"></td>
			<td><span style="color: red;">*</span> <input type="text" name="LTHonoree" value=""></td></tr>
			<tr><td colspan="3">(Please include In Honor or or Memory of name)</td></tr>
			<tr><td>- Designated Gift: </td><td><input type="text" name="DesignatedGift" value="0.00" onChange = "addCharge()"></td>
			<td><span style="color: red;">*</span> <input type="text" name="DGDesignee" value=""></td></tr>
			<tr><td colspan="3">(Please include name of Designated Fund or Project)</td></tr>
			</table>
			</div>
			<h3>Building Fund</h3>
			<p>Donations for the Embracing the Future Capital Campaign.</p>
			<div style="margin: 0.2in">
			<table align="center" border="0" width="500px">
			<tr><td>- Embracing the Future Campaign: </td><td colspan="2"><input type="text" name="PHBuildingFund" value="0.00" onChange = "addCharge()"></td></tr>
			</table>
			</div>
			<h3>Childcare</h3>
			<p>Includes Methodist Children's Academy and After School Care.</p>
			<div style="margin: 0.2in">
			<table align="center" width="500px" border="0">
			<tr><td>- Childcare Tuition:	</td><td><input type="text" name="ChildCareTuition" value="0.00" onChange = "addCharge()"></td>
			<td><span style="color: red;">*</span> <input type="text" name="CCTChildName" value=""></td></tr>
			 <tr><td colspan="3">(Please include child's name for tuition payment)</td></tr>
			 </table>
			 </div>
			 <hr>
			<h3>Other</h3>
			<p>Any other payments to the church. Please be sure to clearly identify the purpose of your payment or gift.</p>
			<div style="margin: 0.2in">
			<table align="center" width="500px" border="0">
			<tr><td>- Other Gift:	</td><td><input type="text" name="OtherGift" value="0.00" onChange = "addCharge()"></td>
			<td><span style="color: red;">*</span> <input type="text" name="OGPurpose" value=""></td></tr>
			 <tr><td colspan="3">(Please clearly identify the purpose of your payment or gift)</td></tr>
			 </table>
			 </div>
			 <hr>
			 <h3>Total</h3>
			 <input type="hidden" name="UMamount" value=""><div id="totalamount" style="text-align: center;">0.00</div>
			<input type="hidden" name="UMinvoice" value="[invoice]">
			<input type="hidden" name="UMcomments" value="">
			<hr>
			<div style="text-align: center"><input type="submit" value="Continue to Secure Payment Form"></div>
			</form>
	
	<?php
}

add_shortcode( 'fumc_cc', 'FUMC_OutputForm' );
?>
