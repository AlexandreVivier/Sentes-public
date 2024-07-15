<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[id^=promoteOrga-]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                let attendeeId = this.id.split('-')[1];
                console.log(attendeeId);
                let dialog = document.getElementById('promoteOrgaModal-' + attendeeId);
                dialog.showModal();
            });
        });
    });
</script>
