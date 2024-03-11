<script>
    document.addEventListener('DOMContentLoaded', function() {
        let link = document.getElementById('unsubscribe');
        let dialog = document.getElementById('unsubscribeUser');

        if(link !== null){
        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });}
    });
</script>
