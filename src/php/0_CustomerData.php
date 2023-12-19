<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// WooCommerce API Connection data

define('WP_SHOP_PATH', 'https://www.zakroshoes.gr/wp-json/wc/v3');				// WooCommerce link
define('WP_CK_AUTH_KEY', 'ck_7a9f31c70fa11fe3593f4a35d04b327de4f19acb');	// WooCommerce Consumer key
define('WP_CS_AUTH_KEY', 'cs_cb700aaebcb09fb79792732b4b97675c7e8c437d');	// WooCommerce Consumer secret

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pylon ERP API Connection data

define('PYL_API_USERNAME', 'eshop');						// Pylon ERP API username
define('PYL_API_PASSWORD', 'LJUCS58C1WYW2VA');					// Pylon ERP API password
define('PYL_API_APICODE', 'LJUCS58C1WYW2VA');					// Pylon ERP API apicode
define('PYL_API_APPLICATIONNAME', 'Hercules.MyPylonCommercial');		// Pylon ERP API application name
define('PYL_API_DATABASEALIAS', 'zakroike');					// Pylon ERP API database alias
define('PYL_API_URL', 'http://62.103.71.130:8024/');				// Pylon ERP API general url //79.129.48.223:8024 192.168.4.250:7024
define('PYL_API_LOGIN_URL', PYL_API_URL.'exesjson/login');			// Pylon ERP API login url
define('PYL_API_GETDATA_URL', PYL_API_URL.'exesjson/getdata');			// Pylon ERP API get data url
define('PYL_API_POSTDATA_URL', PYL_API_URL.'exesjson/postdata');		// Pylon ERP API post data url
define('PYL_API_PACKAGESIZE', '2000');						// Pylon ERP API package size

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Pylon ERP API Script Name data

define('PYL_API_CAT_ENTITYCODE_GET', 'CategoriesItems');			// Pylon ERP API Categories get data script name
define('PYL_API_CAT_ENTITYCODE_POST', 'CategCodeWordPr');			// Pylon ERP API Categories post data script name

define('PYL_API_XTRACAT_ENTITYCODE_GET', 'CategExtraItems');			// Pylon ERP API Extra Categories get data script name
define('PYL_API_XTRACAT_ENTITYCODE_POST', 'CategExtraCode');    		// Pylon ERP API Extra Categories post data script name

define('PYL_API_BRAND_ENTITYCODE_GET', 'BrandsWooPr');				// Pylon ERP API Brands get data script name
define('PYL_API_BRAND_ENTITYCODE_POST', 'BrandsCodeWooPr');			// Pylon ERP API Brands get data script name

define('PYL_API_ITEM_ENTITYCODE_GET', 'ItemsAllWordPr');			// Pylon ERP API Items get data script name
define('PYL_API_ITEM_ENTITYCODE_POST', 'ItemCodeWordPr');			// Pylon ERP API Items post data script name

define('PYL_API_IMAG_ENTITYCODE_GET', 'ItemPhotoWordPr');				// Pylon ERP API Images get data script name
define('PYL_API_IMAG_ENTITYCODE_POST', 'PhotoCodeWordPr');			// Pylon ERP API Images post data script name

define('PYL_API_PRODVAR_ENTITYCODE_GET', 'VarItemWordPr');			// Pylon ERP API Product Variations get data script name
define('PYL_API_PRODVARSALES_ENTITYCODE_GET', 'VarItemsSales');			// Pylon ERP API Product Variations get data script name
define('PYL_API_PRODVAR_ENTITYCODE_POST', 'VarCodeWordPr');			// Pylon ERP API Product Variations post data script name
define('PYL_API_PRODVARPH_ENTITYCODE_GET', 'VarPhotoWordPr');			// Pylon ERP API Product Photo Variations get data script name

define('PYL_API_CUST_ADDR_ENTITYCODE_POST', 'CustomersWordPr');			// Pylon ERP API Customers and Addresses post data script name

define('PYL_API_ORD_ENTITYCODE_POST', 'SalordersWordPr');			// Pylon ERP API Orders post data script name

define('PYL_API_ORDST_ENTITYCODE_POST', 'StatusOrders');			// Pylon ERP API Orders Status post data script name

//define('PYL_API_SPECPR_ENTITYCODE_GET', 'PriceListCust');			// Pylon ERP API Special Prices get data script name
//define('PYL_API_SPECPR_ENTITYCODE_POST', 'ProsfCode');               		// Pylon ERP API Special Prices post data script name
define('PYL_API_PRODVAR_DELETE_GET', 'ItemVarListWp');
define('PYL_API_PRODVAR_DELETE_POST', 'DelVarListWp');


?>
