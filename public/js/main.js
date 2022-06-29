$('.locale').on('click', function () {
    let lang = $(this).attr('value');
    let redirectTo = document.location.pathname.substring(3);
    document.location.href = '/' + lang + redirectTo;
});

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

//add lang
const addLangBtn = document.getElementsByClassName('add_lang')
Array.from(addLangBtn).forEach(btn => {
    btn.addEventListener('click', () => {
        let lang_id = btn.getAttribute('lang')
        let lang_name = btn.getAttribute('lang_name')
        let parent = document.getElementById('newlang_' + lang_id)
        $.ajax({
            type: 'post',
            url: '/languser',
            data: {'id' : lang_id},
            success: function (response){
                let span = document.createElement('span')
                span.setAttribute('id', 'lang_' + lang_id)
                span.innerHTML = `${lang_name}<i class="remove_lang" lang="${lang_id}" lang_name="${lang_name}">X</i>`
                document.getElementById('lang-list').appendChild(span)
                parent.remove()
            }
        })
    })
})


//remove lang
const removeLangBtn = document.getElementsByClassName('remove_lang')
Array.from(removeLangBtn).forEach(btn => {
    btn.addEventListener('click', () => {

        let lang_id = btn.getAttribute('lang')
        let lang_name = btn.getAttribute('lang_name')
        let parent = document.getElementById('lang_' + lang_id)
        $.ajax({
            type: 'delete',
            url: '/languser/' + lang_id,
            success: function (response){
                let li = document.createElement('li')
                li.setAttribute('id', 'newlang_' + lang_id)
                li.innerHTML = `<a lang="${lang_id}" lang_name="${lang_name}" class="dropdown-item add_lang" href="#">${lang_name}</a>`
                document.getElementById('lang-menu').appendChild(li)


                parent.remove()
            }
        })
    })
})
