<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^=seeAllComm-]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let listId = this.id.split('-')[1];
                let dialog = document.getElementById('seeAllCommunities-' + listId);
                dialog.showModal();
            });
        });
    });
</script>