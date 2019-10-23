<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_ip_address() {
    foreach (['REMOTE_ADDR', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED'] as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);

                if (filter_var($ip, FILTER_VALIDATE_IP,
                                FILTER_FLAG_IPV4 |
                                FILTER_FLAG_IPV6 |
                                FILTER_FLAG_NO_PRIV_RANGE |
                                FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    return '';
}

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

$validationErrors = [];
$data = [];
if (isset($_GET['send'])) {
    foreach ($_REQUEST as $key => $value) {
        $data[$key] = strip_tags(stripslashes(str_replace(["'", '"'], '', $value)));
    }

    if (strlen($data['cmdr_name']) > 50) {
        $validationErrors[] = 'commander name too long';
    }
    if (strlen($data['system']) > 100) {
        $validationErrors[] = 'system too long';
    }

    $data['hull'] = (int) $data['hull'];
    if ($data['hull'] > 100 || $data['hull'] < 1) {
        $validationErrors[] = 'invalid hull';
    }
    $data['canopy_breached'] = isset($data['canopy_breached']);
    $data['can_synth'] = isset($data['can_synth']);
    if ($data['o2_timer'] != '' && !preg_match('~[0-9]{1,2}:[0-9]{1,2}~i', $data['o2_timer'])) {
        $validationErrors[] = 'invalid O2 timer';
    }

    if (!isset($platformList[$data['platform']])) {
        $validationErrors[] = 'invalid platform';
    }

    if (!count($validationErrors)) {
        $stmt = $mysqli->prepare('CALL spCreateHSCaseCleaner(?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param('sissiisis', $data['cmdr_name'], $data['canopy_breached'], $data['o2_timer'], $data['system'], $data['platform'], $data['hull'], $data['description'], $data['can_synth'], get_ip_address());
        $stmt->execute();
        foreach ($stmt->error_list as $error) {
            $validationErrors[] = 'DB: ' . $error['error'];
        }
        $stmt->close();
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
        <title>Repair Requests | The Hull Seals</title>
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
            $(document).ready(function () {
                $('#canopy_breached').click(function () {
                    if ($('#canopy_breached input[name="canopy_breached"]').is(':checked')) {
                        $('.toggleVissibility').removeClass('invisible');
                        $('.toggleDisplay').removeClass('d-none');
                    } else {
                        $('.toggleVissibility').addClass('invisible');
                        $('.toggleDisplay').addClass('d-none');
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
                    <h1>Request Repairs</h1>
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
                            <input type="text" name="cmdr_name" value="<?= $data['cmdr_name'] ?? '' ?>" class="form-control" placeholder="Commander Name" aria-label="Commander Name" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="system" value="<?= $data['system'] ?? '' ?>" class="form-control" placeholder="System" aria-label="System" required>
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" min="1" max="100" name="hull" value="<?= $data['hull'] ?? '' ?>" class="form-control" placeholder="Hull %" aria-label="Hull %" required>
                        </div>
                        <div class="input-group mb-3 canopy_row">
                            <div class="input-group-prepend">
                                <label id="canopy_breached" class="input-group-text text-danger"><input type="checkbox" value="1" name="canopy_breached" aria-label="Canopy breached"<?= isset($data['canopy_breached']) && $data['canopy_breached'] == 1 ? ' checked' : '' ?>> Canopy breached ?</label>
                                <label class="input-group-text toggleVissibility<?= isset($data['canopy_breached']) && $data['canopy_breached'] == 1 ? '' : ' invisible' ?>"><input type="checkbox" name="can_synth" value="1" aria-label="O2 Synth"<?= isset($data['can_synth']) && $data['can_synth'] == 1 ? ' checked' : '' ?>>O2 Synth</label>
                            </div>
                            <input type="text" name="o2_timer" value="<?= $data['o2_timer'] ?? '' ?>" class="form-control toggleVissibility<?= isset($data['canopy_breached']) && $data['canopy_breached'] == 1 ? '' : ' invisible' ?>" pattern="[0-9]{1,2}:[0-9]{1,2}" placeholder="O2 Timer (nn:nn)" aria-label="O2 Timer (nn:nn)">
                        </div>
                        <div class="alert alert-danger toggleDisplay<?= isset($data['canopy_breached']) && $data['canopy_breached'] == 1 ? '' : ' d-none' ?>">If you haven't already LOG OUT IMMEDIATELY</div>
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
                            <textarea name="description" class="form-control" placeholder="How did you take damage (optional)" aria-label="How did you take damage (optional)" rows="4"><?= $data['description'] ?? '' ?></textarea>
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
                Site content copyright © 2019, The Hull Seals. All Rights Reserved. Elite Dangerous and all related marks are trademarks of Frontier Developments Inc. <span class="float-right pr-3" title="Your IP might be logged for security reasons"><img src="ip-icon.png" witdh="16" height="16" alt="IP"/> Logged</span>
            </div>
        </footer>
    </body>

</html>
