<?php
$config  = require_once 'config.php';
$baseUrl = $config['base_url'];

if (!isset($_GET['id'])) {
    exit('Invalid Request');
}

$id     = $_GET['id'];
$file   = 'settings/' . $id;
if (!file_exists($file)) {
    exit('ID not found');
}

$args   = explode(',', file_get_contents($file));
$url    = $args[1] . '/installs.json';
$ch     = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_USERPWD, "{$args[2]}:{$args[3]}");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);
if (!empty($response)) {
    $response = json_decode(trim($response));
} else {
    exit('No return found');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Track Product Installations</title>

    <!-- Bootstrap -->
    <link href="<?php echo $baseUrl;?>/plugins/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <h1>Result</h1>
                <?php if (count($response)): ?>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Invoice ID</th>
                            <th>Paid</th>
                            <th>Domain</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($response as $item): ?>
                        <tr>
                            <td><?php echo $item->name;?></td>
                            <td><?php echo $item->email;?></td>
                            <td><?php echo $item->invoice_id;?></td>
                            <td><?php echo $item->paid;?></td>
                            <td><?php echo $item->domain;?></td>
                            <td><?php echo $item->time_stamp;?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo $baseUrl;?>/plugins/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $baseUrl;?>/plugins/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </body>
</html>