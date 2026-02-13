@if (env('RECAPTCHA_SITE_KEY'))
    <script src='https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}&onload=onloadCallback&render=explicit'></script>
   	<script>
        function onloadCallback() {
	      grecaptcha.ready(function() {
	        grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
	          action: 'homepage'
	        }).then(function (token) {
	        	var recaptchaResponse = document.getElementById('recaptchaResponse');
	        	recaptchaResponse.value = token;
				console.log(recaptchaResponse.value );
	        });
	      });
	    }
    </script>
@endif