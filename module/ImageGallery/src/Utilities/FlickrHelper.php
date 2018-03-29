<?php
namespace ImageGallery\Utilities;

class FlickrHelper 
{
	const END_POINT ="https://api.flickr.com/services/rest/";
	
  private static $image_search_options = array(  
  	//'per_page' => 10,   
  	'page'     => 100,   
  	'license'  => '1,2,3,4,5,6',
  	'extras'   => 'url_t,url_l',
  	'format'   => 'php_serial'
	);  

  private static function build_url_query(){
   	 $query = '';
     foreach (self::$image_search_options as $key => $value) {
     	if ($key === 'license' || $key === 'extras'){
        $query .= "&$key=".urlencode($value);
     	} else {
     	  $query .= "&$key=$value";
      }
     }
     return $query;
   }

	public static function searchImages($api_key, $query = null) { 
   	  $search_str = urlencode($query);
      $endpoint = self::END_POINT.'?method=flickr.photos.search&api_key=' . $api_key . '&text=' . $search_str .self::build_url_query(); 
       
      $result = file_get_contents($endpoint);
      $result = unserialize($result);
      return $result;
    
     }
}
?>