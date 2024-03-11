<script>
    document.addEventListener('DOMContentLoaded', function() {

        let link = document.getElementById('showTerms');
        let dialog = document.querySelector('dialog');

        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });

        dialog.addEventListener('close', function() {

            if (dialog.returnValue === 'accept') {
                document.getElementById('accepted_terms').checked = true;
            } else {
                document.getElementById('accepted_terms').checked = false;
            }
        });
    });
</script>
