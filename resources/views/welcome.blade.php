<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - useful for debugging
        Pusher.logToConsole = true;

        // Create a new Pusher instance with your app key and cluster
        var pusher = new Pusher('00abb0f8e0a605eee189', {
            cluster: 'mt1'
        });

        // Subscribe to the public channel
        var channel = pusher.subscribe('public-messages');

        // Listen for the event (make sure it's broadcasted as .new-message)
        channel.bind('new-message', function(data) {
            alert('🔔 New Review Received:\n' + JSON.stringify(data, null, 2));
        });
    </script>
</head>
<body>
<h1>Pusher Real-Time Test</h1>
<p>
    Listening on channel <code>public-messages</code><br>
    for event <code>new-message</code>
</p>
</body>
</html>
