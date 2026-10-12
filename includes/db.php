<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// 2. Import the required AWS client classes
    use Aws\S3\S3Client;
    use Aws\DynamoDb\DynamoDbClient;
    use Aws\Exception\AwsException;

// Common configuration array
    $awsConfig = [
        'region'  => 'us-east-1',  // Replace with your preferred AWS Region
        'version' => 'latest'      // Uses the latest API version of the service
    ];

try {
    // 3. Instantiate the Amazon S3 Client
        $s3Client = new S3Client($awsConfig);
        $bucketName = 'saqs';

    // 4. Instantiate the Amazon DynamoDB Client
        $dynamodbClient = new DynamoDbClient($awsConfig);
        $tableName = 'saqs_sessions';

    //echo "Both clients initialized successfully!";

} catch (AwsException $e) {
    // Handle potential AWS connection initialization errors
        echo "Initialization error: " . $e->getMessage();
}

class Session
{
    public function start_session()
    {
        if(!isset($_SESSION))
        {
            session_start();
        };
    }

    public function flush(): void
    {
        $this->start_session();
        session_destroy();
    }

    public function set($mykey, $myvalue = '')
    {
        $this->start_session();
        if(is_string($mykey))
        {
            $_SESSION[$mykey] = $myvalue;
        }
        else if(is_array($mykey))
        {
            foreach($mykey as $key => $value)
            {
                $_SESSION[$key] = $value;
            };
        }
    }

    public function append($arr)
    {
        $this->start_session();
        if(is_array($arr))
        {
            foreach($arr as $key => $value)
            {
                $_SESSION[$key] = $value;
            };
        }
    }

    public function get($key)
    {
        $this->start_session();
        if(isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        };
    }

    public function remove($key)
    {
        $this->start_session();
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        };
    }

    public function exist($key)
    {
        $this->start_session();
        if(isset($_SESSION[$key]))
        {
            return true;
        };
        return false;
    }

    public function regenerate()
    {
        if(!isset($_SESSION))
        {
            session_start();
        };
        session_regenerate_id();
    }
}

$ses = new Session();
$ses->start_session();
//session_start();
$con = mysqli_connect($_ENV["DB_URL"], $_ENV["DB_USER"], $_ENV["DB_PASS"],"saqs");
//$con = mysqli_connect("localhost","root","","saqs");

// Check connection
  if (mysqli_connect_errno())
  {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

//DOB
    function age($dob)
    {
        $dateOfBirth = $dob;
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }