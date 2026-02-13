<?php
$route = request()->route();
if($route && $route->getName() == 'listing.view' && isset($listing)){
    $title = $listing->name;
    $description = "{$listing->name} , {$listing->fullAddress}" ;
    $keywords =  $description ;
}elseif($seo_data = \App\Http\Helpers\AppHelper::getPathSeo()){
    extract($seo_data);
}else{
    $title = $description = $keywords  = env('APP_NAME');
}
?>
<!-- Page Title -->
<title>{{ $title }}</title>

<!-- SEO Metadata -->
<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
