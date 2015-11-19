<article class="home" role="main">
    <div  role="main">
        <h3>OAuth2.0 Demo Application</h3>
        <p>
            Welcome to the OAuth2.0 Demo Application!  This is an application that demos some of the basic OAuth2.0 Workflows.
        </p>

        <div class="simpleTabs">
            <ul class="simpleTabsNavigation">
                <li><a href="#authcode">Authorization Code</a></li>
                <li><a href="#implicit">Implicit</a></li>
                <li><a href="#clientcred">Client Credentials</a></li>
                <li><a href="#usercred">User Credentials</a></li>
                <li><a href="#refresh">Refresh Token</a></li>
                <li><a href="#openid">OpenID Connect</a></li>
            </ul>
            <div class="simpleTabsContent">
                <p>
                    The <code>Authorization Code</code> grant type is the most common workflow for OAuth2.0.  Clicking the "Authorize" button below will send you to an OAuth2.0 Server to authorize:
                </p>
                <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=code&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_authcode&state=55e68dcf03648f51ea555c8383bf58ce">Authorize</a>
            </div>
            <div class="simpleTabsContent">
                <p>
                    The <code>Implicit</code> grant type is very similar to the <code>Authorization Code</code> grant type,
                    except that the <code>Access Token</code> is returned as part of the URL fragment instead of an API
                    request to the OAuth2.0 Server. Clicking the "Authorize" button below will send you to an
                    OAuth2.0 Server to authorize:
                </p>
                <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=token&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_implicit_token&state=55e68dcf03648f51ea555c8383bf58ce">Authorize</a>
            </div>
            <div class="simpleTabsContent">
                <p>
                    The <code>Client Credentials</code> grant type is the most common workflow for OAuth2.0.  Clicking the "Get Access Token" button below will
                    obtain an <code>Access Token</code>.
                </p>
                <p>
                    The OAuth2 Server supports the following client credentials:
                </p>
                <ul>
                    <li><strong>App Key</strong>: demoapp</li>
                    <li><strong>App Secret</strong>: demopass</li>
                </ul>
                <p>Make the following cURL request to receive an access token:</p>
                <pre>
                    <code>  $ curl -u demoapp:demopass http://ci-oauth2.pigai.org/oauth2/access_token \
                        -d "grant_type=client_credentials"
                    </code>
                </pre>
                <p>...or just click below to let us do it for you<p>
                <a class="button" href="/client/request_token?grant_type=client_credentials">Get Access Token</a>
            </div>
            <div class="simpleTabsContent">
                <p>
                    The <code>User Credentials</code> grant type is a Two-Legged approach that allows you to
                    obtain an <code>Access Token</code> in exchange for a set of end-user credentials.
                </p>
                <p>
                    The OAuth2 Server supports the following user credentials:
                </p>
                <ul>
                    <li><strong>Username</strong>: demouser</li>
                    <li><strong>Password</strong>: testpass</li>
                </ul>
                <p>Make the following cURL request to receive an access token:</p>
                <pre>
                    <code>  $ curl "http://ci-oauth2.pigai.org/oauth2/access_token" \
                        -d "grant_type=password&client_id=demoapp&client_secret=demopass&username=demouser&password=testpass"
                    </code>
                </pre>
                <p>...or just click below to let us do it for you<p>
                <a class="button" href="/client/request_token?grant_type=password">Get Access Token</a>
            </div>
            <div class="simpleTabsContent">
                <p>
                    The <code>Refresh Token</code> grant type is typically used in tandem with the <code>Authorization Code</code> grant type. Click the "Authorize" button to receive an authorization code:
                </p>
                <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=code&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_authcode%3Fshow_refresh_token%3D1&state=55e68dcf03648f51ea555c8383bf58ce">Authorize</a>
            </div>
            <div class="simpleTabsContent">
                <p>
                    <strong>OpenID Connect</strong> is a special way of obtaining information about a user. Click the button below to go through the OpenID connect flow. It is initiated with an authorize request (just like in <code>Authorization Code</code>) but with the <code>scope</code> querystring parameter including the value <code>"openid"</code>.
                </p>

                <p>
                    <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=code&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_authcode&scope=openid&state=55e68dcf03648f51ea555c8383bf58ce&nonce=942163358">Authorization Code</a>
                    <div class="help">
                        Uses the Authorization Code Grant and adds the "openid" scope parameter. An ID Token comes back with the Access Token
                    </div>
                </p>

                <p>
                    <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=code%20id_token&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_authcode&scope=openid&state=55e68dcf03648f51ea555c8383bf58ce&nonce=71361434">Authorization Code + ID Token</a>
                    <div class="help">
                        Same as above, but with the "code id_token" response type. The ID Token comes back with the Authorization Code.
                    </div>
                </p>

                <p>
                    <a class="button" href="<?php echo API_URI;?>oauth2/authorize?response_type=token%20id_token&client_id=demoapp&redirect_uri=<?php echo $redirect_uri;?>client%2Freceive_implicit_token&scope=openid&state=55e68dcf03648f51ea555c8383bf58ce&nonce=125950800">Implicit</a>
                    <div class="help">
                        Uses the implicit grant type, but the Access Token also returns with an ID Token.
                    </div>
                </p>
            </div>
        </div>
    </div>
</article>
