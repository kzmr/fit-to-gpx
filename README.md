# fit-to-gpx
## usage
Add the package adriangibbons/php-fit-file-analysis in a composer.json file and composer update
```
{
    "require": {
        "adriangibbons/php-fit-file-analysis": "^3.2.0"
    }
}
```
Require this FitToGpx.php file
```
require base_path().'/libs/fit-to-gpx/FitToGpx.php';
```
Call
```
$fitogpx = new \FitToGpx($input_file_path);
if ($errorMsg = $fitogpx->getError()) {
    \Log::error($errorMsg);
    return;
}
$fitogpx->saveAsGpx($output_file_path);
if ($errorMsg = $fitogpx->getError()) {
    \Log::error($errorMsg);
    return;
}
```