<?php include("./classes/submit_once.php"); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script language="JavaScript">//<!--
					function mitte(w,h,url,n) {
  				l = (screen.availWidth/2)-(w/2);
  				t = (screen.availHeight/2)-(h/2);
  				win = window.open(url,n,"width="+w+",height="+h+",left="+l+",top="+t+", scrollbars=yes"); win.focus(); }
 					//--> </script>

<div class="order_box" >
<div class="order_content" >
<?php


/*

 echo 'bekannt = ' . $_SESSION["_login"]["status"] . '<br>';
 echo 'user Name = ' . $_SESSION["_login"]["user"] . '<br>';
 echo 'Table = ' . $_SESSION["_login"]["table"] . '<br>';
 echo 'user_id = ' .  $_SESSION["_login"]["id"] . '<br>';
 echo 'display_name = ' .  $_SESSION["_login"]["display_name"] . '<br>';
 echo 'user best�tigt = ' . $_SESSION["user"]["best�tigt"] . '<br>';

// if(isset($_SESSION["user"]["user_pass_new"]))
// echo 'Fertig = ' .  $_POST["fertig"] . '<br>';

 echo 'User New Passw = ' . $_SESSION["user"]["user_pass_new"] . '<br>';
 echo 'User Passw = ' . $pass . '<br>';
 echo 'error_text = ' . $error_text . '<br>';
 echo 'o_status = ' . $o_status . '<br>';
 echo 'login auth Status = ' . $_SESSION["_login"]["auth"] . '<br>';
 
 */
 

if (($pass != '') && ($_SESSION["user"]["user_pass_new"] == '') && ($_SESSION["_login"]["auth"] == 1))
{
  $_SESSION["user"]["user_pass_new"] = $pass;
}

if (($pass == '') && ($_SESSION["user"]["user_pass_new"] != ''))
{
  $pass = $_SESSION["user"]["user_pass_new"];
}


$new_user_password = $_SESSION["user"]["user_pass_new"];

if(isset($_SESSION["user"]["user_pass_new"]) && isset($_SESSION["user"]["best�tigt"]))
{
  $o_status = "fertig";
}
else
{

if (($_SESSION["_login"]["status"] == 'bekannt') && ($pass == ''))
  $o_status="login";


if ($o_status!="fertig"){
	
	round_box_top(lang("global_welcome")." ".$_SESSION["_login"]["display_name"]);
	echo "<br/>";
	if ($o_status=="login"){										// LOGIN FORM
		echo lang("global_email_bekannt")." ";
		$bitte_login = lang("global_bitte_login");
		$bitte_login = str_replace("#PASSWORT#", "<a href=\"javascript:mitte(420,220,'./passwd.php','name')\">".lang("global_passwort_vergessen")."</a>", $bitte_login);
		echo $bitte_login."<br/>";
		$login->login_form("order", $_REQUEST["f_user"]);
		//if ($pass!="") echo "<p class=\"red\">".lang("order_login_error")."</p>";
	} else {
		if (@$_SESSION["_login"]["auth"]==true){	// LOGIN ERFOLGREICH
			echo lang("order_login_ok")."<br/>";
		} else {																	// NEUKUNDE
			echo lang("global_email_unbekannt")."<br/>";
		}
	}
	if ($o_status=="fehler" && $error_text!="") { // FEHLERMELDUNGEN
  	echo "<div class=\"red\" style=\"padding-left:15px;\">";
  	echo "<b>".lang("order_fehler")."</b><br/>";
  	echo $error_text;
  	echo "</div>";
	} // ende error_text
	round_box_bottom();
}
}



if (($error_text!="") &&
    isset($_SESSION["user"]["order_formular_viewed"]) &&
    (!isset($_SESSION["user"]["best�tigt"])))
  {
	round_box_top(lang("global_welcome")." ".$_SESSION["_login"]["display_name"]);
	echo "<br/>";
  	echo "<div class=\"red\" style=\"padding-left:15px;\">";
  	echo "<b>".lang("order_fehler")."</b><br/>";
  	echo $error_text;
  	echo "</div>";
	round_box_bottom();
  }

