const showHideSearch = document.getElementById('showHideSearch')
const searchForm = document.getElementsByClassName('search')[0]
const searchFormWidth = searchForm.clientWidth
showHideSearch.addEventListener('click', ()=>{
    let add = searchForm.classList.toggle('active')
    if (!add) {
        showHideSearch.innerHTML = "<i class='bx bx-chevron-right'></i>"
        searchForm.style.left = '-' + searchFormWidth
    }
    else {
        showHideSearch.innerHTML = "<i class='bx bx-chevron-left' ></i>"
        searchForm.style.left = '0'
    }

})
