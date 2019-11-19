<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ip='Unable To Log';
$cloudflareIPRanges = array(
    '204.93.240.0/24',
    '204.93.177.0/24',
    '199.27.128.0/21',
    '173.245.48.0/20',
    '103.21.244.0/22',
    '103.22.200.0/22',
    '103.31.4.0/22',
    '141.101.64.0/18',
    '108.162.192.0/18',
    '190.93.240.0/20',
    '188.114.96.0/20',
    '197.234.240.0/22',
    '198.41.128.0/17',
    '162.158.0.0/15'
);
 
//NA by default.
$ip = 'NA';
 
//Check to see if the CF-Connecting-IP header exists.
if(isset($_SERVER["HTTP_CF_CONNECTING_IP"])){
    
    //Assume that the request is invalid unless proven otherwise.
    $validCFRequest = false;
    
    //Make sure that the request came via Cloudflare.
    foreach($cloudflareIPRanges as $range){
        //Use the ip_in_range function from Joomla.
        if(ip_in_range($_SERVER['REMOTE_ADDR'], $range)) {
            //IP is valid. Belongs to Cloudflare.
            $validCFRequest = true;
            break;
        }
    }
    
    //If it's a valid Cloudflare request
    if($validCFRequest){
        //Use the CF-Connecting-IP header.
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    } else{
        //If it isn't valid, then use REMOTE_ADDR. 
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
} else{
    //Otherwise, use REMOTE_ADDR.
    $ip = $_SERVER['REMOTE_ADDR'];
}
 
//Define it as a constant so that we can
//reference it throughout the app.
define('IP_ADDRESS', $ip);

//$lgd_ip='notLogged';
$lgd_ip=$ip;
$db = include 'db.php';
$mysqli = new mysqli($db['server'], $db['user'], $db['pass'], $db['db'], $db['port']);
$platformList = [];
$res = $mysqli->query('SELECT * FROM platform_lu ORDER BY platform_id');
while ($row = $res->fetch_assoc()) {
    if ($row['platform_name'] == 'ERR') {
        continue;
    }
    $platformList[$row['platform_id']] = $row['platform_name'];
}

$statusList = [];
$res = $mysqli->query('SELECT * FROM succ_lu ORDER BY succ_id');
while ($row = $res->fetch_assoc()) {
    if ($row['success_name'] == 'ERR') {
        continue;
    }
    $statusList[$row['succ_id']] = $row['success_name'];
}

$typeList = [];
$res = $mysqli->query('SELECT * FROM stuck_lu ORDER BY stuck_ID');
while ($row = $res->fetch_assoc()) {
    if ($row['stuck_desc'] == 'ERR') {
        continue;
    }
    $typeList[$row['stuck_ID']] = $row['stuck_desc'];
}

$dispatchList = [];
$res = $mysqli->query('SELECT * FROM dispatched_lu ORDER BY dispatch_id');
while ($row = $res->fetch_assoc()) {
    if ($row['dispatched_name'] == 'ERR') {
        continue;
    }
    $dispatchList[$row['dispatch_id']] = $row['dispatched_name'];
}

$validationErrors = [];
$data = [];
if (isset($_GET['send'])) {
    foreach ($_REQUEST as $key => $value) {
        $data[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
    }
    if (strlen($data['lead_kf']) > 45) {
        $validationErrors[] = 'commander name too long';
    }
	    if (strlen($data['client_nm']) > 45) {
        $validationErrors[] = 'commander name too long';
    }
    if (strlen($data['curr_sys']) > 100) {
        $validationErrors[] = 'system too long';
    }
	    if (strlen($data['curr_planet']) > 10) {
        $validationErrors[] = 'planet too long';
    }
    if (strlen($data['curr_coord']) > 10) {
        $validationErrors[] = 'coordinates too long';
    }
	if (!isset($statusList[$data['case_stat']])) {
        $validationErrors[] = 'invalid status';
    }
    if (!isset($dispatchList[$data['dispatched']])) {
        $validationErrors[] = 'invalid dispatching type';
    }
    if (!isset($lgd_ip)) {
        $validationErrors[] = 'invalid IP Address';
    }
	
	

    if (!count($validationErrors)) {
        $stmt = $mysqli->prepare('CALL spCreateRecCleanerKF(?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param('sssssiiiissss', $data['lead_kf'], $data['client_nm'], $data['curr_sys'], $data['curr_planet'], $data['curr_coord'], $data['platform'], $data['case_stat'], $data['case_type'], $data['dispatched'], $data['dispatcher'], $data['other_kf'], $data['notes'], $lgd_ip);
        $stmt->execute();
        foreach ($stmt->error_list as $error) {
            $validationErrors[] = 'DB: ' . $error['error'];
        }
        $stmt->close();
		header("Location: kfsuccess.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../favicon.ico" rel="icon" type="image/x-icon">
        <link href="../favicon.ico" rel="shortcut icon" type="image/x-icon">
        <meta charset="UTF-8">
        <meta content="Wolfii Namakura" name="author">
        <meta content="hull seals, elite dangerous, distant worlds, seal team fix, mechanics, dw2" name="keywords">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport">
        <meta content="Welcome to the Hull Seals, Elite Dangerous's Premier Hull Repair Specialists!" name="description">
        <title>Kingfisher Paperwork | The Hull Seals</title>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link href="../styles.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="//cdnpub.websitepolicies.com/lib/cookieconsent/1.0.2/cookieconsent.min.css" />
        <script src="//cdnpub.websitepolicies.com/lib/cookieconsent/1.0.2/cookieconsent.min.js"></script>
        <script>
            window.addEventListener("load", function () {
                window.wpcc.init({
                    "colors": {
                        "popup": {
                            "background": "#222222",
                            "text": "#ffffff",
                            "border": "#bd9851"
                        },
                        "button": {
                            "background": "#bd9851",
                            "text": "#000000"
                        }
                    },
                    "border": "thin",
                    "corners": "small",
                    "padding": "small",
                    "margin": "small",
                    "transparency": "25",
                    "fontsize": "small",
                    "content": {
                        "href": "https://hullseals.space/knowledge/books/important-information/page/cookie-policy"
                    }
                });
            });
        </script>
        <style>
            .input-group-prepend input[type="checkbox"] {
                margin-right: 5px;
            }
            label {
                user-select: none;
            }
        </style>
    </head>

    <body>
        <div id="home">
            <header>
                <nav class="navbar container navbar-expand-lg navbar-expand-md navbar-dark" role="navigation">
                    <a class="navbar-brand" href="../"><img src="../images/emblem_scaled.png" height="30" class="d-inline-block align-top" alt="Logo"> Hull Seals</a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="../">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../knowledge">Knowledge Base</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../journal">Journal Reader</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../contact">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login/Register</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <section class="introduction">
                <article>
                    <h1>Kingfisher Case Paperwork</h1>
					<hr />
                    <?php
                    if (count($validationErrors)) {
                        foreach ($validationErrors as $error) {
                            echo '<div class="alert alert-danger">' . $error . '</div>';
                        }
                        echo '<br>';
                    }
                    ?>
                    <form action="?send" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="lead_kf" value="<?= $data['lead_kf'] ?? '' ?>" class="form-control" placeholder="Lead Kingfisher Name" aria-label="Lead Kingfisher Name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="client_nm" value="<?= $data['client_nm'] ?? '' ?>" class="form-control" placeholder="Client Name" aria-label="Client Name" required>
                        </div>
						<div class="input-group mb-3">
                            <input type="text" name="curr_sys" value="<?= $data['curr_sys'] ?? '' ?>" class="form-control" placeholder="System" aria-label="System" required>
                        </div>
						<div class="input-group mb-3">
                            <input type="text" name="curr_planet" value="<?= $data['curr_planet'] ?? '' ?>" class="form-control" placeholder="Planet" aria-label="Planet" required>
                        </div>
						<div class="input-group mb-3">
                            <input type="text" name="curr_coord" value="<?= $data['curr_coord'] ?? '' ?>" class="form-control" placeholder="Coordinates" aria-label="Coordinates" required>
                        </div>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Platform</span>
                            </div>
                            <select name="platform" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                                <?php
                                foreach ($platformList as $platformId => $platformName) {
                                    echo '<option value="' . $platformId . '"' . ($data['platform'] == $platformId ? ' checked' : '') . '>' . $platformName . '</option>';
                                }
                                ?>
                            </select>
                        </div>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Was the Case Successful?</span>
                            </div>
                            <select name="case_stat" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                                <?php
                                foreach ($statusList as $statusId => $statusName) {
                                    echo '<option value="' . $statusId . '"' . ($data['case_stat'] == $statusId ? ' checked' : '') . '>' . $statusName . '</option>';
                                }
                                ?>
                            </select>
                        </div>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Case Type?</span>
                            </div>
                            <select name="case_type" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                                <?php
                                foreach ($typeList as $typeId => $typeName) {
                                    echo '<option value="' . typeId . '"' . ($data['case_type'] == $typeId ? ' checked' : '') . '>' . $typeName . '</option>';
                                }
                                ?>
                            </select>
                        </div>
						<div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Was the Case Dispatched?</span>
                            </div>
                            <select name="dispatched" class="custom-select" id="inputGroupSelect01" placeholder="Test" required>
                                <?php
                                foreach ($dispatchList as $dispatchId => $dispatchName) {
                                    echo '<option value="' . $dispatchId . '"' . ($data['dispatched'] == $dispatchId ? ' checked' : '') . '>' . $dispatchName . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="dispatcher" value="<?= $data['dispatcher'] ?? '' ?>" class="form-control" placeholder="Who was Dispatching? (If None, Leave Blank)" aria-label="Who was Dispatching?">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="other_kf" value="<?= $data['other_kf'] ?? '' ?>" class="form-control" placeholder="Any other Fishers on the Case? (If None, Leave Blank)" aria-label="Others">
                        </div>

						<div class="input-group mb-3">
                            <textarea name="notes" value="<?= $data['notes'] ?? '' ?>" class="form-control" placeholder="Notes (optional)" aria-label="Notes (optional)" rows="4"><?= $data['notes'] ?? '' ?></textarea>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </article>
            </section>
        </div>
        <footer class="page-footer font-small">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 mt-md-0 mt-3">
                        <h5 class="text-uppercase">Hull Seals</h5>
                        <p><em>The Hull Seals</em> were established in January of 3305, and have begun plans to roll out galaxy-wide!</p>
                        <a href="https://fuelrats.com/i-need-fuel" class="btn btn-sm btn-secondary">Need Fuel? Call the Rats!</a>
                    </div>
                    <hr class="clearfix w-100 d-md-none pb-3">
                    <div class="col-md-3 mb-md-0 mb-3">
                        <h5 class="text-uppercase">Links</h5>

                        <ul class="list-unstyled">
                            <li><a href="https://twitter.com/HullSeals" target="_blank"><img alt="Twitter" height="20" src="../images/twitter_loss.png" width="20"></a> <a href="https://reddit.com/r/HullSeals" target="_blank"><img alt="Reddit" height="20" src="../images/reddit.png" width="20"></a> <a href="https://www.youtube.com/channel/UCwKysCkGU_C6V8F2inD8wGQ" target="_blank"><img alt="Youtube" height="20" src="../images/youtube.png" width="20"></a> <a href="https://www.twitch.tv/hullseals" target="_blank"><img alt="Twitch" height="20" src="../images/twitch.png" width="20"></a> <a href="https://gitlab.com/hull-seals-cyberseals" target="_blank"><img alt="GitLab" height="20" src="../images/gitlab.png" width="20"></a></li>
                            <li><a href="/donate">Donate</a></li>
                            <li><a href="https://hullseals.space/knowledge/books/important-information/page/privacy-policy">Privacy & Cookies Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                Site content copyright © 2019, The Hull Seals. All Rights Reserved. Elite Dangerous and all related marks are trademarks of Frontier Developments Inc. <span class="float-right pr-3" title="Your IP might be logged for security reasons"><img src="ip-icon.png" witdh="16" height="16" alt="IP"/> Logged - <?php echo $ip ?></span>
            </div>
        </footer>
    </body>

</html>