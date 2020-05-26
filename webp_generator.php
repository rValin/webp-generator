$ressourceDir = __DIR__;
$webImageDir = 'webp'

$urlInfo = parse_url($_GET['src']);
$path = $urlInfo['path'];
$pathInfo = pathinfo($path);

switch (strtolower($pathInfo['extension'])) {
    case 'jpg':
    case 'jpeg':
        $image = imagecreatefromjpeg($path);
        break;
    case 'png':
        $image = imagecreatefrompng($path);
        break;
}


if (!$image){
  throw new \Exception('Generation of webp file failed')
}

$publicPath = $kernel->getProjectDir() . DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR;
if (!file_exists($publicPath.'webp' . DIRECTORY_SEPARATOR . $pathInfo['dirname'])) {
    mkdir($publicPath.'webp' . DIRECTORY_SEPARATOR . $pathInfo['dirname'], 0777, true);
}

$imgPath = 'webp' . DIRECTORY_SEPARATOR . $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.webp';
$webpPath = $publicPath . $imgPath;
imagewebp($image, $webpPath);

header('location: '.imgPath);
die();
