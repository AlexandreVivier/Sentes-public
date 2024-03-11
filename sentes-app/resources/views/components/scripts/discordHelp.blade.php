<script>
    document.addEventListener('DOMContentLoaded', function() {

        let link = document.getElementById('discordHelp');
        let dialog = document.querySelector('dialog');
        let closeButton = document.getElementById('close');


        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });

        closeButton.addEventListener('click', function() {
            dialog.close();
        });

    });
</script>
