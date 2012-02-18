<article class="area right">
    <section class="title">
        user console
    </section>

    logged in as <?php echo $this->user['username']; ?> [ <a href='/user/logout'>logout</a> ]

</article>

<article class="area left">
    <section class="title">
        tools to manage your site
    </section>
 
    <p>
        <a href="/category/manage">Category Manager</a>
    </p>

    <p>
        <a href="/blog/manage">Blog Manager</a>
    </p>

    <p>
        <a href="/link/manage">Link Editor</a>
    </p>
</article>