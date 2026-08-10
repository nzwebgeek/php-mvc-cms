</main>


</div>



<footer class="admin-footer">

CMS Administration Panel

</footer>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const menuToggle = document.getElementById('adminMenuToggle');

    const sidebar = document.getElementById('adminSidebar');

    const overlay = document.getElementById('adminSidebarOverlay');


    if (!menuToggle || !sidebar || !overlay) {
        return;
    }


    function openMenu() {

        sidebar.classList.add('open');

        overlay.classList.add('active');

        menuToggle.classList.add('active');

        menuToggle.setAttribute(
            'aria-expanded',
            'true'
        );

        menuToggle.setAttribute(
            'aria-label',
            'Close navigation menu'
        );

    }


    function closeMenu() {

        sidebar.classList.remove('open');

        overlay.classList.remove('active');

        menuToggle.classList.remove('active');

        menuToggle.setAttribute(
            'aria-expanded',
            'false'
        );

        menuToggle.setAttribute(
            'aria-label',
            'Open navigation menu'
        );

    }


    menuToggle.addEventListener('click', function () {

        if (sidebar.classList.contains('open')) {

            closeMenu();

        } else {

            openMenu();

        }

    });


    overlay.addEventListener('click', function () {

        closeMenu();

    });


    /*
       Close the mobile menu after
       selecting a navigation link.
    */

    sidebar.querySelectorAll('a').forEach(function (link) {

        link.addEventListener('click', function () {

            closeMenu();

        });

    });


    /*
       Close menu when pressing Escape.
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {

            closeMenu();

        }

    });


    /*
       If the browser is resized back
       to desktop, reset the mobile menu.
    */

    window.addEventListener('resize', function () {

        if (window.innerWidth > 800) {

            closeMenu();

        }

    });

});

</script>
</body>
</html>