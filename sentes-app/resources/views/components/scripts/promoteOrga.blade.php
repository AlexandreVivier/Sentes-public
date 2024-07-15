<script>
    document.addEventListener('DOMContentLoaded', function() {

        let link = document.getElementById('promoteOrga');
        let dialog = document.getElementById('promoteOrgaModal');

        if(link !== null){
        link.addEventListener('click', function(event) {
            event.preventDefault();
            dialog.showModal();
        });}
    });
</script>
