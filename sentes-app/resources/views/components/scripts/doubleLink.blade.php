<script>
    document.addEventListener('DOMContentLoaded', function() {
        let link = document.getElementById('double');
        let dialog = document.getElementById('doubleLink');

        if(link !== null){
        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });}
    });
</script>
