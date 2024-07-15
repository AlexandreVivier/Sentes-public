<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showReadButton = document.getElementById('show-read');
        const showUnreadButton = document.getElementById('show-unread');
        const readNotifications = document.querySelectorAll('.read-notification');
        const unreadNotifications = document.querySelectorAll('.unread-notification');

        showReadButton.addEventListener('click', function() {
            readNotifications.forEach(notification => notification.style.display = 'block');
            unreadNotifications.forEach(notification => notification.style.display = 'none');
            showUnreadButton.classList.remove('notification-active-filter')
            showUnreadButton.classList.add('notification-disabled-filter');
            showReadButton.classList.remove('notification-disabled-filter');
            showReadButton.classList.add('notification-active-filter');
        });

        showUnreadButton.addEventListener('click', function() {
            readNotifications.forEach(notification => notification.style.display = 'none');
            unreadNotifications.forEach(notification => notification.style.display = 'block');
            showReadButton.classList.remove('notification-active-filter');
            showReadButton.classList.add('notification-disabled-filter');
            showUnreadButton.classList.remove('notification-disabled-filter');
            showUnreadButton.classList.add('notification-active-filter');
        });

        // show unread notifications by default
        showUnreadButton.click();

    });
</script>
