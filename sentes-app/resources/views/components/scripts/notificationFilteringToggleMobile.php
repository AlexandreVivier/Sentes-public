<script>
    document.addEventListener('DOMContentLoaded', function() {
        const showReadButtonMobile = document.getElementById('show-read-mobile');
        const showUnreadButtonMobile = document.getElementById('show-unread-mobile');
        const readNotifications = document.querySelectorAll('.read-notification');
        const unreadNotifications = document.querySelectorAll('.unread-notification');

        showReadButtonMobile.addEventListener('click', function() {
            readNotifications.forEach(notification => notification.style.display = 'block');
            unreadNotifications.forEach(notification => notification.style.display = 'none');
            showUnreadButtonMobile.classList.remove('notification-active-filter')
            showUnreadButtonMobile.classList.add('notification-disabled-filter');
            showReadButtonMobile.classList.remove('notification-disabled-filter');
            showReadButtonMobile.classList.add('notification-active-filter');
        });

        showUnreadButtonMobile.addEventListener('click', function() {
            readNotifications.forEach(notification => notification.style.display = 'none');
            unreadNotifications.forEach(notification => notification.style.display = 'block');
            showReadButtonMobile.classList.remove('notification-active-filter');
            showReadButtonMobile.classList.add('notification-disabled-filter');
            showUnreadButtonMobile.classList.remove('notification-disabled-filter');
            showUnreadButtonMobile.classList.add('notification-active-filter');
        });

        // show unread notifications by default
        showUnreadButtonMobile.click();
    });
</script>