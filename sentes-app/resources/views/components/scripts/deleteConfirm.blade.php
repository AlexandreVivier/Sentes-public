<script>
    document.addEventListener('DOMContentLoaded', function() {

        let link = document.getElementById('delete');
        let dialog = document.querySelector('dialog');

        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });
    });
</script>
