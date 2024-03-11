<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sessionMessage = document.querySelector('.session-message');

        if (sessionMessage) {
            function hideMessage() {
                sessionMessage.classList.add('fade-out');

                setTimeout(function() {
                    sessionMessage.style.display = 'none';
                }, 1000);
            }

            setTimeout(hideMessage, 1500);
        }
    });
</script>
