<!DOCTYPE html>
<html>
	<head>
		<title>Items synchronization</title>
		  <!--<meta charset="utf-8">-->
		  <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		  <style>
		  .table{
				  font-size: 12px;
				}
			</style>
	</head>
<body>
<script>

	function addRow(itemcode, itemname, woocode, insert_update, class_name, status, message, language) 
	{
		var table = document.getElementById("tbody");

		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		row.className = class_name;

		var cell0 = row.insertCell(0);
		cell0.innerHTML = rowCount+1;
			
		var cell1 = row.insertCell(1);
		cell1.innerHTML = itemcode;
			
		var cell2 = row.insertCell(2);
		cell2.innerHTML = itemname;
			
		var cell3 = row.insertCell(3);
		cell3.innerHTML = woocode;
			
		var cell4 = row.insertCell(4);
		cell4.innerHTML = insert_update;
		
		var cell5 = row.insertCell(5);
		cell5.innerHTML = status;
		
		var cell6 = row.insertCell(6);
		cell6.innerHTML = message;
		
		var cell7 = row.insertCell(7);
		cell7.innerHTML = language;

	}
</script>
<br>
<div class="container col-sm-6">
	<div class="col-sm-offset-2">
		<p class="col-sm-5" style="font-size:160%;">Είδη #<label id="ar_eidwn"> </label></p>
		<button id="expitems" type="button" class="btn btn-success" onclick="fnExcelReport('mytabitems');" disabled >Εξαγωγή Ειδών σε Excel</button>
	</div>
	<br>
		<div class="col-sm-offset-2">
			<div style="border-style: double; height:300px; overflow:auto;">
			  <table id="mytabitems" class="table">
				<thead>
				  <tr>
					<th>AA</th>
					<th>Κωδικός</th>
					<th>Όνομα</th>
					<th>Woocode</th>
					<th>Insert - Update</th>
					<th>Status</th>
					<th>Message</th>
					<th>Language</th>
				  </tr>
				</thead>
				<tbody id="tbody">
				 
				</tbody>
			  </table>
			</div>
		</div>
	</div>
<?php

function ItemsSync(){

require_once('0_CustomerData.php');
require_once('slugifier.php');

try
{
	$data0 = array('username' => PYL_API_USERNAME, 'password' => PYL_API_PASSWORD, 'apicode' => PYL_API_APICODE, 'applicationname' => PYL_API_APPLICATIONNAME, 'databasealias' => PYL_API_DATABASEALIAS);

	$url = PYL_API_LOGIN_URL;
	$data_string = json_encode($data0);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Content-Type: application/json',
    		'Content-Length: ' . strlen($data_string)));

	//execute post
	$return1 = curl_exec($ch);
	if(SHOW_CONNECTION_VAR_DUMPS){
		echo "<br>LOGIN: <br>";
		var_dump($return1);
	}
	//close connection
	curl_close($ch);

  	$result = json_decode($return1);
    $result1 = $result->Result;
	$cookie = json_decode($result1);
	$cookie1 = $cookie->cookie;

	$data2 = array('cookie' => $cookie1, 'apicode' => PYL_API_APICODE, 'entitycode' => PYL_API_ITEM_ENTITYCODE_GET, 'packagenumber' =>  '1', 'packagesize' => PYL_API_PACKAGESIZE);
    $url2 = PYL_API_GETDATA_URL;
    $data_string2 = json_encode($data2);

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $url2);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string2);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
       	'Content-Type: application/json',
       	'Content-Length: ' . strlen($data_string2)));

    //execute post
    $return2 = curl_exec($ch2);
	if(SHOW_CONNECTION_VAR_DUMPS){
		echo "<br>DATA: <br>";
		var_dump($return2);
	}
    //close connection
    curl_close($ch2);
}
catch (Exception $e)
{
    // Here we are dealing with errors
    $trace = $e->getTrace();
    if ($trace[0]['args'][0] == 404) echo 'Bad ID<br>';
    else if ($trace[0]['args'][0] == 401) echo 'Bad auth key<br>';
    else echo 'Other error<br />'.$e->getMessage();
}

$resources_id = array();

$result2 = json_decode($return2);
$result3 = $result2->Result;
$data3 = json_decode($result3, true);
$data4 = $data3['Data'];
$data5 = $data4['Items'];

//var_dump($data5);
//echo '<br>';

ob_end_flush();
ob_implicit_flush();
$simeio_pou_vriskomaste = 1;
$thesi_var = 0;
echo "<script> 
	document.getElementById('ar_eidwn').innerHTML = ' ".count($data5)."'; 
	</script>";	
