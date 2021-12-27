<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Declare Title, Content, Author
$pgAuthor = "David Sangrey";
$pgContent = "Welcome to the Hull Seals, Elite Dangerous's Premier Hull Repair Specialists!";
$useIP = 0; //1 if Yes, 0 if No.
$activePage = 'home';
//If you have any custom scripts, CSS, etc, you MUST declare them here.
//They will be inserted at the bottom of the <head> section.
$customContent = '<script src="analytics.js" integrity="tUmtZA6JAnP2bdPMeRqiljHV5WrtLJlQ4F/fTdNI0/ZxyqhzMqWEkmmJUcZ+chlw" crossorigin="anonymous"></script>
<script>
$(function () {
  $(\'[data-toggle="popover"]\').popover()
})
</script>
<style>
html {
    box-sizing: border-box;
    height: 100%;
}

body {
    background: #000000;
    font-family: \'Roboto Condensed\', sans-serif;
    font-size: 1.0em;
    color: #ffffff;
    display: flex;
    flex-direction: column;
    min-height: 100%;
    height: 100%;
}

.introduction article {
    background-color: rgba(20, 20, 20, 0.7);
    padding: 0.5rem;
    margin: 2rem 0;
}

.introduction article p {
    font-size: 1.5em;
}

.introduction .btn {
    text-transform: uppercase;
}

.hidden-xs {
    display: none;
}


@media (min-width: 576px) {
    .navbar-brand {
        display: initial;
    }

    .introduction article {
        background-color: rgba(20, 20, 20, 0.5);
        padding: 2rem;
        margin: 2rem;
    }
    .hidden-xs {
        display: initial;
    }
}

@media (min-width: 768px) {
    .navbar-brand {
        display: none;
    }

    .introduction article {
        max-width: 786px;
        float: right;
    }

    .page-footer {
        text-align: left;
    }
}

@media (min-width: 992px) {
    .navbar-brand {
        display: initial;
    }

    .introduction h1 {
        font-size: 3.4em;
    }
}


@media (min-width: 1890px) {
    .introduction article {
        margin-right: 10rem;
    }
}</style>
';

// NOTE ON INDEX: For some reason the box won't stay all the way right.
// Import all of the old CSS wholesale to override.
// TODO: This isn't very efficient. Too bad!

//UserSpice Required
require_once 'users/init.php';  //make sure this path is correct!
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>
                <h1>Welcome to the <em>Hull Seals</em><span class="hidden-xs">, your premier hull repair specialists</span>.</h1>
                <br /><br />
		<a href="repair-requests" class="btn btn-success btn-lg" >Request a Repair</a> <button type="button" class="btn btn-lg btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="The Hull Seals are a group of players dedicated to Hull Repairs, Broken Canopy rescues, or SRV strandings.">
  Who are the Hull Seals?
</button>

<?php
require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php';
