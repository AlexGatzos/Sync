<html><head><title>Master synchronization</title></head><body>
<?php

//require_once('1a_CategoriesSync.php');
//require_once('1b_ExtraCategoriesSync.php');
//require_once('1c_BrandsSync.php');
require_once('2_ItemsSync.php');
require_once('3_ImagesSync.php');
require_once('4_ProductVariationSync.php');


set_time_limit(0);

//CatSync();
//sleep(1);
//ExtraCatSync();
//sleep(1);
//BrandSync();
//sleep(1);
ItemsSync();
sleep(1);
ProdVarSync();
sleep(1);
ImagSync();
sleep(1);
//ProdVarPhotoSync();


//sleep(1);
//CustAddrSync();
//sleep(10);
//OrdSync();
//sleep(10);
//OrdStSync();
//sleep(10);
//SpPrSync();

?>
</body></html>
