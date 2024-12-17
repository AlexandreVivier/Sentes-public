<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^=seeAllMisc-]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let listId = this.id.split('-')[1];
                let dialog = document.getElementById('seeAllMiscellaneouses-' + listId);
                dialog.showModal();
            });
        });
    });
</script>
