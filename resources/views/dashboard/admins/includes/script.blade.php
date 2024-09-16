<!-- Core JS Files -->
<script src="{{ asset('js/jquery.3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- Charts Plugin -->
<script src="{{ asset('js/chartist.min.js') }}"></script>

<!-- Notifications Plugin -->
<script src="{{ asset('js/bootstrap-notify.js') }}"></script>

<!-- Google Maps Plugin -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{ asset('js/light-bootstrap-dashboard.js?v=1.4.0') }}"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="{{ asset('js/demo.js') }}"></script>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#activitiesTable').DataTable();
    });

    $(document).ready(function() {
        $('#usersTable').DataTable();
    });
</script>

<script>
    // Automatically hide the alert after 2 seconds
    window.setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000); // 2000 milliseconds = 2 seconds

    function confirmLogout(event) {
        event.preventDefault(); // Prevent the default behavior (i.e., navigating to the link)

        // Show confirmation dialog
        var userConfirmed = confirm("Are you sure you want to log out?");

        // If the user confirms, proceed with the logout
        if (userConfirmed) {
            // Get the href attribute from the event's target
            var href = event.currentTarget.getAttribute('href');
            // Redirect to the href
            window.location.href = href;
        }

        // If the user cancels, do nothing (this will stop the logout)
        return false;
    }


    function confirmDelete(event) {
        event.preventDefault(); // Prevent the default behavior (i.e., navigating to the link)

        // Show confirmation dialog
        var userConfirmed = confirm("Are you sure you want to delete this?");

        // If the user confirms, proceed with the logout
        if (userConfirmed) {
            // Get the href attribute from the event's target
            var href = event.currentTarget.getAttribute('href');
            // Redirect to the href
            window.location.href = href;
        }

        // If the user cancels, do nothing (this will stop the logout)
        return false;
    }
</script>
