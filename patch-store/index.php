<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('./config.php');
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
	<title>Patch Store | The Hull Seals</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<link rel="stylesheet" type="text/css" href="https://hullseals.space/assets/css/allPages.css" />
	<script src="https://hullseals.space/assets/javascript/allPages.js" integrity="sha384-PsQdnKGi+BdHoxLI6v+pi6WowfGtnraU6GlDD4Uh5Qw2ZFiDD4eWNTNG9+bHL3kf" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
	<script src="https://js.stripe.com/v3/" integrity="sha384-27nzGYg76b15eCFCLLp7LUYtjUIDtrU5yu652E4VI/drnOYG+AjglhW5//pB47Df" crossorigin="anonymous"></script>
		<script>
		$(document).on('change', '.div-toggle', function() {
		  var target = $(this).data('target');
		  var show = $("option:selected", this).data('show');
		  $(target).children().addClass('hide');
		  $(show).removeClass('hide');
		});
		$(document).ready(function(){
		    $('.div-toggle').trigger('change');
		});</script>

</head>
<body>
	<div id="home">
		<header>
			<nav class="navbar container navbar-expand-lg navbar-expand-md navbar-dark" role="navigation">
				<a class="navbar-brand" href="../"><img alt="Logo" class="d-inline-block align-top" height="30" src="../images/emblem_scaled.png"> Hull Seals</a><button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-target="#navbarNav" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span></button>
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
							<a class="nav-link" href="https://hullseals.space/users">Login/Register</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<section class="introduction">
			<article>
				<h1>Hull Seals Patches</h1>
				<br />
				<p>Here you can purchase our high-quality embroidered patches of the Hull Seals shield logo, perfectly sized for display or use!</p>
        <!--<p>All Patches will be sent to Billing Addresses provided unless we are contacted to the contrary within 2 days.</p> -->
				<hr>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="sealPatch.png" class="w-50 d-block" alt="Hull Seal Patch">
            </div>
            <div class="carousel-item">
              <img src="Hull-Seals_scan.png" class="w-50 d-block" alt="Patch with Measurements">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <br />
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <button class="increment-btn btn btn-secondary" id="subtract" disabled>-</button>
          </div>
          <input type="number" id="quantity-input" min="1" value="1" />
          <div class="input-group-append">
            <button class="increment-btn btn btn-secondary" id="add">+</button>
          </div>
        </div>
        <p class="sr-legal-text">Number of Patches (max 5)</p>
<div class="input-group">
  <div class="input-group-prepend">
    <label class="input-group-text" for="curr_select">Currency</label>
  </div>
		<select id="curr_select" class="custom-select">
				<option>Choose...</option>
				<option value="USD">US Dollars</option>
				<option value="GBP">UK Pounds</option>
				<option value="EUR">Euros</option>
				<option value="CAD">Canadian Dollars</option>
				<option value="AUD">Australian Dollars</option>
		</select>
</div>
<div id="USD" class="curr_chart"> <br />
  <button id="patch-button" class="btn btn-success" data-checkout-mode="payment" data-price-id="price_1GsMQuG70gztiKLsheVUt5Sv">
            Buy for $<span id="totalUSD">12</span>.00
          </button>
</div>
<div id="GBP" class="curr_chart"> <br />
  <button id="patch-button" class="btn btn-success" data-checkout-mode="payment" data-price-id="price_1GsMRWG70gztiKLs2Y6tz2kL">
            Buy for £<span id="totalGBP">10</span>.00
          </button>
</div>
<div id="EUR" class="curr_chart"> <br />
  <button id="patch-button" class="btn btn-success" data-checkout-mode="payment" data-price-id="price_1GsMS0G70gztiKLssZiOWOpV">
            Buy for €<span id="totalEUR">11</span>.00
          </button>
</div>
<div id="CAD" class="curr_chart"> <br />
  <button id="patch-button" class="btn btn-success" data-checkout-mode="payment" data-price-id="price_HMJnrlPXrU0Gbj">
            Buy for $<span id="totalCAD">16</span>.00
          </button>
</div>
<div id="AUD" class="curr_chart"> <br />
  <button id="patch-button" class="btn btn-success" data-checkout-mode="payment" data-price-id="price_HMJfcDMnDJj4dg">
            Buy for $<span id="totalAUD">17</span>.00
          </button>
