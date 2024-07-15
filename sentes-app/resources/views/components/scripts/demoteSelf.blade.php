<script>
    document.addEventListener('DOMContentLoaded', function() {

        let link = document.getElementById('demoteSelf');
        let dialog = document.getElementById('demoteSelfModal');

        if(link !== null){
        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });}
    });
</script>
