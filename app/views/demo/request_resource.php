<?php if(!isset($res->error)):?>
<article class="home" role="main">
    <div role="main">
        <h3>Resource Request Complete!</h3>
        <p>You have successfully called the APIs with your Access Token.  Here are your friends:</p>
        <ul>
            <?php foreach($res->friends as $v):?>
            <li><?php echo $v;?> </li>
            <?php endforeach;?>
        </ul>
        <p>Here is the full JSON response: </p>

        <pre><?php echo json_encode($res);;?></pre>
        <pre><code>  The API call can be seen at <a href="<?php echo $resource_api;?>" target="_blank"><?php echo $resource_api;?></a></code></pre>
        <a href="/client/">back</a>
    </div>
</article>
<?php else:?>
<article class="home" role="main">
    <div role="main">
        <h3>Resource Request Complete!</h3>
        <h4>Response:</h4>
        <p><?php echo $res->error_description;?></p>
        <pre><code>  The API call can be seen at <a href="<?php echo $resource_api;?>" target="_blank"><?php echo $resource_api;?></a></code></pre>
        <a href="/client/">back</a>
    </div>
</article>
<?php endif;?>
