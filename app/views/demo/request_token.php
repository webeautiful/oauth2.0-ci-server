<article class="home" role="main">
<?php if(isset($token->access_token)):?>
    <div role="main">
        <h3>Token Retrieved!</h3>
        <pre><code>  Access Token: <?php echo $token->access_token;?>  </code></pre>
        <?php if(isset($token->from_cache) && isset($token->expires_rest)):?>
            <div class="help"><em>Expires in the rest of <?php echo $token->expires_rest;?> seconds. Access token is obtained from cache</em></div>
        <?php else:?>
            <div class="help"><em>Expires in <?php echo $token->expires_in;?> seconds</em></div>
        <?php endif;?>
        <p>Now use this token to make a request to the OAuth2.0 Server's APIs:</p>
        <a class="button" href="/client/request_resource?token=<?php echo $token->access_token;?>">make a resource request</a>
        <div class="help"><em>This token can now be used multiple times to make API requests for this user.</em></div>
        <a href="/client/">back</a>
    </div>
<?php else:?>
    <div role="main">
        <h4>Error Retrieving Access Token:</h4>
        <p><?php echo $token->error_description;?></p>
        <a href="/client/">back</a>
    </div>
<?php endif;?>
</article>
