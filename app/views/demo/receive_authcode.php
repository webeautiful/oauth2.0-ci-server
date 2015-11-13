<article class="home" role="main">
    <?php if(isset($code)):?>
    <div role="main">
        <h3>Authorization Code Retrieved!</h3>
        <p>We have been given an <strong>Authorization Code</strong> from the OAuth2.0 Server:</p>
        <pre><code>  Authorization Code: <?php echo $code;?>  </code></pre>
        <p>Now exchange the Authorization Code for an <strong>Access Token</strong>: </p>
        <p>
            <a class="button" href="/client/request_token?grant_type=authorization_code&code=<?php echo $code;?>&redirect_uri=<?php echo $redirect_uri;?>">make a token request</a>
        </p>
        <div class="help"><em>usually this is done behind the scenes, but we're going step-by-step so you don't miss anything!</em></div>
        <a href="/client/">back</a>
    </div>
    <?php else:?>
    <div role="main">
        <h3>Authorization Failed!</h3>
        <p><?php echo $error_description;?></p>
        <a href="/client/">back</a>
    </div>
    <?php endif;?>
</article>
