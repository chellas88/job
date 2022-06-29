const showMenuBtn = document.getElementById('menu')
const sidebar = document.getElementsByClassName('sidebar')[0]

showMenuBtn.addEventListener('click', () =>{
    sidebar.classList.toggle('active')
})


