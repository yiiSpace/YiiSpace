来自《lavavel 5 essential》一书
>
    Cross-site scripting (XSS) attacks happen when attackers are able to place client-side
    JavaScript code in a page viewed by other users. In our application, assuming that
    the name of our cat is not escaped, if we enter the following snippet of code as the
    value for the name, every visitor will be greeted with an alert message everywhere
    the name of our cat is displayed:
    Evil Cat <script>alert('Meow!')</script>    
    While this is a rather harmless script, it would be very easy to insert a longer script
    or link to an external script that steals the session or cookie values. To avoid this kind
    of attack, you should never trust any user-submitted data or escape any dangerous
    characters. You should favor the double-brace syntax ({{ $value }}) in your Blade
    templates, and only use the {!! $value !!} syntax, where you're certain the data is
    safe to display in its raw format.