if(SHOW_MESSAGES){
	echo "<br>*********************************Items*********************************<br>";
	echo "Exoun erthei: ".count($data5).' Eidi!<br>';
}
if(count($data5)>0)
{
	$bool=true;
}
else
{
	$bool=false;
}
foreach ($data5 as $value) {
	
	//neo proion
	if ($value['woocode'] == null){// || $value['woocode2'] == null){
		if(SHOW_MESSAGES){
			echo '--------------------------------------------<br>';
			echo '#'.$simeio_pou_vriskomaste.'<br>';
			$simeio_pou_vriskomaste++;
			echo 'New product<br>';
			echo "Itemcode: ".$value['itemcode'].'<br>';
			echo "Name: ".$value['title'].'<br>';
			echo "English Name: ".$value['EN_NAME'].'<br>';
			echo "Greek Name: ".$value['GR_NAME'].'<br>';
		}
		$product_cat_code2 = array();
		$product_cat_code2_gr = array();
		
		$product_tags = array();
		$product_tags_gr = array();
		
		$product_attr_code_temp1 = "";
		$product_attr_code_temp2 = "";
		$product_attr_code_temp3 = "";
		$product_attr_code_temp1_gr = "";
		$product_attr_code_temp2_gr = "";
		$product_attr_code_temp3_gr = "";
		$final_product_attr_code_temp1_gr = "";
		$final_product_attr_code_temp2_gr = "";
		$final_product_attr_code_temp3_gr = "";
		
		$attr_head_1 = $value['attr_head_1'];
		$attr_head_2 = $value['attr_head_2'];
		$attr_head_3 = $value['attr_head_3'];

		$product_attr_code_temp1 = explode(';',$value['product_attr_code1']);
		$attr_default1temp = strval($product_attr_code_temp1[0]);

		$product_attr_code_temp1_gr  = explode(';',$value['product_attr_code1_gr']);
		
		if($product_attr_code_temp1_gr[0]==""){
			$final_product_attr_code_temp1_gr = $product_attr_code_temp1;
			$attr_default1temp_gr = strval($product_attr_code_temp1[0]);
		}
		else{
			$final_product_attr_code_temp1_gr = $product_attr_code_temp1_gr;
			$attr_default1temp_gr = strval($product_attr_code_temp1_gr[0]);
		}

		$product_attr_code_temp2  = explode(';',$value['product_attr_code2']);
		$attr_default2temp = strval($product_attr_code_temp2[0]);

		$product_attr_code_temp2_gr  = explode(';',$value['product_attr_code2_gr']);
		
		if($product_attr_code_temp2_gr[0]==""){
			$final_product_attr_code_temp2_gr = $product_attr_code_temp2;
			$attr_default2temp_gr = strval($product_attr_code_temp2[0]);
		}
		else{
			$final_product_attr_code_temp2_gr = $product_attr_code_temp2_gr;
			$attr_default2temp_gr = strval($product_attr_code_temp2_gr[0]);
		}

		$product_attr_code_temp3  = explode(';',$value['product_attr_code3']);
		$attr_default3temp = strval($product_attr_code_temp3[0]);

		$product_attr_code_temp3_gr  = explode(';',$value['product_attr_code3_gr']);
		
		if($product_attr_code_temp3_gr[0]==""){
			$final_product_attr_code_temp3_gr = $product_attr_code_temp3;
			$attr_default3temp_gr = strval($product_attr_code_temp3[0]);
		}
		else{
			$final_product_attr_code_temp3_gr = $product_attr_code_temp3_gr;
			$attr_default3temp_gr = strval($product_attr_code_temp3_gr[0]);
		}

		$product_cat_code2[] = array('id' => $value['hedomain2a']);
		$product_cat_code2_gr[] = array('id' => $value['hedomain2a_gr']);

        $visibletemp = 'visible';
        if ($value['visible'] === 0){
            $visibletemp = 'hidden';
        }
		
		$visibletemp1 = 'publish';
        if($value['visible'] === 0){
			$visibletemp1 = 'private';
        }
		
		$frurl = $value['title'];
		$frurl_gr = $value['GR_NAME'];
		$ekptwtiki_timi = "";
		if($value['hasvar']=="simple")
		{
			$timi = (string)$value['arxiki_timi'];
			$stock = true;
			$quantity = (int)$value['Balance'];
			$ekptwtiki_timi = (string)$value['RETAILPRICE'];
			/*if((double)$value['retdisc']>0)
			{
				$pososto = (double)$value['retdisc'];
				$tmp_timi = (double)$value['RETAILPRICE'];
				$ekptwtiki_timi = $tmp_timi - (($tmp_timi*$pososto)/100);
				$ekptwtiki_timi = number_format((double)$ekptwtiki_timi, 2);
			}*/
		}
		else
		{
			$timi = "";
			$stock = false;
			$quantity = null;
		}
		$tel_tags  = explode(';',$value['tags']);
		$tagLength = count($tel_tags);
		for ($i = 0; $i < $tagLength; $i++) {
			$product_tags[$i] = array(
				'id' => (int)$tel_tags[$i]
			);
		}
		
		$tel_tags_gr  = explode(';',$value['greek_tags']);
		$grtagLength = count($tel_tags_gr);
		for ($i = 0; $i < $grtagLength; $i++) {
			$product_tags_gr[$i] = array(
				'id' => (int)$tel_tags_gr[$i]
			);
		}
		
		$sku = "";
		if($value['sku']){
			$sku = $value['sku'];
		}
		else{
			$tmp_sku  = explode('-',$value['itemcode']);
			$sku = $tmp_sku[1];
		}
		
		$teliko_onoma_en = "";
		if($value['EN_NAME']){
			$teliko_onoma_en = $value['EN_NAME'];
		}
		else{
			$teliko_onoma_en = $value['title'];
		}
		
		$teliko_onoma_gr = "";
		if($value['GR_NAME']){
			$teliko_onoma_gr = $value['GR_NAME'];
		}
		else{
			$teliko_onoma_gr = $value['title'];
		}
		
		if ($value['woocode'] == null){
			$data = array(
				'name' => $teliko_onoma_en,
				'slug' => url_slug($frurl),
				'type' => $value['hasvar'],
				'catalog_visibility' => $visibletemp,
				'status' => $visibletemp1,
				'description' => $value['long_description'],
				'short_description' => $value['long_description'],
				'sku' => $sku,
				'regular_price' => $timi,
				'sale_price' => (string)$ekptwtiki_timi,
				'manage_stock' => $stock,
				'weight' => (string)$value['varos'],
				'stock_quantity' => $quantity,
				'categories' => $product_cat_code2,
				'tags' => $product_tags,
				'attributes' => [
					[
					'id' => (int)$attr_head_1,
					'position' => 0,
					'visible' => true,
					'variation' => true,
					'options' => $product_attr_code_temp1
					],
					[
					'id' => (int)$attr_head_2,
					'position' => 1,
					'visible' => true,
					'variation' => true,
					'options' => $product_attr_code_temp2
					],
					[
					'id' => (int)$attr_head_3,
					'position' => 2,
					'visible' => true,
					'variation' => true,
					'options' => $product_attr_code_temp3
					]
				],
				'default_attributes' => [
					[
					'id' => (int)$attr_head_1,
					'option' => $attr_default1temp
					],
					[
					'id' => (int)$attr_head_2,
					'option' => $attr_default2temp
					],
					[
					'id' => (int)$attr_head_3,
					'option' => $attr_default3temp
					]
				],
				'lang' => 'en',
				'brands' => array(intval($value['brandid'])),
				'meta_data' => [
					[
						'key' => '_yoast_wpseo_metadesc',
						'value' =>$value['long_description']
					],
					[
						'key' => 'product_greek_title',
						'value' =>$teliko_onoma_gr
					],
					[
						'key' => 'product_greek_description',
						'value' =>$value['long_description_greek']
					],
					[
						'key' => 'product_greek_title_meta',
						'value' =>$teliko_onoma_gr
					],
					[
						'key' => 'product_greek_description_meta',
						'value' =>$value['long_description_greek']
					]
				]
			);

			try {
				$url1 = WP_SHOP_PATH.'/products';//.'?consumer_key='.WP_CK_AUTH_KEY.'&consumer_secret='.WP_CS_AUTH_KEY;
				$data_string1 = json_encode($data);
				if(SHOW_VAR_DUMPS){
					echo "DATA POU STELNW: <br>";
					var_dump($data_string1);
					echo "<br>";
				}

				$ch1 = curl_init();
				curl_setopt($ch1, CURLOPT_URL, $url1);
				curl_setopt($ch1, CURLOPT_POST, true);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch1, CURLOPT_USERPWD, WP_CK_AUTH_KEY.':'.WP_CS_AUTH_KEY);
				curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string1)));

				//execute post
				$return_post = curl_exec($ch1);
				if(SHOW_VAR_DUMPS){
					echo "DATA POU GURNAEI: <br>";
					var_dump($return_post);
					echo "<br>";
				}
				//close connection
				curl_close($ch1);
			} catch (Exception $e) {
				// Here we are dealing with errors
				$trace = $e->getTrace();
				if ($trace[0]['args'][0] == 404) echo 'Bad ID';
				else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
				else echo 'Other error<br />'.$e->getMessage();
			}

			$obj2 = json_decode($return_post, true);
			$woocode1 = intval($obj2['id']);
			if(SHOW_MESSAGES){
				if($woocode1!="0"){
					echo "Product Succesfully Inserted in English me woocode: ".$woocode1.'<br>';
				}
				else{
					echo "Error: Product not Inserted in English me woocode: ".$woocode1.'<br>';
				}
			}
			$problem = json_decode($return_post);
			if(SHOW_TABLE_MESSAGES){
				$onoma_na_fanei = str_replace("'","\'",$value['title']);
				if($woocode1!="0"){
						echo "<script> 
						addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$woocode1."', 'INSERT', 'table-success', 'SUCCESS', 'OK','English'); 
						</script>";	
				}
				else{
					echo "<script> 
						addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$woocode1."', 'INSERT', 'table-danger', 'ERROR', '".$problem->message."','English'); 
						</script>";	
				}
			}
		}
		else{
			$woocode1 = $value['woocode'];
		}
		
		/*if ($value['woocode2'] == null){
			$data = array(
				'name' => $teliko_onoma_gr,
				'slug' => url_slug($frurl_gr),
				'type' => $value['hasvar'],
				'catalog_visibility' => $visibletemp,
				'status' => $visibletemp1,
				'description' => $value['short_description'],
				'short_description' => $value['long_description_greek'],
				'sku' => 'GR'.$sku,
				'regular_price' => $timi,
				'sale_price' => (string)$ekptwtiki_timi,
				'manage_stock' => $stock,
				'weight' => (string)$value['varos'],
				'stock_quantity' => $quantity,
				'categories' => $product_cat_code2_gr,
				'tags' => $product_tags_gr,
				'attributes' => [
					[
					'id' => (int)$attr_head_1,
					'position' => 0,
					'visible' => true,
					'variation' => true,
					'options' => $final_product_attr_code_temp1_gr
					],
					[
					'id' => (int)$attr_head_2,
					'position' => 1,
					'visible' => true,
					'variation' => true,
					'options' => $final_product_attr_code_temp2_gr
					],
					[
					'id' => (int)$attr_head_3,
					'position' => 2,
					'visible' => true,
					'variation' => true,
					'options' => $final_product_attr_code_temp3_gr
					]
				],
				'default_attributes' => [
					[
					'id' => (int)$attr_head_1,
					'option' => $attr_default1temp_gr
					],
					[
					'id' => (int)$attr_head_2,
					'option' => $attr_default2temp_gr
					],
					[
					'id' => (int)$attr_head_3,
					'option' => $attr_default3temp_gr
					]
				],
				'translation_of' => $woocode1,
				'lang' => 'el',
				'brands' => array(intval($value['brandid'])),
				'meta_data' => [
					[
						'key' => '_yoast_wpseo_metadesc',
						'value' =>$value['long_description_greek']
					]
				]
			);

			try {
				$url1 = WP_SHOP_PATH.'/products';//.'?consumer_key='.WP_CK_AUTH_KEY.'&consumer_secret='.WP_CS_AUTH_KEY;
				$data_string1 = json_encode($data);
				if(SHOW_VAR_DUMPS){
					echo "DATA POU STELNW: <br>";
					var_dump($data_string1);
					echo "<br>";
				}

				$ch1 = curl_init();
				curl_setopt($ch1, CURLOPT_URL, $url1);
				curl_setopt($ch1, CURLOPT_POST, true);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch1, CURLOPT_USERPWD, WP_CK_AUTH_KEY.':'.WP_CS_AUTH_KEY);
				curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch1, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string1)));

				//execute post
				$return_post = curl_exec($ch1);
				if(SHOW_VAR_DUMPS){
					echo "DATA POU GURNAEI: <br>";
					var_dump($return_post);
					echo "<br>";
				}
				//close connection
				curl_close($ch1);
			} catch (Exception $e) {
				// Here we are dealing with errors
				$trace = $e->getTrace();
				if ($trace[0]['args'][0] == 404) echo 'Bad ID';
				else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
				else echo 'Other error<br />'.$e->getMessage();
			}

			$obj2 = json_decode($return_post, true);
			$woocode2 = intval($obj2['id']);
			if(SHOW_MESSAGES){
				if($woocode2!="0"){
					echo "Product Succesfully Inserted in English me woocode: ".$woocode2.'<br>';
				}
				else{
					echo "Error: Product not Inserted in English me woocode: ".$woocode2.'<br>';
				}
			}
			$problem = json_decode($return_post);
			if(SHOW_TABLE_MESSAGES){
				$onoma_na_fanei = str_replace("'","\'",$value['title']);
				if($woocode2!="0"){
						echo "<script> 
						addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$woocode2."', 'INSERT', 'table-success', 'SUCCESS', 'OK','Greek'); 
						</script>";	
				}
				else{
					echo "<script> 
						addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$woocode2."', 'INSERT', 'table-danger', 'ERROR', '".$problem->message."','Greek'); 
						</script>";	
				}
			}
		}
		else{
			$woocode2 = $value['woocode2'];
		}*/

		if($woocode1!="0"){// && $woocode2!="0" ){
			$resources_id[] = array($value['itemcode'], $woocode1,$value['revision'],$value['Balance']);
			date_default_timezone_set('Europe/Athens') ;    
			$log = "Insert stis ".date("d/m/Y")." ".date("H:i:s").", to proion: ".$value['itemcode']." woocode: ".$woocode1." petiximena.";
			$file = fopen("logs/products.log","a");
			fwrite($file,$log.PHP_EOL);
			fclose($file);
		}
		else{
			date_default_timezone_set('Europe/Athens');    
			$log = "Insert stis ".date("d/m/Y")." ".date("H:i:s").", to proion: ".$value['itemcode']." lanthasmena. Error: ".$problem->message."";
			$file = fopen("logs/products.log","a");
			fwrite($file,$log.PHP_EOL);
			fclose($file);
		}
	
		$thesi_var = $thesi_var + 1;
		if ($thesi_var == 10) 
		{
			$xmlstr = "<Items/>";
			$items = new SimpleXMLElement($xmlstr);
			$arrayLength = count($resources_id);
			for ($i = 0; $i < $arrayLength; $i++) {
				$item = $items->addChild('Item');
				$item->addChild('itemcode', $resources_id[$i][0]);
				$item->addChild('woocode', $resources_id[$i][1]);
				//$item->addChild('woocode2', $resources_id[$i][2]);
				$item->addChild('revision', $resources_id[$i][2]);
				$item->addChild('balance', $resources_id[$i][3]);
			}

			$id_json=json_encode($items);

			if ($arrayLength > 0){
				try
				{
						$data3 = array('cookie' => $cookie1, 'apicode' => PYL_API_APICODE, 'entitycode' => PYL_API_ITEM_ENTITYCODE_POST, 'data' => $id_json);
						$url3 = PYL_API_POSTDATA_URL;
						$data_string3 = json_encode($data3);

						$ch3 = curl_init();
						curl_setopt($ch3, CURLOPT_URL, $url3);
						curl_setopt($ch3, CURLOPT_POST, true);
						curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
						curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen($data_string3)));

						//execute post
						$return3 = curl_exec($ch3);
						if(SHOW_CONNECTION_VAR_DUMPS){
							echo "POST TO PYLON RETURN: <br>";
							var_dump($return3);
							echo "<br><br>";
						}
						//close connection
						curl_close($ch3);
						if(SHOW_MESSAGES){
							echo "woocode send<br>";
						}
				}
				catch (Exception $e)
				{
						// Here we are dealing with errors
						$trace = $e->getTrace();
						if ($trace[0]['args'][0] == 404) echo 'Bad ID<br>';
						else if ($trace[0]['args'][0] == 401) echo 'Bad auth key<br>';
						else echo 'Other error<br />'.$e->getMessage();
				}
			}
			$thesi_var = 0;
			$resources_id = array();
		}

	}
	else // Existing product
	{
		
		if(SHOW_MESSAGES){
			echo '--------------------------------------------<br>';
			echo '#'.$simeio_pou_vriskomaste.'<br>';
			$simeio_pou_vriskomaste++;
			echo "Existing product<br>";
			echo "Itemcode: ".$value['itemcode'].'<br>';
			echo "Name: ".$value['title'].'<br>';
			echo "English Name: ".$value['EN_NAME'].'<br>';
			echo "English Woocode: ".$value['woocode']."<br>";
			echo "Greek Name: ".$value['GR_NAME'].'<br>';
			echo "Greek Woocode: ".$value['woocode2']."<br>";
		}
		
		$product_cat_code2 = array();
		$product_cat_code2_gr = array();
		
		$product_tags = array();
		$product_tags_gr = array();
		
		$product_attr_code_temp1 = "";
		$product_attr_code_temp2 = "";
		$product_attr_code_temp3 = "";
		$product_attr_code_temp1_gr = "";
		$product_attr_code_temp2_gr = "";
		$product_attr_code_temp3_gr = "";
		$final_product_attr_code_temp1_gr = "";
		$final_product_attr_code_temp2_gr = "";
		$final_product_attr_code_temp3_gr = "";
		
		$attr_head_1 = $value['attr_head_1'];
		$attr_head_2 = $value['attr_head_2'];
		$attr_head_3 = $value['attr_head_3'];

		$product_attr_code_temp1 = explode(';',$value['product_attr_code1']);
		$attr_default1temp = strval($product_attr_code_temp1[0]);

		$product_attr_code_temp1_gr  = explode(';',$value['product_attr_code1_gr']);
		
		if($product_attr_code_temp1_gr[0]==""){
			$final_product_attr_code_temp1_gr = $product_attr_code_temp1;
			$attr_default1temp_gr = strval($product_attr_code_temp1[0]);
		}
		else{
			$final_product_attr_code_temp1_gr = $product_attr_code_temp1_gr;
			$attr_default1temp_gr = strval($product_attr_code_temp1_gr[0]);
		}

		$product_attr_code_temp2  = explode(';',$value['product_attr_code2']);
		$attr_default2temp = strval($product_attr_code_temp2[0]);

		$product_attr_code_temp2_gr  = explode(';',$value['product_attr_code2_gr']);
		
		if($product_attr_code_temp2_gr[0]==""){
			$final_product_attr_code_temp2_gr = $product_attr_code_temp2;
			$attr_default2temp_gr = strval($product_attr_code_temp2[0]);
		}
		else{
			$final_product_attr_code_temp2_gr = $product_attr_code_temp2_gr;
			$attr_default2temp_gr = strval($product_attr_code_temp2_gr[0]);
		}

		$product_attr_code_temp3  = explode(';',$value['product_attr_code3']);
		$attr_default3temp = strval($product_attr_code_temp3[0]);

		$product_attr_code_temp3_gr  = explode(';',$value['product_attr_code3_gr']);
		
		if($product_attr_code_temp3_gr[0]==""){
			$final_product_attr_code_temp3_gr = $product_attr_code_temp3;
			$attr_default3temp_gr = strval($product_attr_code_temp3[0]);
		}
		else{
			$final_product_attr_code_temp3_gr = $product_attr_code_temp3_gr;
			$attr_default3temp_gr = strval($product_attr_code_temp3_gr[0]);
		}

		$product_cat_code2[] = array('id' => $value['hedomain2a']);
		$product_cat_code2_gr[] = array('id' => $value['hedomain2a_gr']);

        $visibletemp = 'visible';
        if ($value['visible'] === 0){
            $visibletemp = 'hidden';
        }
		
		$visibletemp1 = 'publish';
        if($value['visible'] === 0){
			$visibletemp1 = 'private';
        }
		
		$frurl = $value['title'];
		$frurl_gr = $value['GR_NAME'];
		$ekptwtiki_timi = "";
		if($value['hasvar']=="simple")
		{
			$timi = (string)$value['arxiki_timi'];
			$stock = true;
			$quantity = (int)$value['Balance'];
			$ekptwtiki_timi = (string)$value['RETAILPRICE'];
			/*if((double)$value['retdisc']>0)
			{
				$pososto = (double)$value['retdisc'];
				$tmp_timi = (double)$value['RETAILPRICE'];
				$ekptwtiki_timi = $tmp_timi - (($tmp_timi*$pososto)/100);
				$ekptwtiki_timi = number_format((double)$ekptwtiki_timi, 2);
			}*/
		}
		else
		{
			$timi = "";
			$stock = false;
			$quantity = null;
		}
		$tel_tags  = explode(';',$value['tags']);
		$tagLength = count($tel_tags);
		for ($i = 0; $i < $tagLength; $i++) {
			$product_tags[$i] = array(
				'id' => (int)$tel_tags[$i]
			);
		}
		
		$tel_tags_gr  = explode(';',$value['greek_tags']);
		$grtagLength = count($tel_tags_gr);
		for ($i = 0; $i < $grtagLength; $i++) {
			$product_tags_gr[$i] = array(
				'id' => (int)$tel_tags_gr[$i]
			);
		}
		
		$sku = "";
		if($value['sku']){
			$sku = $value['sku'];
		}
		else{
			$tmp_sku  = explode('-',$value['itemcode']);
			$sku = $tmp_sku[1];
		}
		
		$teliko_onoma_en = "";
		if($value['EN_NAME']){
			$teliko_onoma_en = $value['EN_NAME'];
		}
		else{
			$teliko_onoma_en = $value['title'];
		}
		
		$teliko_onoma_gr = "";
		if($value['GR_NAME']){
			$teliko_onoma_gr = $value['GR_NAME'];
		}
		else{
			$teliko_onoma_gr = $value['title'];
		}
		
		$data = array(
			'name' => $teliko_onoma_en,
			'slug' => url_slug($frurl),
			'type' => $value['hasvar'],
			'catalog_visibility' => $visibletemp,
			'status' => $visibletemp1,
			'description' => $value['long_description'],
			'short_description' => $value['long_description'],
			//'sku' => $sku,
			'regular_price' => $timi,
			'sale_price' => (string)$ekptwtiki_timi,
			'manage_stock' => $stock,
			'weight' => (string)$value['varos'],
			'stock_quantity' => $quantity,
			'categories' => $product_cat_code2,
			'tags' => $product_tags,
			'attributes' => [
				[
				'id' => (int)$attr_head_1,
				'position' => 0,
				'visible' => true,
				'variation' => true,
				'options' => $product_attr_code_temp1
				],
				[
				'id' => (int)$attr_head_2,
				'position' => 1,
				'visible' => true,
				'variation' => true,
				'options' => $product_attr_code_temp2
				],
				[
				'id' => (int)$attr_head_3,
				'position' => 2,
				'visible' => true,
				'variation' => true,
				'options' => $product_attr_code_temp3
				]
			],
			'default_attributes' => [
				[
				'id' => (int)$attr_head_1,
				'option' => $attr_default1temp
				],
				[
				'id' => (int)$attr_head_2,
				'option' => $attr_default2temp
				],
				[
				'id' => (int)$attr_head_3,
				'option' => $attr_default3temp
				]
			],
			'lang' => 'en',
			'brands' => array(intval($value['brandid'])),
			'meta_data' => [
					[
						'key' => '_yoast_wpseo_metadesc',
						'value' =>$value['long_description']
					],
					[
						'key' => 'product_greek_title',
						'value' =>$teliko_onoma_gr
					],
					[
						'key' => 'product_greek_description',
						'value' =>$value['long_description_greek']
					],
					[
						'key' => 'product_greek_title_meta',
						'value' =>$teliko_onoma_gr
					],
					[
						'key' => 'product_greek_description_meta',
						'value' =>$value['long_description_greek']
					]
			]
		);

		try 
		{
         	$url3 = WP_SHOP_PATH.'/products/'.$value['woocode'].'';//?consumer_key='.WP_CK_AUTH_KEY.'&consumer_secret='.WP_CS_AUTH_KEY;
            $data_string3 = json_encode($data);
			if(SHOW_VAR_DUMPS){
				echo "DATA POU STELNW: <br>";
				var_dump($data_string3);
				echo "<br>";
			}
            $ch3 = curl_init();
            curl_setopt($ch3, CURLOPT_URL, $url3);
            curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch3, CURLOPT_USERPWD, WP_CK_AUTH_KEY.':'.WP_CS_AUTH_KEY);
            curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
            	'Content-Type: application/json',
            	'Content-Length: ' . strlen($data_string3)));

            //execute post
            $return_put = curl_exec($ch3);
			$obj2 = json_decode($return_put, true);
			$woocode1 = intval($obj2['id']);
			if(SHOW_VAR_DUMPS){
				echo "DATA POU GURNAEI: <br>";
				//var_dump($return_put);
				echo "<br>";
			}
            //close connection
            curl_close($ch3);
			if(SHOW_MESSAGES){
				if($woocode1!="0"){
					echo 'Product updated succesfully<br>';
				}
				else{
					echo 'Error: Product not updated!!!!!<br>';
				}
			}
        } 
		catch (Exception $e) 
		{
        	// Here we are dealing with errors
        	$trace = $e->getTrace();
        	if ($trace[0]['args'][0] == 404) echo 'Bad ID';
        	else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
        	else echo 'Other error<br />'.$e->getMessage();
        }
		/*
		$data = array(
			'name' => $teliko_onoma_gr,
			'slug' => url_slug($frurl_gr),
			'type' => $value['hasvar'],
			'catalog_visibility' => $visibletemp,
			'status' => $visibletemp1,
			'description' => $value['short_description'],
			'short_description' => $value['long_description_greek'],
			//'sku' => 'GR'.$sku,
			'regular_price' => $timi,
			'sale_price' => (string)$ekptwtiki_timi,
			'manage_stock' => $stock,
			'weight' => (string)$value['varos'],
			'stock_quantity' => $quantity,
			'categories' => $product_cat_code2_gr,
			'tags' => $product_tags_gr,
			'attributes' => [
				[
				'id' => (int)$attr_head_1,
				'position' => 0,
				'visible' => true,
				'variation' => true,
				'options' => $final_product_attr_code_temp1_gr
				],
				[
				'id' => (int)$attr_head_2,
				'position' => 1,
				'visible' => true,
				'variation' => true,
				'options' => $final_product_attr_code_temp2_gr
				],
				[
				'id' => (int)$attr_head_3,
				'position' => 2,
				'visible' => true,
				'variation' => true,
				'options' => $final_product_attr_code_temp3_gr
				]
			],
			'default_attributes' => [
				[
				'id' => (int)$attr_head_1,
				'option' => $attr_default1temp_gr
				],
				[
				'id' => (int)$attr_head_2,
				'option' => $attr_default2temp_gr
				],
				[
				'id' => (int)$attr_head_3,
				'option' => $attr_default3temp_gr
				]
			],
			'translation_of' => $value['woocode'],
			'lang' => 'el',
			'brands' => array(intval($value['brandid'])),
			'meta_data' => [
					[
						'key' => '_yoast_wpseo_metadesc',
						'value' =>$value['long_description_greek']
					]
			]
		);

		try 
		{
         	$url3 = WP_SHOP_PATH.'/products/'.$value['woocode2'].'';//?consumer_key='.WP_CK_AUTH_KEY.'&consumer_secret='.WP_CS_AUTH_KEY;
            $data_string3 = json_encode($data);
			if(SHOW_VAR_DUMPS){
				echo "DATA POU STELNW: <br>";
				var_dump($data_string3);
				echo "<br>";
			}
            $ch3 = curl_init();
            curl_setopt($ch3, CURLOPT_URL, $url3);
            curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch3, CURLOPT_USERPWD, WP_CK_AUTH_KEY.':'.WP_CS_AUTH_KEY);
            curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
            	'Content-Type: application/json',
            	'Content-Length: ' . strlen($data_string3)));

            //execute post
            $return_put = curl_exec($ch3);
			$obj2 = json_decode($return_put, true);
			$woocode2 = intval($obj2['id']);
			if(SHOW_VAR_DUMPS){
				echo "DATA POU GURNAEI: <br>";
				var_dump($return_put);
				echo "<br>";
			}
            //close connection
            curl_close($ch3);
			if(SHOW_MESSAGES){
				if($woocode2!="0"){
					echo 'Product updated succesfully<br>';
				}
				else{
					echo 'Error: Product not updated!!!!!<br>';
				}
			}
        } 
		catch (Exception $e) 
		{
        	// Here we are dealing with errors
        	$trace = $e->getTrace();
        	if ($trace[0]['args'][0] == 404) echo 'Bad ID';
        	else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
        	else echo 'Other error<br />'.$e->getMessage();
        }
		*/
		if(SHOW_TABLE_MESSAGES)
		{
			$onoma_na_fanei = str_replace("'","\'",$teliko_onoma_en);
			$onoma_na_fanei_greek = str_replace("'","\'",$teliko_onoma_gr);
			$problem = json_decode($return_put);
			if($woocode1!="0"){
				echo "<script> 
					addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$value['woocode']."', 'UPDATE', 'table-success', 'SUCCESS', 'OK','English'); 
					</script>";	
			}
			else{
				echo "<script> 
					addRow('".$value['itemcode']."', '".$onoma_na_fanei."', '".$value['woocode']."', 'UPDATE', 'table-danger', 'ERROR', '".$problem->message."','English'); 
					</script>";
			}
			/*if($woocode2!="0"){
				echo "<script> 
					addRow('".$value['itemcode']."', '".$onoma_na_fanei_greek."', '".$value['woocode2']."', 'UPDATE', 'table-success', 'SUCCESS', 'OK','Greek'); 
					</script>";	
			}
			else{
				echo "<script> 
					addRow('".$value['itemcode']."', '".$onoma_na_fanei_greek."', '".$value['woocode2']."', 'UPDATE', 'table-danger', 'ERROR', '".$problem->message."','Greek'); 
					</script>";
			}*/
			if($woocode1!="0"){// && $woocode2!="0"){
				date_default_timezone_set('Europe/Athens') ;    
				$log = "Update stis ".date("d/m/Y")." ".date("H:i:s").", to proion: ".$value['itemcode']." woocode: ".$value['woocode']." petiximena.";
				$file = fopen("logs/products.log","a");
				fwrite($file,$log.PHP_EOL);
				fclose($file);
				$resources_id[] = array($value['itemcode'], $value['woocode'],$value['revision'],$value['Balance']);
			}
			else{
				date_default_timezone_set('Europe/Athens');    
				$log = "Update stis ".date("d/m/Y")." ".date("H:i:s").", to proion: ".$value['itemcode']." woocode: ".$value['woocode']." lanthasmena. Error: ".$problem->message."";
				$file = fopen("logs/products.log","a");
				fwrite($file,$log.PHP_EOL);
				fclose($file);								
			}
		}
	}
	sleep(0.1);
}

