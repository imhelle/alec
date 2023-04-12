<?php
/** @var $model UploadedData */

use app\models\UploadedData;
use kartik\file\FileInput;
use yii\helpers\Url;

echo FileInput::widget([
    'model' => $model,
    'attribute' => 'files[]',
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['/upload/upload']),
        'maxFileCount' => 100,
        'minFileCount' => 3,
        'uploadAsync' => false,
//        'hideThumbnailContent' => true,
        'browseIcon' => '<i class="fas fa-camera"></i>',
        'allowedFileExtensions' => ['xlsx'],
        'preferIconicPreview' => true, // this will force thumbnails to display icons for following file extensions
        'previewFileIcon' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="60" height="60" viewBox="0 0 256 256" xml:space="preserve">
<defs>
</defs>
<g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
	<path d="M 80.959 78.79 H 19.13 c -1.588 0 -2.876 -1.288 -2.876 -2.876 V 14.085 c 0 -1.588 1.288 -2.876 2.876 -2.876 h 61.829 c 1.588 0 2.876 1.288 2.876 2.876 v 61.829 C 83.835 77.503 82.547 78.79 80.959 78.79 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
	<path d="M 80.959 80.79 H 19.13 c -2.688 0 -4.876 -2.187 -4.876 -4.875 v -61.83 c 0 -2.688 2.188 -4.876 4.876 -4.876 h 61.829 c 2.688 0 4.876 2.188 4.876 4.876 v 61.83 C 85.835 78.604 83.647 80.79 80.959 80.79 z M 19.13 13.209 c -0.483 0 -0.876 0.393 -0.876 0.876 v 61.83 c 0 0.482 0.393 0.875 0.876 0.875 h 61.829 c 0.483 0 0.876 -0.393 0.876 -0.875 v -61.83 c 0 -0.483 -0.393 -0.876 -0.876 -0.876 H 19.13 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
	<rect x="61.05" y="20.47" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="61.05" y="31.74" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="61.05" y="43" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="61.05" y="54.26" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="61.05" y="65.53" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="39.76" y="20.47" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="39.76" y="31.74" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="39.76" y="43" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="39.76" y="54.26" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<rect x="39.76" y="65.53" rx="0" ry="0" width="15.93" height="4" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) "/>
	<polygon points="51.33,90 6.17,78.79 6.17,11.21 51.33,0 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,117,76); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
	<polygon points="38.15,28.21 31.01,28.62 26.67,37.72 22.56,29.1 15.8,29.48 23.2,45 15.8,60.52 22.56,60.9 26.67,52.28 31.01,61.38 38.15,61.79 30.14,45 " style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform="  matrix(1 0 0 1 0 0) "/>
</g>
</svg>',
        'fileActionSettings' => [
            'removeIcon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg>',
            'showZoom' => false,
            'showUpload' => false,
            
        ]
    ]
]);

?>

<style>
    div.wrap {
        margin-top: 90px;
    }

    .wrap .krajee-default .file-footer-caption {
        display: block;
        text-align: center;
        padding-top: 2px;
        font-size: 11px;
        color: #999;
        margin-bottom: 0;
    }

    .wrap .krajee-default.file-preview-frame .kv-file-content {
        width: 160px;
        height: 120px;
    }
</style>