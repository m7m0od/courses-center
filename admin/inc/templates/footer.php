        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        <script>
            //MenuToggle >>one<<
            let toggle = document.querySelector('.toggle');
            let navigation = document.querySelector('.navigation');
            let main = document.querySelector('.main');
            toggle.onclick = function(){
                navigation.classList.toggle('active');
                main.classList.toggle('active');
            }

            //add hovered class in selected li >>two<<
            let list = document.querySelectorAll('.navigation li');
            function activLink(){
                list.forEach((item)=>
                item.classList.remove('hovered'));
                this.classList.add('hovered');
            }
            list.forEach((item)=>
            item.addEventListener('mouseover',activLink));

        </script>
        <script src="layout/js/jquery-3.6.0.min.js"></script>
        <script src="layout/js/jquery-ui.min.js"></script>
        <script src="layout/js/bootstrap.min.js"></script>
        <script src="layout/js/jquery.selectBoxIt.min.js"></script>
        <script src="layout/js/index.js"></script>
    </body>
</html>