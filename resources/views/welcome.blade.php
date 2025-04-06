<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Scanner with WebUSB</title>
</head>
<body>

    <h1>USB Device Information</h1>
    <button id="getDeviceButton">Get USB Device</button>
    <div id="outputDevice"></div>
    <h1>Fingerprint Scanner with WebUSB</h1>
    <button id="connectButton">Connect Fingerprint Device</button>
    <button id="scanButton" disabled>Start Scan</button>
    <div id="output"></div>

    <script>
        document.getElementById('getDeviceButton').addEventListener('click', async () => {
            const outputDiv = document.getElementById('outputDevice');

            try {
                // Request access to a USB device
                const device = await navigator.usb.requestDevice({
                    filters: [] // Empty filters will show all devices
                });

                // Display device information
                const vendorId = device.vendorId.toString(16).padStart(4, '0'); // Convert to hex
                const productId = device.productId.toString(16).padStart(4, '0'); // Convert to hex

                outputDiv.innerHTML = `
                    <p><strong>Device Name:</strong> ${device.productName || "Unknown"}</p>
                    <p><strong>Vendor ID:</strong> 0x${vendorId}</p>
                    <p><strong>Product ID:</strong> 0x${productId}</p>
                `;

                console.log('Vendor ID:', vendorId);
                console.log('Product ID:', productId);
            } catch (error) {
                console.error('Error:', error);
                outputDiv.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
            }
        });
        let device;

        // Function to log messages to the output div
        function logMessage(message) {
            const outputDiv = document.getElementById('output');
            outputDiv.innerHTML += `<p>${message}</p>`;
        }

        document.getElementById('connectButton').addEventListener('click', async () => {
            try {
                // Request access to the fingerprint device
                device = await navigator.usb.requestDevice({
                    filters: [{ vendorId: 0x2c0f, productId: 0x1005 }] // Replace 0x1234 with your device's Vendor ID
                });

                // Open the device
                await device.open();
                logMessage('Device connected.');

                // Select a configuration and claim the interface
                await device.selectConfiguration(1); // Choose the appropriate configuration for your device
                await device.claimInterface(0); // Replace 0 with the correct interface number

                logMessage('Device ready. You can now start scanning.');
                document.getElementById('scanButton').disabled = false;
            } catch (error) {
                console.error('Error:', error);
                logMessage(`Error: ${error.message}`);
            }
        });

        document.getElementById('scanButton').addEventListener('click', async () => {
            try {
                if (!device) {
                    logMessage('No device connected.');
                    return;
                }

                // Example command to start the fingerprint scan
                const startScanCommand = new Uint8Array([0x01, 0x02]); // Replace with the actual command for your device
                await device.transferOut(1, startScanCommand); // Replace 1 with the correct OUT endpoint

                logMessage('Scan started. Awaiting response...');

                // Read the response from the device
                const result = await device.transferIn(1, 64); // Replace 1 with the correct IN endpoint
                const fingerprintData = new Uint8Array(result.data.buffer);
                logMessage(`Fingerprint Data: ${Array.from(fingerprintData).join(', ')}`);

            } catch (error) {
                console.error('Error:', error);
                logMessage(`Error: ${error.message}`);
            }
        });
    </script>
</body>
</html>
 -->


 <!DOCTYPE html>
 <html>
 <head>
     <title>Debug USB Device</title>
 </head>
 <body>
     <button id="connectButton">Connect USB Device</button>
     <div id="output"></div>
 
     <script>
        document.getElementById('connectButton').addEventListener('click', async () => {
        const outputDiv = document.getElementById('output');
        try {
            console.log(navigator.usb ? "WebUSB is supported" : "WebUSB is not supported");
            logMessage('Requesting USB device...');
            const device = await navigator.usb.requestDevice({ filters: [{ vendorId:11279, productId: 4101 }] });
            console.log('Device:', device);
            logMessage('Device selected.');

            logMessage('Opening device...');
            await device.open(); // This step might throw the SecurityError
            logMessage('Device opened.');

            logMessage('Available configurations:');
            console.log(device.configurations);

            logMessage('Selecting configuration...');
            await device.selectConfiguration(1); // Adjust configuration index as necessary
            logMessage('Configuration selected.');

            logMessage('Claiming interface...');
            await device.claimInterface(0); // Adjust interface number as necessary
            logMessage('Interface claimed. Device ready for communication.');
        } catch (error) {
            console.error('Error:', error);
            logMessage(`Error: ${error.message}`);
        }

        function logMessage(message) {
            outputDiv.innerHTML += `<p>${message}</p>`;
        }
    });


     </script>
 </body>
 </html>
 