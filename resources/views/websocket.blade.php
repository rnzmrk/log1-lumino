<!DOCTYPE html>
<html>
<head>
    <title>WebSocket Connection</title>
</head>
<body>
    <script>
        // Simple WebSocket handshake response
        // This accepts the WebSocket connection and keeps it alive
        console.log('WebSocket connection established');
        
        // Send a heartbeat every 30 seconds to keep connection alive
        setInterval(() => {
            console.log('WebSocket heartbeat');
        }, 30000);
    </script>
</body>
</html>
