<script>
    document.addEventListener('DOMContentLoaded', function() {
    var navCheck = document.getElementById('nav-check');
    var navCheckProfile = document.getElementById('nav-check-profile');
    var navCheckBell = document.getElementById('nav-check-bell');


    navCheck.addEventListener('change', function() {
        if (navCheck.checked) {
            navCheckProfile.checked = false;
            navCheckBell.checked = false;
        }
    });

    navCheckProfile.addEventListener('change', function() {
        if (navCheckProfile.checked) {
            navCheck.checked = false;
            navCheckBell.checked = false;
        }
    });

    navCheckBell.addEventListener('change', function() {
        if (navCheckBell.checked) {
            navCheck.checked = false;
            navCheckProfile.checked = false;
        }
    });

});

</script>
