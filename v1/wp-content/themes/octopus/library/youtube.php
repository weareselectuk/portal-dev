<?php




/****************************
 YouTube functions
****************************/
/**
 *
 * @param string $url
 * @return mixed Youtube video ID or FALSE if not found
 */
function getYoutubeIdFromUrl($url) {
    $parts = parse_url($url);
    if(isset($parts['query'])){
        parse_str($parts['query'], $qs);
        if(isset($qs['v'])){
            return $qs['v'];
        }else if(isset($qs['vi'])){
            return $qs['vi'];
        }
    }
    if(isset($parts['path'])){
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path)-1];
    }
    return false;
}

/**
 *
 * @param string $id
 * @param string $size
 * @return YouTube thumbnail url
 */

function getVideoThumbnails($id, $size='maxres'){
  $apikey = 'AIzaSyABrtoL4syWOC7XMeyyIutY55cSYUNGqx0';
  $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id='.getYoutubeIdFromUrl($id).'&key='.$apikey;
  $content = file_get_contents($url);
  $video = json_decode($content, true);

  $url = $video['items'][0]['snippet']['thumbnails'][$size]['url'];

  if (!isset($url)){
    $url = $video['items'][0]['snippet']['thumbnails']['default']['url'];
  }
  return $url;
}

?>