</div>
<br />
<p>If you have any questions, please email our team at <a class="btn btn-secondary" href="mailto:finance@hullseals.space" style="text-decoration: none;">finance@hullseals.space</a></p>
			</article>
		</section>
		<div class="clearfix"></div>
	</div>
	<footer class="page-footer font-small">
		<div class="container">
			<div class="row">
				<div class="col-md-9 mt-md-0 mt-3">
					<h5 class="text-uppercase">Hull Seals</h5>
					<p><em>The Hull Seals</em> were established in January of 3305, and have begun plans to roll out galaxy-wide!</p><a class="btn btn-sm btn-secondary" href="https://fuelrats.com/i-need-fuel">Need Fuel? Call the Rats!</a>
				</div>
				<hr class="clearfix w-100 d-md-none pb-3">
				<div class="col-md-3 mb-md-0 mb-3">
					<h5 class="text-uppercase">Links</h5>
					<ul class="list-unstyled">
						<li>
							<a href="https://twitter.com/HullSeals" target="_blank"><img alt="Twitter" height="20" src="../images/twitter_loss.png" width="20"></a> <a href="https://reddit.com/r/HullSeals" target="_blank"><img alt="Reddit" height="20" src="../images/reddit.png" width="20"></a> <a href="https://www.youtube.com/channel/UCwKysCkGU_C6V8F2inD8wGQ" target="_blank"><img alt="Youtube" height="20" src="../images/youtube.png" width="20"></a> <a href="https://www.twitch.tv/hullseals" target="_blank"><img alt="Twitch" height="20" src="../images/twitch.png" width="20"></a> <a href="https://gitlab.com/hull-seals-cyberseals" target="_blank"><img alt="GitLab" height="20" src="../images/gitlab.png" width="20"></a>
						</li>
						<li>
							<a href="#">Donate</a>
						</li>
						<li>
							<a href="https://hullseals.space/knowledge/books/important-information/page/privacy-policy">Privacy & Cookies Policy</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="footer-copyright">
			Site content copyright © 2019, The Hull Seals. All Rights Reserved. Elite Dangerous and all related marks are trademarks of Frontier Developments Inc.
		</div>
	</footer>
	<script>
	$(document).ready(function(){

	  //hides dropdown content
	  $(".curr_chart").hide();
	  //listen to dropdown for change
	  $("#curr_select").change(function(){
	    //rehide content on change
	    $('.curr_chart').hide();
	    //unhides current item
	    $('#'+$(this).val()).show();
	  });

	});
	</script>

	<script>
		 // Replace with your own publishable key: https://dashboard.stripe.com/test/apikeys
		 var PUBLISHABLE_KEY = 'pk_live_KiZ55OXEwCXcsyvKRoszm0mw00AJM6XE4j';
		 // Replace with the domain you want your users to be redirected back to after payment
		 var DOMAIN = location.href.replace(/[^/]*$/, '');

		 if (PUBLISHABLE_KEY === 'NULL') {
			 console.log(
				 'Replace the hardcoded publishable key with your own publishable key: https://dashboard.stripe.com/test/apikeys'
			 );
		 }

		 var stripe = Stripe(PUBLISHABLE_KEY);
     var basicPhotoButton = document.getElementById("patch-button");
           document
             .getElementById("quantity-input")
             .addEventListener("change", function(evt) {
               // Ensure customers only buy between 1 and 10 photos
               if (evt.target.value < MIN) {
                 evt.target.value = MIN;
               }
               if (evt.target.value > MAX) {
                 evt.target.value = MAX;
               }
             });

           var updateQuantity = function(evt) {
             if (evt && evt.type === "keypress" && evt.keyCode !== 13) {
               return;
             }

             var isAdding = evt.target.id === "add";
             var inputEl = document.getElementById("quantity-input");
             var currentQuantity = parseInt(inputEl.value);

             document.getElementById("add").disabled = false;
             document.getElementById("subtract").disabled = false;

             var quantity = isAdding ? currentQuantity + 1 : currentQuantity - 1;

             inputEl.value = quantity;
             document.getElementById("totalUSD").textContent = quantity * 12;
             inputEl.value = quantity;
             document.getElementById("totalEUR").textContent = quantity * 11;
             inputEl.value = quantity;
             document.getElementById("totalCAD").textContent = quantity * 16;
             inputEl.value = quantity;
             document.getElementById("totalGBP").textContent = quantity * 10;
             inputEl.value = quantity;
             document.getElementById("totalAUD").textContent = quantity * 17;


             // Disable the button if the customers hits the max or min
             if (quantity === MIN) {
               document.getElementById("subtract").disabled = true;
             }
             if (quantity === MAX) {
               document.getElementById("add").disabled = true;
             }
           };

           Array.from(document.getElementsByClassName("increment-btn")).forEach(
             element => {
               element.addEventListener("click", updateQuantity);
             }
           );
		 // Handle any errors from Checkout
		 var handleResult = function (result) {
			 if (result.error) {
				 var displayError = document.getElementById('error-message');
				 displayError.textContent = result.error.message;
			 }
		 };
