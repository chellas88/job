const showHideSearch = document.getElementById('showHideSearch')
const searchForm = document.getElementsByClassName('search')[0]
if (showHideSearch) {
    showHideSearch.addEventListener('click', () => {
        const searchFormWidth = searchForm.clientWidth
        let add = searchForm.classList.toggle('active')
        if (!add) {
            showHideSearch.innerHTML = "<i class='icon-chevron-right'></i>"
            searchForm.style.left = '-' + searchFormWidth
        } else {
            showHideSearch.innerHTML = "<i class='icon-chevron-left' ></i>"
            searchForm.style.left = '0'
        }

    })
}
