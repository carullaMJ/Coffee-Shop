        var selectPosition = document.getElementById('accountPosition');

        selectPosition.addEventListener("change", function() {
            var pin = document.getElementById('pin');
            pin.style.display = (selectPosition.value === 'admin') ? 'block' : 'none';
        })

        var signInPosition = document.getElementById('positionInput');

        signInPosition.addEventListener("change", function() {
            var pin = document.getElementById('pinAdmin');
            var input = document.getElementById('firstForm');
            if (signInPosition.value === 'Admin') {
                input.style.display = 'none';
                pin.style.display = 'block';
            }
        })

        
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
            pin.style.display = 'block';
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

        function floatingPin () {
            var pin = document.getElementById('floatingPin');
            var log = document.getElementById('logIn');
            log.style.display = 'none';
            pin.style.display = 'block';

        }



        // Products slide bar
        function updateProducts () {
            var navbar = document.querySelector('.products');
            var main = document.getElementById('main-tables');

            navbar.style.bottom = '0';
            main.style.marginBottom = '50%';
        }
        function closeButton () {
            var navbar = document.querySelector('.products');
            var main = document.getElementById('main-tables');

            navbar.style.bottom = '-100%';
            main.style.marginBottom = '-50%';
        }

        function toggleProd() {
            var form = document.getElementById('prodOverlay');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';

        }
        function newProd() {
            var form = document.getElementById('prodOverlay');
            form.style.display = 'block';
        }

        function toggleDelProd() {
            var form = document.getElementById('prodDelOverlay');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';

        }
        function delProd() {
            var form = document.getElementById('prodDelOverlay');
            form.style.display = 'block';
        }

        function gotoIndex() {
            window.location.href = "../logout.php";
        }

        function toggleDelAcct() {
            var form = document.getElementById('acctDelOverlay');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';

        }
        function delAcct() {
            var form = document.getElementById('acctDelOverlay');
            form.style.display = 'block';
        }