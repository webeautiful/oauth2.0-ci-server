<article class="home" role="main">
    <div role="main">
        <h3>Token Retrieved!</h3>
        <pre><code>  Access Token: <span id="access_token_display"><a onclick="showAccessToken();">(click here to pull from URL fragment)</a></span> </code></pre>

        <div style="display:none" id="id_token">
            <p>And because you added "id_token" to your response type, you also received an ID token!
            </p><pre><code>  ID Token: <span id="id_token_display"><a onclick="showIDToken();">(click here to pull from URL fragment)</a></span> </code></pre>
        </div>

        <p>The following code snippet will be run to pull the token data from the URL fragment:</p>
        <pre><code>  // function to parse fragment and return access token
        function getAccessToken() {
            var queryString = window.location.hash.substr(1);
            var queries = queryString.split("&amp;");
            var params = {}
            for (var i = 0; i &lt; queries.length; i++) {
                pair = queries[i].split('=');
                params[pair[0]] = pair[1];
            }

            return params;
        };</code></pre>

        <div id="request_resource" style="display:none">
            <p>Now use this token to make a request to the OAuth2.0 Server's APIs:</p>
            <a class="button" href="<?php echo API_URI;?>client/request_resource" onclick="this.href += '?token='+(getAccessToken()).access_token;">make a resource request</a>
            <div class="help"><em>This token can now be used multiple times to make API requests for this user.</em></div>
        </div>
        <a href="/client/">back</a>

        <!-- Javascript for pulling the access token from the URL fragment -->
        <script>
            function getAccessToken() {
                var queryString = window.location.hash.substr(1);
                var queries = queryString.split("&");
                var params = {}
                for (var i = 0; i < queries.length; i++) {
                    pair = queries[i].split('=');
                    params[pair[0]] = pair[1];
                }

                return params;
            };

            // show the token parsed from the fragment, and show the next step
            var showAccessToken = function (e) {
                document.getElementById('access_token_display').innerHTML = accessToken.access_token;
                document.getElementById('request_resource').style.display = 'block';
            }

            var showIDToken = function (e) {
                document.getElementById('id_token_display').innerHTML = accessToken.id_token;
            }

            var accessToken = getAccessToken();
            if (accessToken.id_token) {
              document.getElementById('id_token').style.display = 'block';
            }
        </script>
    </div>
</article>
