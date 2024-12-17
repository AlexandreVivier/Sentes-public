<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^=seeAllRit-]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let listId = this.id.split('-')[1];
                let dialog = document.getElementById('seeAllRituals-' + listId);
                dialog.showModal();
            });
        });
    });
</script>
