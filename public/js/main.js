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
function addLang(id, lang) {
    let parent = document.getElementById('newlang_' + id)
    $.ajax({
        type: 'post',
        url: '/en/languser',
        data: {'id': id},
        success: function (response) {
            let span = document.createElement('span')
            span.setAttribute('id', 'lang_' + id)
            span.innerHTML = `${response['title_' + lang]}<i onclick="removeLang(${id}, '${lang}')" class="remove_lang">X</i>`
            document.getElementById('lang-list').appendChild(span)
            parent.remove()
        },
        error: function (error) {
            console.log(error)
        }
    })
}

function removeLang(id, lang) {
    let parent = document.getElementById('lang_' + id)
    $.ajax({
        type: 'delete',
        url: '/en/languser/' + id,
        success: function (response) {
            let li = document.createElement('li')
            li.setAttribute('id', 'newlang_' + id)
            li.innerHTML = `<a  onclick="addLang(${id}, '${lang}')" class="dropdown-item add_lang" href="#">${response['title_' + lang]}</a>`
            document.getElementById('lang-menu').appendChild(li)
            parent.remove()
        }
    })
}

function addService(id, lang) {
    event.preventDefault()
    let parent = document.getElementById('newservice_' + id)
    $.ajax({
        type: 'post',
        url: '/en/service',
        data: {'id': id},
        success: function (res) {
            let span = document.createElement('span')
            span.setAttribute('id', 'serv_' + id)
            span.innerHTML = `${res['title_' + lang]}<i onclick="removeService(${id}, '${lang}')">X</i>`
            document.getElementById('service-list').appendChild(span)
            parent.remove()
        }
    })
}

function removeService(id, lang) {
    event.preventDefault()
    let parent = document.getElementById('serv_' + id)
    $.ajax({
        type: 'delete',
        url: '/en/service/' + id,
        success: function (response) {
            let li = document.createElement('li')
            li.setAttribute('id', 'newservice_' + id)
            li.innerHTML = `<a  onclick="addService(${id}, '${lang}')" class="dropdown-item" href="#">${response['title_' + lang]}</a>`
            document.getElementById('service-menu').appendChild(li)
            parent.remove()
        }
    })
}