if ($o_status=="fehler" || $o_status=="neu") {
// <!-- #############################  MAINFORM ############################################### -->
?>

<link type="text/css" href="css/sunny/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>

<?php if ( !isset ( $_POST["buchen"] )) { ?>
<script type="text/javascript">
$(document).ready(function() {
	$("#popupmsg").dialog({
		autoOpen: false,
		bgiframe: true,
		modal: true,
		buttons: {
			"Weiter": function() {
				$(this).dialog('close');
				document.forms["Form"].submit();
			}
		}
	});
	$("#Form").submit(function () {
		$('#popupmsg').dialog('open');
		return false;
	});
});

</script>

<div id="popupmsg" title="Sie haben alle Felder korrekt ausgef&uuml;llt">
	<p>
		<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
		Ihre Buchung ist fast komplett.</p>Bitte &uuml;berpr&uuml;fen Sie auf der n&auml;chsten Seite ein letztes Mal Ihre Angaben und schlie&szlig;en sie dann die Buchung ab!
	</p>
	
</div>

<?php } ?>
<form action="order.html#OK" method="post" id="Form" onsubmit="submitonce(this)">
<input type="hidden" name="buchen" value="yes">
<input type="hidden" name="p" value="order">
<?php round_box_top(lang("order_kundendaten")); ?>
<div>
   <?php
      echo "<tr><td>";
      echo $lable["user_anrede"];
      echo "</td><td><input type=\"radio\" name=\"user_anrede\" value=\"1\"";
      if(@$_SESSION["user"]["user_anrede"] == "1") { echo " checked=\"checked\""; }
	    if(!isset($_SESSION["user"])) { echo "checked"; }
	    echo " /> ".lang("global_anrede_1")." <input type=\"radio\" name=\"user_anrede\" value=\"2\"";
	    if(@$_SESSION["user"]["user_anrede"] == "2") { echo " checked=\"checked\""; }
	    echo " /> ".lang("global_anrede_2")."</td></tr>";
	 ?>
  	<div class="form-group">
  		<div class="col-sm-4">
	  		<label class="control-label label-text" for="vorname">Vorname</label>,
	  		<label class="control-label label-text" for="name">Name</label>
	  	</div>
	  	<div class="col-sm-3 col-sm-offset-1">
	  		<input type="text" name="vorname" id="vorname" placeholder="Enter Vorname" class="form-control">
	  	</div>
	  	<div class="col-sm-3">
	  		<input type="text" name="name" id="name" placeholder="Enter Name" class="form-control">
		</div>
	</div>  
  	<div class="form-group">
		<div class="col-sm-4">
			<label class="control-label label-text" for="strabe">Straße, Hausnummer</label>
		</div>,
		<div class="col-sm-3 col-sm-offset-1">
			<input type="text" name="strabe" id="strabe" placeholder="Enter Strabe" class="form-control">
		</div>
	</div>
  	<div>
		<div>  
		  	<?php echo $lable["user_plz"]; ?>,
		  	<?php echo $lable["user_ort"]; ?>
	  	</div>
	  	<div>
	  		<?php echo $input["user_plz"]; ?>,
	  		<label class="user_ort_input"><?php echo $input["user_ort"]; ?></label>
	  </div>
	</div>
  	<div>
	  	<div>
	  		<?php echo $lable["user_land"]; ?>  			
	  	</div>
	  	<div>
	  		<?php echo $input["user_land"]; ?>
	  	</div>
	</div>
  	<div>
  		<div>
  			<?php echo $lable["user_telefon"]; ?>	
		</div>
		<div>
			<?php echo $input["user_telefon"]; ?>
		</div>
	</div>
  	<div>
  		<div>
  			<?php echo $lable["user_handy"]; ?>
  		</div>
  		<div>
  			<?php echo $input["user_handy"]." "; infotooltip(lang("order_handy_help"));?><br/>
  			<div class="small"><?php echo lang("order_hinweis_handy"); ?></div>
  		</div>
	</div>
  	<div>
  		<div>
  			<?php echo $lable["user_email"]; ?>
  		</div>
  		<div>
			<?php echo $input["user_email"]; ?>
		</div>
	</div>
  	<div>
  		<div>
  			<?php echo $lable["user_geb_datum"]; ?>
		</div>
		<div></div>
  	</div>
</div>
<?php round_box_bottom();

    	// ####################################################################################
    	// ##################################### MIETDATEN ####################################
    	// ####################################################################################
   $buchung_display = new buchung();
   $buchung_display->load_session($_SESSION["buchung"]);
   round_box_top(lang("buchung_mietdaten"));

   echo '<table border="0" cellpadding="0" width="100%">
    <tr>
      <td width="10%">';
   echo '<img src="./grafik/newcars/' . $_SESSION["car"]["cars_pic"] . '">';
   echo '</td>
   <td>';
//   echo '<p align="center"><h2>' . lang("global_kategorie") .': '. $_SESSION["car"]["cars_cat"] . '</h2>';
//   echo '<h2>' . $_SESSION["car"]["cars_titel"] . '<small>(' . lang("global_oder_vergleichbar") . ')</small></h2></p>';

   $buchung_display->show_mietdaten2("width=\"\" ");
   echo   '</td>
    </tr>
  </table>';


   echo "<hr noshade=\"noshade\" style=\"height:1px;\" />";
   ?>
  <table border="0" style="border:0px solid #ffe265;">
    <?php
      for ($i=1; $i<=$fahrer; $i++){
       ?>
  		<tr><td><?php
  		  echo $lable["b_fahrer_".$i]; ?></td><td><?php echo $input["b_fahrer_".$i];
  		  if ($i==1) infotooltip(lang("order_b_bemerkungen_help"));
  		?></td></tr>
     <?php } ?>
  	<tr><td><?php echo $lable["b_bemerkungen"]; ?></td><td><?php echo $input["b_bemerkungen"]; ?></td></tr>
  	<?php
  	if ($_SESSION["daten"]["zustellungsart"]=="airport"){ ?>
  		<tr><td><?php echo $lable["b_flug_nr"]; ?></td><td><div><?php echo $input["b_flug_nr"]; infotooltip(lang("order_b_flug_nr_help")); ?></div>
  	<?php } else {echo "<tr><td><input type=\"hidden\" name=\"b_flug_nr\" value =\"-\" />";}	?>
  	</td></tr>
  	<!--<tr><td><?php echo $lable["b_uanschrift"]; ?></td><td><?php echo $input["b_uanschrift"]; ?></td></tr>
  	<?php
  	if ($_SESSION["daten"]["zustellungsart"]=="hotel"){ ?>
  		<tr><td><?php echo $lable["b_hotel"]; ?></td><td><?php echo $input["b_hotel"]; ?>
  	<?php } else echo "<input type=\"hidden\" name=\"b_hotel\" value =\"-\" />";	?>
  	</td></tr> -->
  	<?php if (!isset($_SESSION["_backup"])) { ?>
  	<tr><td><?php echo $lable["b_umfrage"]; ?></td><td><?php echo $input["b_umfrage"]; ?></td></tr>
  <?php } else {
  				echo "<input type=\"hidden\" name=\"b_umfrage\" value=\"agentur\">";
        }
  ?>
 		<tr><td><?php echo $lable["mietbedingungen"]; ?></td><td><input type="checkbox" name="mietbedingungen" <?php if (@$_POST["mietbedingungen"]=="on") echo "checked=\"checked\""; ?> />
  	<a href="javascript:mitte(840,600,'index.php?p=bedingungen','name')"><?=lang("order_mietbedingungen"); ?></a>
  	<?=lang("order_gelesen"); ?>
  	</td></tr>

  </table>
<?php
   round_box_bottom();

} // ende Main

