<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^=assignList-]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let contentId = this.id.split('-')[1];
                let dialog = document.getElementById('assignListToContent-' + contentId);
                dialog.showModal();
            });
        });
    });
</script>
