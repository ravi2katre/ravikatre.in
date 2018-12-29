<?php if ( !empty($ga_id) ): ?>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', '<?php echo $ga_id; ?>', 'auto');
	ga('send', 'pageview');
</script>
<?php endif; ?>

<script>
    //alert("ddd")
        //console.log("DOM fully loaded and parsed");

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('464fe91876e8af33346d', {
            cluster: 'ap2',
            encrypted: false
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(data.message);

        });

</script>
<?php $this->system_message->render(); ?>