
	<?php

	function ItemsSync()
	{

		require_once('0_CustomerData.php');
		// require_once('slugifier.php');

		try {
			$data0 = array('username' => PYL_API_USERNAME, 'password' => PYL_API_PASSWORD, 'apicode' => PYL_API_APICODE, 'applicationname' => PYL_API_APPLICATIONNAME, 'databasealias' => PYL_API_DATABASEALIAS);

			$url = PYL_API_LOGIN_URL;
			$data_string = json_encode($data0);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt(
				$ch,
				CURLOPT_HTTPHEADER,
				array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string)
				)
			);

			//execute post
			$return1 = curl_exec($ch);
			//var_dump($return1);
			//close connection
			curl_close($ch);

			$result = json_decode($return1);
			$result1 = $result->Result;
			$cookie = json_decode($result1);
			$cookie1 = $cookie->cookie;

			$data2 = array('cookie' => $cookie1, 'apicode' => PYL_API_APICODE, 'entitycode' => PYL_API_ITEM_ENTITYCODE_GET, 'packagenumber' => '1', 'packagesize' => PYL_API_PACKAGESIZE);
			$url2 = PYL_API_GETDATA_URL;
			$data_string2 = json_encode($data2);

			$ch2 = curl_init();
			curl_setopt($ch2, CURLOPT_URL, $url2);
			curl_setopt($ch2, CURLOPT_POST, true);
			curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string2);
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
			curl_setopt(
				$ch2,
				CURLOPT_HTTPHEADER,
				array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($data_string2)
				)
			);

			//execute post
			$return2 = curl_exec($ch2);
			//var_dump($return2);
			//close connection
			curl_close($ch2);
		} catch (Exception $e) {
			// Here we are dealing with errors
			$trace = $e->getTrace();
			if ($trace[0]['args'][0] == 404)
				echo 'Bad ID<br>';
			else if ($trace[0]['args'][0] == 401)
				echo 'Bad auth key<br>';
			else
				echo 'Other error<br />' . $e->getMessage();
		}

		$resources_id = array();

		$result2 = json_decode($return2);
		$result3 = $result2->Result;
		$data3 = json_decode($result3, true);
		$data4 = $data3['Data'];
		$data5 = $data4['Items'];

		//var_dump($data5);
		echo '<br>Exoun erthei: ' . count($data5) . " eidi<br>";

		ob_end_flush();
		ob_implicit_flush();
		$counter = 1;
		foreach ($data5 as $value) {
			if ($value['woocode'] == null) {
				// New product
				echo $value['itemcode'] . '<br>';
				echo 'New product' . '<br>';
				echo 'Eimaste sto ' . $counter . '<br>';

				$product_cat_code_temp1 = array();
				$product_cat_code_temp2 = array();
				$product_cat_code_temp3 = array();
				$product_cat_code2 = array();
				$product_cat_code2a = array();
				$product_cat_code1 = 0;
				$product_cat_code1a = 0;

				$hedomain2atemp = explode(';', $value['hedomain2a']);
				$arrayLength = count($hedomain2atemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					$product_cat_code_temp1[] = array('id' => $hedomain2atemp[$i]);
				}

				//echo $value['hedomain2b'].'<br>';
	
				$hedomain2btemp = explode(';', $value['hedomain2b']);
				$arrayLength = count($hedomain2btemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					$product_cat_code_temp2[] = array('id' => $hedomain2btemp[$i]);
				}

				$hedomain2ctemp = explode(';', $value['hedomain2c']);
				$arrayLength = count($hedomain2ctemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					$product_cat_code_temp3[] = array('id' => (int) $hedomain2ctemp[$i]);
				}

				//var_dump($product_cat_code_temp2);
				//echo '<br>';
	
				$product_attr_code1temp = explode(';', str_replace(",", ".", $value['product_attr_code1']));
				$arrayLength = count($product_attr_code1temp);
				$product_attr_code_temp1 = strval($product_attr_code1temp[0]);
				$attr_default1temp = strval($product_attr_code1temp[0]);
				for ($i = 1; $i < $arrayLength; $i++) {
					$product_attr_code_temp1 = $product_attr_code_temp1 . ',' . strval($product_attr_code1temp[$i]);
				}

				$product_attr_code2temp = explode(';', str_replace(",", ".", $value['product_attr_code2']));
				$arrayLength = count($product_attr_code2temp);
				$product_attr_code_temp2 = strval($product_attr_code2temp[0]);
				$attr_default2temp = strval($product_attr_code2temp[0]);
				for ($i = 1; $i < $arrayLength; $i++) {
					$product_attr_code_temp2 = $product_attr_code_temp2 . ',' . strval($product_attr_code2temp[$i]);
				}

				if ($value['outlet'] == 0) {					// Oi katigories anikoun sto kanoniko katastima
					if ($value['hedomain1'] == 1) 				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1 = '40'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1 = '50'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1 = '251'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1 = '52'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2 = $product_cat_code_temp1;		// Deutereuousa katigoria
				}

				if ($value['outlet'] == 1) {					// Oi katigories anikoun sto outlet katastima
					if ($value['hedomain1'] == 1)				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1 = '54'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1 = '55'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1 = '252'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1 = '57'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2 = $product_cat_code_temp2;		// Deutereuousa katigoria
					$product_cat_code2[] = array('id' => '53');
				}
				//var_dump($product_cat_code2);
				//echo '<br>';
				//echo "<br>to product_cat_code1 einai: ".$product_cat_code1."<br>";
				$product_cat_code2[] = array('id' => $product_cat_code1);

				if ($value['newcollection'] == 1) {					// Oi katigories anikoun sto new collection katastima
					if ($value['hedomain1'] == 1)				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1a = '2816'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1a = '2817'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1a = '2819'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1a = '2818'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2a = $product_cat_code_temp3;		// Deutereuousa katigoria
					$product_cat_code2a[] = array('id' => '2786');
					$product_cat_code2a[] = array('id' => $product_cat_code1a);
					$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code2a);
					$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code_temp3);
					echo $product_cat_code2;
					//var_dump($product_cat_code2);
					//echo '<br>';
				}

				//TEST 
				// $product_cat_code2[] = array('id' => $product_cat_code1);
				// $product_cat_code1a = array();

				// if ($value['newcollection'] == 1) {					// Oi katigories anikoun sto new collection katastima
				// 	if ($value['hedomain1'] == 1)				// Katigoria antrika papoutsia sto pylon
				// 		$product_cat_code1a[] = '2816'; 			// Katigoria antrika papoutsia sto woocommerce
				// 	if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
				// 		$product_cat_code1a[] = '2817'; 			// Katigoria gunaikeia papoutsia sto woocommerce
				// 	if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
				// 		$product_cat_code1a[] = '2819'; 			// Katigoria tsantes sto woocommerce
				// 	if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
				// 		$product_cat_code1a[] = '2818';
				// 	if ($value['hedomain1'] == 5) 				// Katigoria unisex sto pylon
				// 		$product_cat_code1a[] = array('2816', '2817'); 		// Katigoria unisex sto woocommerce
				// 	$product_cat_code2a = $product_cat_code_temp3;	// Deutereuousa katigoria
				// 	$product_cat_code2a = array_merge($product_cat_code2a, $product_cat_code1a);
				// 	$product_cat_code2a[] = array('id' => '2786');
				// 	// $product_cat_code2a[] = array('id' => $product_cat_code1a);
				// 	$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code2a);
				// 	$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code_temp3);
				// 	//var_dump($product_cat_code2);
				// 	//echo '<br>';
				// }



				$visibletemp = 'visible';
				if ($value['visible'] == 'false') {
					$visibletemp = 'hidden';
				}

				$visibletemp1 = 'publish';
				if ($value['visible'] == "false") {
					$visibletemp1 = 'private';
				}

				if ($value['friendlyurl'] != null) {
					$frurl = $value['friendlyurl'];
				} else {
					$frurl = "adeio url";
				}

				$data = array(
					'name' => $value['title'],
					'slug' => url_slug($frurl),
					'type' => 'variable',
					'catalog_visibility' => $visibletemp,
					'description' => $value['long_description'],
					'short_description' => $value['short_description'],
					'sku' => $value['compcode2'],
					'manage_stock' => false,
					'status' => $visibletemp1,
					//'stock_quantity' => $value['Balance'],
					'categories' => $product_cat_code2,
					'attributes' => [
						[
							'id' => '2',
							'position' => 0,
							'visible' => true,
							'variation' => true,
							'options' => $product_attr_code_temp1
						],
						[
							'id' => '1',
							'position' => 1,
							'visible' => true,
							'variation' => true,
							'options' => $product_attr_code_temp2
						]
					],
					'default_attributes' => [
						[
							'id' => '2',
							'option' => $attr_default1temp
						],
						[
							'id' => '1',
							'option' => $attr_default2temp
						]
					],
					'meta_data' => [
						[
							'key' => 'website_title',
							'value' => $value['metatitle']
						],
						[
							'key' => 'outside_material',
							'value' => $value['special_attr_1']
						],
						[
							'key' => 'inside_material',
							'value' => $value['special_attr_2']
						],
						[
							'key' => 'sole_material',
							'value' => $value['special_attr_3']
						],
						[
							'key' => 'heel_height',
							'value' => $value['special_attr_4']
						],
						[
							'key' => 'boot_height',
							'value' => $value['special_attr_5']
						],
						[
							'key' => 'fiapa_height',
							'value' => $value['special_attr_6']
						],
						[
							'key' => '_yoast_wpseo_metadesc',
							'value' => " " //$value['metadesc']
						],
						[
							'key' => '_yoast_wpseo_title',
							'value' => $value['metatitle'] . ' - Zakro Shoes'
						],
						[
							'key' => 'company_code',
							'value' => $value['compcode1']
						],
						[
							'key' => '_company_code',
							'value' => $value['compcode2']
						],
						[
							'key' => 'season',
							'value' => $value['season']
						],
						[
							'key' => 'season_period',
							'value' => $value['season']
						],
						[
							'key' => 'season_year',
							'value' => $value['season_year']
						]
					],
					'brands' => array(intval($value['brandid']))
				);

				try {
					$url1 = WP_SHOP_PATH . '/products';
					$data_string1 = json_encode($data);
					echo $data_string1 . '<br>';

					$ch1 = curl_init();
					curl_setopt($ch1, CURLOPT_URL, $url1);
					curl_setopt($ch1, CURLOPT_POST, true);
					curl_setopt($ch1, CURLOPT_USERPWD, WP_CK_AUTH_KEY . ':' . WP_CS_AUTH_KEY);
					curl_setopt($ch1, CURLOPT_POSTFIELDS, $data_string1);
					curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
					curl_setopt(
						$ch1,
						CURLOPT_HTTPHEADER,
						array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen($data_string1)
						)
					);

					//execute post
					$return_post = curl_exec($ch1);

					//close connection
					curl_close($ch1);
					echo 'Product inserted succesfully<br>';
				} catch (Exception $e) {
					// Here we are dealing with errors
					$trace = $e->getTrace();
					if ($trace[0]['args'][0] == 404)
						echo 'Bad ID';
					else if ($trace[0]['args'][0] == 401)
						echo 'Bad auth key';
					else
						echo 'Other error<br />' . $e->getMessage();
				}

				//echo $return_post.'<br>';
	
				$obj2 = json_decode($return_post, true);
				$woocode1 = intval($obj2['id']);

				if ($woocode1 != 0) {
					$resources_id[] = array($value['itemcode'], $woocode1);
					echo $woocode1 . '<br>';
				} else {
					echo $return_post . '<br>';
				}

			} else // Existing product
			{
				echo "<br>---------------------------------------------<br>";
				print_mem();
				echo 'Eimaste sto ' . $counter . '<br>';
				echo "Existing product" . "<br>";
				echo $value['itemcode'] . "<br>";
				echo $value['woocode'] . "<br>";

				$product_cat_code_temp1 = array();
				$product_cat_code_temp2 = array();
				$product_cat_code_temp3 = array();
				$product_cat_code2 = array();
				$product_cat_code2a = array();
				$product_cat_code1 = array();

				$hedomain2atemp = explode(';', $value['hedomain2a']);
				$arrayLength = count($hedomain2atemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					$product_cat_code_temp1[] = array('id' => (string) $hedomain2atemp[$i]);
				}

				$hedomain2btemp = explode(';', $value['hedomain2b']);
				$arrayLength = count($hedomain2btemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					$product_cat_code_temp2[] = array('id' => (string) $hedomain2btemp[$i]);
				}

				$hedomain2ctemp = explode(';', $value['hedomain2c']);
				$arrayLength = count($hedomain2ctemp);
				for ($i = 0; $i < $arrayLength; $i++) {
					if ((string) $hedomain2ctemp[$i] != "") {
						$product_cat_code_temp3[] = array('id' => (string) $hedomain2ctemp[$i]);
					}
				}

				$product_attr_code1temp = explode(';', str_replace(",", ".", $value['product_attr_code1']));
				$arrayLength = count($product_attr_code1temp);
				$product_attr_code_temp1 = strval($product_attr_code1temp[0]);
				$attr_default1temp = strval($product_attr_code1temp[0]);
				for ($i = 1; $i < $arrayLength; $i++) {
					$product_attr_code_temp1 = $product_attr_code_temp1 . ',' . strval($product_attr_code1temp[$i]);
				}

				$product_attr_code2temp = explode(';', str_replace(",", ".", $value['product_attr_code2']));
				$arrayLength = count($product_attr_code2temp);
				$product_attr_code_temp2 = strval($product_attr_code2temp[0]);
				$attr_default2temp = strval($product_attr_code2temp[0]);
				for ($i = 1; $i < $arrayLength; $i++) {
					$product_attr_code_temp2 = $product_attr_code_temp2 . ',' . strval($product_attr_code2temp[$i]);
				}

				if ($value['outlet'] == 0) { // Oi katigories anikoun sto kanoniko katastima
					if ($value['hedomain1'] == 1) 				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1 = '40'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1 = '50'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1 = '251'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1 = '52'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2 = $product_cat_code_temp1;		// Deutereuousa katigoria
				}

				if ($value['outlet'] == 1) {					// Oi katigories anikoun sto outlet katastima
					if ($value['hedomain1'] == 1)				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1 = '54'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1 = '55'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1 = '252'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1 = '57'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2 = $product_cat_code_temp2;		// Deutereuousa katigoria
					$product_cat_code2[] = array('id' => '53');
				}
				//echo "<br>to product_cat_code1 einai: ".$product_cat_code1."<br>";
				$product_cat_code2[] = array('id' => $product_cat_code1);


				if ($value['newcollection'] == 1) {					// Oi katigories anikoun sto new collection katastima
					if ($value['hedomain1'] == 1)				// Katigoria antrika papoutsia sto pylon
						$product_cat_code1a = '2816'; 			// Katigoria antrika papoutsia sto woocommerce
					if ($value['hedomain1'] == 2) 				// Katigoria gunaikeia papoutsia sto pylon
						$product_cat_code1a = '2817'; 			// Katigoria gunaikeia papoutsia sto woocommerce
					if ($value['hedomain1'] == 3) 				// Katigoria tsantes sto pylon
						$product_cat_code1a = '2819'; 			// Katigoria tsantes sto woocommerce
					if ($value['hedomain1'] == 4) 				// Katigoria aksesouar sto pylon
						$product_cat_code1a = '2818'; 			// Katigoria aksesouar sto woocommerce
					$product_cat_code2a = $product_cat_code_temp3;		// Deutereuousa katigoria
					$product_cat_code2a[] = array('id' => '2786');
					$product_cat_code2a[] = array('id' => $product_cat_code1a);
					$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code2a);
					$product_cat_code2 = array_merge($product_cat_code2, $product_cat_code_temp3);
				}

				$visibletemp = 'visible';
				if ($value['visible'] == 'false') {
					$visibletemp = 'hidden';
				}

				if ($value['friendlyurl'] != null) {
					$frurl = $value['friendlyurl'];
				} else {
					$frurl = "adeio url";
				}

				$visibletemp1 = 'publish';
				if ($value['visible'] == "false") {
					$visibletemp1 = 'private';
				}
				echo "<br>categories: ";
				var_dump(json_encode($product_cat_code2));
				echo "<br>";

				$data = array(
					'name' => $value['title'],
					'slug' => url_slug($frurl),
					'type' => 'variable',
					'catalog_visibility' => $visibletemp,
					'description' => $value['long_description'],
					'short_description' => $value['short_description'],
					'sku' => $value['compcode2'],
					'manage_stock' => false,
					'status' => $visibletemp1,
					//'stock_quantity' => $value['Balance'],
					'categories' => $product_cat_code2,
					'attributes' => [
						[
							'id' => '2',
							'position' => 0,
							'visible' => true,
							'variation' => true,
							'options' => $product_attr_code_temp1
						],
						[
							'id' => '1',
							'position' => 1,
							'visible' => true,
							'variation' => true,
							'options' => $product_attr_code_temp2
						]
					],
					'default_attributes' => [
						[
							'id' => '2',
							'option' => $attr_default1temp
						],
						[
							'id' => '1',
							'option' => $attr_default2temp
						]
					],
					'meta_data' => [
						[
							'key' => 'website_title',
							'value' => $value['metatitle']
						],
						[
							'key' => 'outside_material',
							'value' => $value['special_attr_1']
						],
						[
							'key' => 'inside_material',
							'value' => $value['special_attr_2']
						],
						[
							'key' => 'sole_material',
							'value' => $value['special_attr_3']
						],
						[
							'key' => 'heel_height',
							'value' => $value['special_attr_4']
						],
						[
							'key' => 'boot_height',
							'value' => $value['special_attr_5']
						],
						[
							'key' => 'fiapa_height',
							'value' => $value['special_attr_6']
						],
						[
							'key' => '_yoast_wpseo_metadesc',
							'value' => " " //$value['metadesc']
						],
						[
							'key' => '_yoast_wpseo_title',
							'value' => $value['metatitle'] . ' - Zakro Shoes'
						],
						[
							'key' => 'company_code',
							'value' => $value['compcode1']
						],
						[
							'key' => '_company_code',
							'value' => $value['compcode2']
						],
						[
							'key' => 'season',
							'value' => $value['season']
						],
						[
							'key' => 'season_period',
							'value' => $value['season']
						],
						[
							'key' => 'season_year',
							'value' => $value['season_year']
						]
					],
					'brands' => array(intval($value['brandid']))
				);

				try {
					$url3 = WP_SHOP_PATH . '/products/' . $value['woocode'];
					$data_string3 = json_encode($data);
					//echo $data_string3."<br>";
					$ch3 = curl_init();
					curl_setopt($ch3, CURLOPT_URL, $url3);
					curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'PUT');
					curl_setopt($ch3, CURLOPT_USERPWD, WP_CK_AUTH_KEY . ':' . WP_CS_AUTH_KEY);
					curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
					curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
					curl_setopt(
						$ch3,
						CURLOPT_HTTPHEADER,
						array(
							'Content-Type: application/json',
							'Content-Length: ' . strlen($data_string3)
						)
					);

					//execute post
					$return_put = curl_exec($ch3);
					//echo '<br>'.$return_put."<br>";
					echo '<br>';
					var_dump($return_put);
					//close connection
					curl_close($ch3);
					echo 'Product updated succesfully<br>';
				} catch (Exception $e) {
					// Here we are dealing with errors
					$trace = $e->getTrace();
					if ($trace[0]['args'][0] == 404)
						echo 'Bad ID';
					else if ($trace[0]['args'][0] == 401)
						echo 'Bad auth key';
					else
						echo 'Other error<br />' . $e->getMessage();
				}
			}
			sleep(0.1);
			//echo '<br>'."eimai sto: ".$counter.'<br>';
			$counter++;
		}

		$xmlstr = "<Items/>";

		$items = new SimpleXMLElement($xmlstr);

		$arrayLength = count($resources_id);

		for ($i = 0; $i < $arrayLength; $i++) {
			$item = $items->addChild('Item');
			$item->addChild('itemcode', $resources_id[$i][0]);
			$item->addChild('woocode', $resources_id[$i][1]);
		}

		$id_json = json_encode($items);

		if ($arrayLength > 0) {
			try {
				$data3 = array('cookie' => $cookie1, 'apicode' => PYL_API_APICODE, 'entitycode' => PYL_API_ITEM_ENTITYCODE_POST, 'data' => $id_json);
				$url3 = PYL_API_POSTDATA_URL;
				$data_string3 = json_encode($data3);

				$ch3 = curl_init();
				curl_setopt($ch3, CURLOPT_URL, $url3);
				curl_setopt($ch3, CURLOPT_POST, true);
				curl_setopt($ch3, CURLOPT_POSTFIELDS, $data_string3);
				curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
				curl_setopt(
					$ch3,
					CURLOPT_HTTPHEADER,
					array(
						'Content-Type: application/json',
						'Content-Length: ' . strlen($data_string3)
					)
				);

				//execute post
				$return3 = curl_exec($ch3);

				//close connection
				curl_close($ch3);

				echo "woocode send<br>";
			} catch (Exception $e) {
				// Here we are dealing with errors
				$trace = $e->getTrace();
				if ($trace[0]['args'][0] == 404)
					echo 'Bad ID<br>';
				else if ($trace[0]['args'][0] == 401)
					echo 'Bad auth key<br>';
				else
					echo 'Other error<br />' . $e->getMessage();
			}
		}

		echo "Items Uploaded Succesfully<br>";

	}

	function print_mem()
	{
		/* Currently used memory */
		$mem_usage = memory_get_usage();

		/* Peak memory usage */
		$mem_peak = memory_get_peak_usage();

		echo 'The script is now using: <strong>' . round($mem_usage / 1024) . 'KB</strong> of memory.<br>';
		echo 'Peak usage: <strong>' . round($mem_peak / 1024) . 'KB</strong> of memory.<br><br>';
	}

	?>
