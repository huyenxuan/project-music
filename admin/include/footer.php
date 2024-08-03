</main>
<script>
    let sidebarSub = document.querySelectorAll('.sidebar-sub');
    sidebarSub.forEach(item => {
        item.addEventListener('click', () => {
            const subMenu = item.querySelector('ul');
            const dropdownIcon = item.querySelector('.dropdown');
            if (subMenu) {
                subMenu.classList.toggle('show');
                dropdownIcon.classList.toggle('rotate');
            }
        });
    });
</script>
</body>

</html>