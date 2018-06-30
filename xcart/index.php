<?

set_time_limit(3000);
    //$ip = '69.10.48.167';
         $dbhost = 'localhost';
         $dbname='mezonbag_xcart';
         $user = 'root';
         $password = 'dbbraindev123';
         $conn = mysql_connect($dbhost, $user, $password);
         if(! $conn ) {
            die('Could not connect: ' . mysql_error());
         }
       
        
	mysql_select_db($dbname,$conn);
	if($_GET['productid'] and isset($_GET)){ 
	$pridd=$_GET['productid'];
$str=mysql_query("select 
		 xcart_products.productid ,
		 xcart_products.productcode,
		 xcart_products.provider,
		 xcart_products.distribution,
		 xcart_products.weight,
		 xcart_products.list_price,
		 xcart_products.avail,
		 xcart_products.rating,
		 xcart_products.forsale,
		 xcart_products.add_date,
		 xcart_products.views_stats,
		 xcart_products.sales_stats,
		 xcart_products.del_stats,
		 xcart_products.shipping_freight,
		 xcart_products.free_shipping,
		 xcart_products.discount_avail,
		 xcart_products.min_amount,
		 xcart_products.length,
		 xcart_products.width,
		 xcart_products.height,
		 xcart_products.low_avail_limit,
		 xcart_products.free_tax,
		 xcart_products.product_type,
		 xcart_products.manufacturerid,
		 xcart_products.return_time,
		 xcart_products.meta_description,
		 xcart_products.meta_keywords,
		 xcart_products.small_item,
		 xcart_products.separate_box,
		 xcart_products.items_per_box,
		 xcart_products.title_tag,
		 xcart_products.on_sale,
		 xcart_products.mark_as_new,
		 xcart_products.show_as_new_from,
         xcart_products.show_as_new_to,
         xcart_products.taxcloud_tic,
         xcart_products_lng_en.productid,
         xcart_products_lng_en.product,
         xcart_products_lng_en.descr,
         xcart_products_lng_en.fulldescr,
         xcart_products_lng_en.keywords
		 from xcart_products inner join  xcart_products_lng_en on xcart_products.productid= xcart_products_lng_en.productid where xcart_products.productid=$pridd"); 
		 $product_details=mysql_fetch_assoc($str);
		 echo "<pre>";
//print_r($product_details); die;
		 
	
		$pid=$product_details['productid'];
	//---------------------------------------------GET AND SET VARIANT PRICE, WEIGHT, ETC-------------------------//
$vriantarray=array();
$vriantarrayprice=array();
$variantprice=mysql_query("select xcart_variants.variantid,
                                  xcart_variants.productid,
								  xcart_variants.avail,
								  xcart_variants.weight,
								  xcart_variants.productcode,
								  xcart_variants.def,
								  xcart_pricing.quantity,
								  xcart_pricing.price from xcart_variants inner join xcart_pricing on xcart_variants.variantid=xcart_pricing.variantid where xcart_variants.productid=$pid");
								  
								  
$productprice=mysql_query("select xcart_pricing.price from xcart_pricing  where xcart_pricing.productid=$pid");							 
while($varrow=mysql_fetch_assoc($productprice))
{

	$vriantarrayprice[]=$varrow;
}	

while($varrowv=mysql_fetch_assoc($variantprice))
{

	$vriantarray[]=$varrowv;
}

	 if($product_details['free_shipping']=='N'){
		 $free_shipping='false';
	 } else if($product_details['free_shipping']=='Y'){
		 $free_shipping='true';
	 }
    if($product_details['free_tax']=='N'){
		 $free_tax='false';
	 } else if($product_details['free_tax']=='Y'){
		 $free_tax='true';
	 }	 
		
		
///-----------------------------GET PRODUCT IMAGE  TABLE NAME --xcart_images_P  ---------------------------------//
		
		$strimage=mysql_query("select * from xcart_images_P where id=$pid");
		$product_images=mysql_fetch_assoc($strimage);
		
		$proudctimage=array();
		
		$proudctimage=array(
			'alt'=>$product_images['alt'],
			'width'=>$product_images['image_x'],
			'height'=>$product_images['image_y'],
			'hash'=>$product_images['md5'],
			'path'=>'https://www.mezonhandbags.com'.$product_images['image_path'],
			'fileName'=>$product_images['filename'],
			'mime'=>$product_images['image_type'],
			'size'=>$product_images['image_size']
		
			);

///-----------------------------END PRODUCT IMAGES CODE----------------------------------------------------------------------//	\

	
//error_reporting(-1);
set_time_limit(3000);

// init REST API
require_once 'vendor/autoload.php';
require_once 'RESTAPIClient.php';

// a path of your admin.php end-point
$storeUrl = 'https://www.fashionemall.com/admin.php';
$restApiKey = 'fashionstorereadwritekey008api';

$client = \RESTAPIClient::factory($storeUrl, $restApiKey);

$product = array(
     'sku' => $product_details['productcode'],
            'price' =>$vriantarrayprice[0]['price'],
            'amount' => $product_details['avail'],
			'weight' => $product_details['weight'],
			'quantity' => $product_details['low_avail_limit'],
			'enabled' => 'true',
			'free_shipping' =>$free_shipping,
			'taxable' => $free_tax,
			'arrivalDate' =>$product_details['add_date'],
    'translations' => array (
            array(
                'code' => 'en',
				 'price' =>$vriantarrayprice[0]['price'],
                'name' => $product_details['product'],
				'description'=>$product_details['fulldescr'],
				'briefDescription'=>$product_details['descr'],
				'metaTags'=>$product_details['meta_keywords'],
				'metaDesc'=>$product_details['meta_description'],
				'metaTitle'=>$product_details['title_tag'],
                ),
        ),
		  'images'=>array($proudctimage),
    );

// sending request
$result = $client->post('product/0', array('body' => $product))->json();

//--------------------------------------------GET ATTRIBUTE AND VARIANTS AND SEND--------------------------------------//

$productattribute=mysql_query("select * from xcart_classes where productid=$pid");
$productattribute=mysql_fetch_assoc($productattribute);
$classid=$productattribute['classid'];
$productattribute=mysql_query("select * from xcart_class_lng where classid=$classid");
$productattribute=mysql_fetch_assoc($productattribute);
$productattributevariants=mysql_query("select * from xcart_class_options where classid=$classid");
$aarayattr=array();
while($row=mysql_fetch_assoc($productattributevariants)){
	          $aarayattr[]=array(
                'translations' => array(
                    array(
                        'code' =>  $productattribute['code'],
                        'name' => $row['option_name']
                    )
                )
            );
			//array_push($aarayattr,$aaraya);
}

$productId =$result['product_id'];
 $attribute = array(
    array(
        'position'  => 0,
        'visible' => true,
        'type'  => 'S',
        'translations' => array(
            array(
                'code' => $productattribute['code'],
                'name' =>$productattribute['class']
            )
        ),
        'attribute_options' =>$aarayattr
    )
);

$result = $client->post('attribute', array('body' => $attribute))->json();

$attributeId = $result[0]['id'];
$attributeInfo = $client->get('attribute/' . $attributeId)->json();

$options = $attributeInfo['attribute_options'];

$attributeValueSelect = array();

foreach($options as $option) {
    $attributeValueSelect[] = array(
        'product' => array(
            'product_id' => $productId
        ),
        'attribute' => array(
            'id' => $attributeId
        ),
        'attribute_option' => array(
            'id' => $option['id']
        )
    );
}

$result = $client
    ->post('attributevalue-attributevalueselect', array('body' => $attributeValueSelect))
    ->json();

//print_r($result);
$variants =array();
$datavr=array();



  $vr=0; 
  foreach($result as $rst){    
   $datavr= array(
        'product' => array(
            'product_id' => $productId      
        ),
        'price' =>$vriantarray[$vr]['price'],
        'weight' =>$vriantarray[$vr]['weight'],
        'amount' =>$vriantarray[$vr]['quantity'],
        'sku' => $vriantarray[$vr]['productcode'],
        'defaultValue' => 0,
        // this is the record id in the xc_product_variant_attribute_value_select table
        'attributeValueS' => array(     
            array(
                'id' => $rst['id']
            )
        )
		
		
   
   ); 
   $vr++;
   array_push($variants,$datavr);
	 }


$result = $client->post('xc-productvariants-productvariant', array('body' => $variants))->json();

$imiterate=0;
$pid=$_REQUEST['productid'];
$variantimages="select * from xcart_images_D where id=$pid"; 
$dataimage=mysql_query($variantimages);

$ch = curl_init();
while($vimage=mysql_fetch_assoc($dataimage)){

$pvarid=$result[$imiterate]['id'];
$imgpath='https://www.mezonhandbags.com'.$vimage['image_path'];
$alt=$vimage['alt'];
$width=$vimage['image_x'];
$height=$vimage['image_y'];
$hash=$vimage['md5'];
$needProcess=1;
$fileName=$vimage['filename'];
$mime=$vimage['mime'];
$image_type=$vimage['image_type'];
$image_size=$vimage['image_size'];
$date=$vimage['date'];
curl_setopt($ch, CURLOPT_URL,"https://www.fashionemall.com/image.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
"product_variant_id=$pvarid&alt=$alt&width=$width&height=$height&hash=$hash&needProcess=$needProcess&path=$imgpath&fileName=$fileName&mime=$mime&storageType=$image_type&size=$image_size&date=$date");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
$imiterate++;
}










foreach($result as $reselect) {
$variantAttributes = array(             
    'variantsAttributes' => array(
         array(
            'id' => $reselect['id'],
            'product' => array(
                'product_id' => $productId
            )
        )
    )
);

$result = $client->put('product/' . $productId, array('body' => $variantAttributes))->json();

}
header('Location:http://dev1.brainpulse.org/xcartdemo/');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

  <form action="" method="get">
    <div class="form-group" style="margin-top: 54px;">
      <label for="usr">Product:</label>
	
      <select required  class="form-control" id="prid" name="productid">
	  <option>Select Product</option>
	    <? $strp=mysql_query("select productid,product from  xcart_products_lng_en");
		while($pr=mysql_fetch_assoc($strp)){?>
		<option value="<?=$pr['productid']?>"><?=$pr['product']?></option>
		<?}?>
		</select>
    </div>
  <input type="submit" value="Send Data">
  </form>
</div>

</body>
</html>
