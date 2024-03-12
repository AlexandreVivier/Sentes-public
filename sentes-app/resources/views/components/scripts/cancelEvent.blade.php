<script>
    document.addEventListener('DOMContentLoaded', function() {
        let link = document.getElementById('cancel');
        let dialog = document.getElementById('cancelEvent');

        if(link !== null){
        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });}
    });
</script>
