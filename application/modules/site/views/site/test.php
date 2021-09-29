<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    grecaptcha.execute('6LdFXZccAAAAAD6iFvTtCDkzZVLnqwaQnEwcFtnY').then(
        function (token) {
            console.log(token);
        }
    );
</script>