<?php
    require_once($_SERVER['DOCUMENT_ROOT'] .'/vendor/autoload.php');
    use Aws\S3\S3Client; 
    
    // Amazon S3 API credentials 
    $region = 'us-east-1'; 
    $version = 'latest'; 
    $access_key_id = 'AKIAUKM74AQDIHHWB3UE'; 
    $secret_access_key = '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'; 
    $bucket = 'saqs'; 
    
    
    $statusMsg = ''; 
    $status = 'danger'; 
    // Instantiate an Amazon S3 client 
    $s3 = new S3Client([ 
        'version' => $version, 
        'region'  => $region, 
        'credentials' => [ 
            'key'    => $access_key_id, 
            'secret' => $secret_access_key
        ],
        'suppress_php_deprecation_warning' => true
    ]); 
?>