$xmlstr = "<Items/>";

$items = new SimpleXMLElement($xmlstr);

$arrayLength = count($resources_id);

for ($i = 0; $i < $arrayLength; $i++) {
	$item = $items->addChild('Item');
	$item->addChild('itemcode', $resources_id[$i][0]);
	$item->addChild('woocode', $resources_id[$i][1]);
	//$item->addChild('woocode2', $resources_id[$i][2]);
	$item->addChild('revision', $resources_id[$i][2]);
	$item->addChild('balance', $resources_id[$i][3]);
}

$id_json=json_encode($items);

if ($arrayLength > 0){
	try
	{
        	$data3 = array('cookie' => $cookie1, 'apicode' => PYL_API_APICODE, 'entitycode' => PYL_API_ITEM_ENTITYCODE_POST, 'data' => $id_json);
        	$url3 = PYL_API_POSTDATA_URL;
        	$data_string3 = json_encode($data3);

        	$ch3 = curl_init();
        	curl_setopt($ch3, CURLOPT_URL, $url3);
        	curl_setopt($ch3, CURLOPT_POST, true);
        	curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
        	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        	curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
           		'Content-Type: application/json',
           		'Content-Length: ' . strlen($data_string3)));

        	//execute post
        	$return3 = curl_exec($ch3);
			if(SHOW_CONNECTION_VAR_DUMPS){
				echo "POST TO PYLON RETURN: <br>";
				var_dump($return3);
				echo "<br><br>";
			}
        	//close connection
        	curl_close($ch3);

			if(SHOW_MESSAGES){
				echo "WooCommerce Item code send<br>";
			}
	}
	catch (Exception $e)
	{
        	// Here we are dealing with errors
        	$trace = $e->getTrace();
        	if ($trace[0]['args'][0] == 404) echo 'Bad ID<br>';
        	else if ($trace[0]['args'][0] == 401) echo 'Bad auth key<br>';
        	else echo 'Other error<br />'.$e->getMessage();
	}
}
			if(SHOW_MESSAGES){
				echo "Items Uploaded Succesfully<br>";
			}
			
			echo '<script language="javascript">
			document.getElementById("expitems").disabled = false;
			</script>';

}

?>
</body></html>