// ################################ SUBMIT #########################################
// ################################ SUBMIT #########################################
// ################################ SUBMIT #########################################

// echo 'o_status = ' . $o_status. '<br>';
// echo 'error_text = ' . $error_text . '<br>';


$_SESSION["user"]["order_formular_viewed"] = 'ok';

if ($o_status=="fehler" || $o_status=="neu") {
	round_box_top(lang("order_buchen")); // Reservierung

	?>
      <table border="0"><tr><td>
      <?php
  		  if ($error_text!="")
          {
  		  	if (@$_POST["buchen"]=="yes")
            {
  		  	  echo "<b class=\"red\">".lang("order_fehler")."</b><br/><br/>";
  		  	}
          for ($i = 0;$i < 67; $i++) echo ' &nbsp;';
  		  	echo '<input class ="submit" type="submit" value="'.lang("global_weiter").'" style="width: 175px; height: 40px">';
            if ($o_status!="neu")
              {
                $_SESSION["_login"]["auth"]= TRUE;
                $_SESSION["user"]["best�tigt"] = 'ok';
              }
          }
          else
          { // no error
  		  	echo "<b class=\"red\">".lang("order_buchen_text")."</b><br/> ";
  		  	echo "<a name=\"OK\"></a>";
  		  	echo "<input type=\"hidden\" name=\"fertig\" value=\"fertig\"/><br/>";
            for ($i = 0;$i < 64; $i++) echo ' &nbsp;';
  		  	echo "<input class=\"submit\" type=\"submit\" value=\"".lang("order_abschliessen")."\"/ style='width: 175px; height: 40px'>";
            $_SESSION["user"]["best�tigt"] = 'ok';
  		  }
  		?>
  	</td></tr></table>
    <?php round_box_bottom();
    echo "</form>";
  //} //submit
}