var MIN = 1;
var MAX = 5;
		 document.querySelectorAll('button').forEach(function (button) {
			 button.addEventListener('click', function (e) {
				 var mode = e.target.dataset.checkoutMode;
				 var priceId = e.target.dataset.priceId;
         var quantity = parseInt(
          document.getElementById("quantity-input").value
        );
				 // Make the call to Stripe.js to redirect to the checkout page
				 // with the sku or plan ID.
				 stripe
					 .redirectToCheckout({
						 mode: mode,
						 lineItems: [{ price: priceId, quantity: quantity }],
             billingAddressCollection: 'required',
             shippingAddressCollection: {
               allowedCountries: ['AC', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'AO', 'AQ', 'AR', 'AT', 'AU', 'AW', 'AX', 'AZ', 'BA', 'BB', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BL', 'BM', 'BN', 'BO', 'BQ', 'BR', 'BS', 'BT', 'BV', 'BW', 'BY', 'BZ', 'CA', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM', 'CN', 'CO', 'CR', 'CV', 'CW', 'CY', 'CZ', 'DE', 'DJ', 'DK', 'DM', 'DO', 'DZ', 'EC', 'EE', 'EG', 'EH', 'ER', 'ES', 'ET', 'FI', 'FJ', 'FK', 'FO', 'FR', 'GA', 'GB', 'GD', 'GE', 'GF', 'GG', 'GH', 'GI', 'GL', 'GM', 'GN', 'GP', 'GQ', 'GR', 'GS', 'GT', 'GU', 'GW', 'GY', 'HK', 'HN', 'HR', 'HT', 'HU', 'ID', 'IE', 'IL', 'IM', 'IN', 'IO', 'IQ', 'IS', 'IT', 'JE', 'JM', 'JO', 'JP', 'KE', 'KG', 'KH', 'KI', 'KM', 'KN', 'KR', 'KW', 'KY', 'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU', 'LV', 'LY', 'MA', 'MC', 'MD', 'ME', 'MF', 'MG', 'MK', 'ML', 'MM', 'MN', 'MO', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ', 'NA', 'NC', 'NE', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU', 'NZ', 'OM', 'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT', 'PY', 'QA', 'RE', 'RO', 'RS', 'RU', 'RW', 'SA', 'SB', 'SC', 'SE', 'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM', 'SN', 'SO', 'SR', 'SS', 'ST', 'SV', 'SX', 'SZ', 'TA', 'TC', 'TD', 'TF', 'TG', 'TH', 'TJ', 'TK', 'TL', 'TM', 'TN', 'TO', 'TR', 'TT', 'TV', 'TW', 'TZ', 'UA', 'UG', 'US', 'UY', 'UZ', 'VA', 'VC', 'VE', 'VG', 'VN', 'VU', 'WF', 'WS', 'XK', 'YE', 'YT', 'ZA', 'ZM', 'ZW', 'ZZ'],
             },
						 successUrl:
							 DOMAIN + 'success.php?session_id={CHECKOUT_SESSION_ID}',
						 cancelUrl:
							 DOMAIN + 'canceled.php?session_id={CHECKOUT_SESSION_ID}',
					 })
					 .then(handleResult);
			 });
		 });
	 </script>
</body>
</html>
