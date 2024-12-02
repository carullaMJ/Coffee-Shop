        // Function to toggle the visibility of the floating form
        function visible() {
            var form = document.getElementById('formOverlay');
            form.style.display = 'block';
        }
        function toggleForm() {
            var form = document.getElementById('formOverlay');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';

        }
        function secondForm() {
            var form = document.getElementById('formOverlay');
            var pin = document.getElementById('pinOverlay');
            form.style.display = 'none';
            pin.style.display = 'block'
        }
        function togglePin() {
            var pin = document.getElementById('pinOverlay');
            pin.style.display = (pin.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }

        function signin() {
            var log = document.getElementById('logIn');
            var qr = document.getElementById('display');
            if (log.style.display === 'block') {
                qr.style.display = 'block';
                log.style.display = 'none';
                document.getElementById('myAnchor').innerText = 'Log In'
            } else if (log.style.display === 'none' || log.style.display === '') {
                qr.style.display = 'none';
                log.style.display = 'block';
                document.getElementById('myAnchor').innerText = 'Display'
            }
        }