// ################################ FERTIG #########################################
// ################################ FERTIG #########################################
// ################################ FERTIG #########################################

if ($o_status=="fertig")
{
	// Statistik aktualisieren
	// statistik("!buchung!");
	// Userdaten updaten
	$_SESSION["user"]["user_in"] = date("Y-m-d H:i:s");
	$_SESSION["user"]["user_lang"] = $_SESSION["_lang"];
	$_SESSION["user"]["user_user"] = $_SESSION["user"]["user_email"];
	$userc = new user();
	$userc->load_session($_SESSION["user"]);
	$userc->save(); // insert bzw. update
	// Begr��ungscookie setzen
	cookies_setzen(@$userc->daten["user_id"], @$_SESSION["daten"]["region_id"], @$_SESSION["daten"]["land_id"]); //functions.php
	// User->login
	$login = new login();
	$login->check_login($_SESSION["user"]["user_email"], $userc->daten["user_pass"], "user");
	// Passwort �ndern
	round_box_top(lang("login_change_pass"));

	//  echo "<br/><b>".lang("buchung_ihr_passwort_lautet").": ".$_SESSION["user"]["user_pass_new"]."</b><br/><br/>\n";
	echo "<br/><b>".lang("buchung_ihr_passwort_lautet").": ".$new_user_password."</b><br/><br/>\n";
	echo lang("buchung_passwort_hinweis")."<br/>";

	echo "<br/>".lang("order_hinweis_pass_aendern")." <a href=\"javascript:mitte(420,280,'./change_passwd.php','cp')\">(".lang("login_change_pass").")</a>";
	//$login->change_pass("support", "_blank");
	round_box_bottom();
	// Buchung speichern
	$_SESSION["buchung"]["b_user_search"] = $_SESSION["_login"]["display_name"]." ".$_SESSION["user"]["user_email"];
	$_SESSION["buchung"]["b_umfrage"] = substr($_SESSION["buchung"]["b_umfrage"], 0, 5);
	$body_array = array_merge($_SESSION["buchung"], $_SESSION["user"]);
	$body_array = array_merge($body_array, $config);
	$buchungc = new buchung();
	$buchungc->load_session($body_array);
	$userc->daten["user_id"] = $_SESSION["_login"]["id"];
	$buchungc->set_user($userc);
	$buchungc->insert_sql();
	// Body_array vorbereiten
	$body_array = array_merge($buchungc->daten, $userc->daten);
	$body_array = array_merge($body_array, $config);
	
	round_box_top(lang("order_erfolgreich"));
	//#############################################################
	//#################### BLINDIMAGE #############################
	//#############################################################
	if (isset($blindimage[$_SESSION["ref"]["ref_user"]]))
	{
		$src ="agent="."SUNgo.com"; // unsere Agenturnummer
		$src .="&vorgangsnummer=".$buchungc->daten["b_id"];
		$src .="&buchungsZeit=".date("Y-m-d H:i:s");
		$src .="&datumReise=".$buchungc->daten["b_von"];
		//$src .="&va="."??"; // Veranstalter (am besten als CRS-K�rzel)
		$src .="&agent=".@$_SESSION["ref"]["r2"];
		$src .="&reisePreis=".$buchungc->daten["b_total"];
		$src .="&kundenAnschrift1=".$userc->daten["user_strasse"];
		$src .="&kundenLand=".$userc->daten["user_land"];
		$src .="&kundenPLZ=".$userc->daten["user_plz"];
		$src .="&kundenOrt=".$userc->daten["user_ort"];
		$src .="&kundenTelefon1=".$userc->daten["user_telefon"];
		$src .="&kundenTelefon2=".$userc->daten["user_handy"];
		$src .="&kundenEmail=".$userc->daten["user_email"];
		//$src .="&btext="."r2=".@$_SESSION["ref"]["r2"];
		$src .="&optionBis=".$buchungc->daten["b_bis"];
		//$src .="&ip=ip";
		echo "<!-- \n".str_replace("&", "&\n", $src)." -->";
		$src= urlencode($src);
		echo "<img src=\"".$blindimage[$_SESSION["ref"]["ref_user"]]."$src\" height=\"1\" alt =\"\" width=\"1\" />";
	}
	if ($config["affili_aktiv"]) // fuer affili
	{
		$res_mwst = mysql_query("SELECT * FROM net_loc_land WHERE land_id = '".$_SESSION["daten"]["land_id"]."'");
		$row_mwst = mysql_fetch_array($res_mwst);
		$row_mwst["land_mwst"] = "1".$row_mwst["land_mwst"];
		$affilibetrag = number_format($buchungc->daten["b_total"] / $row_mwst["land_mwst"] * 100, 2, ".", "");
?>
		<img src="https://partners.webmasterplan.com/registersale.asp?site=3525&order=<?= $buchungc->daten["b_id"]; ?>&curr=EUR&price=<?= $affilibetrag; ?>" alt="" width="1" height="1">
<?php
	}
	//#############################################################
	//##### MAILS VERSENDEN #########################
	//#############################################################
	echo "<table><tr><td>";
	include("./classes/class_mailer.php");
	$mailer = new mailer();
	$mailer->from =  $config["noreply_email"];  //###################### FROM
	if (@$_SESSION["_backup"]["type"]=="ref") // Mail geht an AGENTUR
	{
		$mailer->to = $_SESSION["user"]["user_email"];
	}
	else
	{
		$mailer->to = $_SESSION["user"]["user_email"];
	}
	$mailer->subject = $config["from_name"].": ".lang("buchung_betreff")." ".$buchungc->daten["b_id"];
	$mailer->date =date("Y-m-d H:i:s");
	$mailer->b_id =$buchungc->daten["b_id"];
	if ($_SESSION["buchung"]["b_anbieter_bes"]=="ja") // => Best�tigung erforderlich
	{
		$mbody=make_mail_body("bestaetigung2_".$_SESSION["_lang"].".htm", $body_array);
	}
	else // Keine best�tigung erforderlich
	{
  		if ($_SESSION["buchung"]["b_anbieter_anz"]>0) // CASH => Zahlungsaufforderung
		{
			$mbody =make_mail_body("zahlungsaufforderung_".$_SESSION["_lang"].".htm", $body_array);
		}
		else // NOCASH => Voucher
		{
			$mbody = make_mail_body("voucher_".$_SESSION["_lang"].".htm", $body_array);
			sms_senden($body_array);
		}
	}
	$mailer->altbody = html2text($mbody); //<b>".lang("order_erfolgreich_txt")."</b><br/>";
	$mailer->htmlbody = make_mail_box($mbody);
	//$mailer->send_mail();
	
	# new 2017-04-01
	
	try {
	// Create the message
	$message = Swift_Message::newInstance()
		->setSubject($mailer->subject)
		->setBody($mailer->htmlbody, 'text/html')
		->addPart($mailer->altbody, 'text/plain')
		->setFrom(array($config["noreply_email"] => $config["from_name"]))
		->setReturnPath($config["noreply_email"])
		->setSender($config["noreply_email"])
		->setTo($mailer->to)
	;
	$swift_mailer->send($message);
	} catch (Swift_TransportException $e) {
		$_msg = $e->getMessage();
	} catch (Exception $e) {
		$_msg = $e->getMessage();
	}
					
	if (isset($_msg))
	{
		mail($config["noreply_email"].', info@vivanet.es', 'sungo.com - Problem mit E-Mail senden', $_msg);
		unset($_msg);
	}
	
	echo "<br/>".$mbody."</tr></td><tr><td>";
	echo "<br/><b>".lang("order_auch_als_mail")."</b><br/><br/>";
	if (@$_SESSION["_backup"]["type"]=="ref") echo "<b><u>Bitte leiten Sie diese Informationen an den Kunden weiter.<br/>Ihr Kunde erh�lt KEINE Best�tigung von uns, dies muss durch Sie erfolgen.</u></b><br/>";
	// MAIL AN REFERER
	$sql="SELECT * FROM net_referer WHERE ref_id=".$buchungc->daten["b_referer_id"];
	$res = mysql_query ($sql);
	$row = mysql_fetch_array($res);
	$body_array = array_merge($body_array, $row);
	$mailer = new mailer();
	$mailer->from = $config["noreply_email"];  //###################### FROM
	$mailer->to = $row["ref_email"];
	$mailer->subject = $config["from_name"].": ".$buchungc->daten["b_id"];
	$mailer->date =date("Y-m-d H:i:s");
	$mailer->b_id =$buchungc->daten["b_id"];
	$mailer->htmlbody=make_mail_body("referer.htm", $body_array);
	$mailer->altbody=html2text($mailer->htmlbody);
	$mailer->htmlbody = make_mail_box($mailer->htmlbody);
	//$mailer->send_mail();
	
	# new 2017-04-01
	
	try {
	// Create the message
	$message = Swift_Message::newInstance()
		->setSubject($config["from_name"].": ".$buchungc->daten["b_id"])
		->setBody($mailer->htmlbody, 'text/html')
		->addPart($mailer->altbody, 'text/plain')
		->setFrom(array($config["noreply_email"] => $config["from_name"]))
		->setReturnPath($config["noreply_email"])
		->setSender($config["noreply_email"])
		->setTo($mailer->to)
	;
	$swift_mailer->send($message);
	} catch (Swift_TransportException $e) {
		$_msg = $e->getMessage();
	} catch (Exception $e) {
		$_msg = $e->getMessage();
	}
					
	if (isset($_msg))
	{
		mail($config["noreply_email"].', info@vivanet.es', 'sungo.com - Problem mit E-Mail senden', $_msg);
		unset($_msg);
	}
	
	echo "</tr></td></table>";
	round_box_bottom();
 	if ($_SESSION["buchung"]["b_anbieter_bes"]=="")
	{
	}

	// ############################ SESSION L�SCHEN ####################################

	unset($_SESSION["buchung"]);
	unset($_SESSION["daten"]);
	unset($_SESSION["preistabelle"]);
	unset($_SESSION["anbieter"]);
	unset($_SESSION["car"]);
	unset($_SESSION["temp"]);
	unset($_SESSION["user"]);
	if (isset($_SESSION["_backup"]))
	{
		$_SESSION["_login"] = $_SESSION["_backup"];
		unset($_SESSION["_backup"]);
	}
}
?>
</div>
</div>
