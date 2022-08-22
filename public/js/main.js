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
            showCategories()
        } else {
            showHideSearch.innerHTML = "<i class='icon-chevron-left' ></i>"
            searchForm.style.left = '0'
        }

    })
}

function changeLang(){
    window.localStorage.setItem('lang', document.getElementById('lang').value)
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


//Show category on search form
function showCategories(){
    hideSubcategory()
    let categoryList = document.querySelector('.category-list')
    categoryList.classList.toggle('show')
}

function selectCategory(id, elem) {
    hideSubcategory()
    let categoryInput = document.getElementById('category_id')
    document.getElementById('subcategory_id').value = ''
    categoryInput.value = id
    if (id !== ''){
        let subcategoryList = document.getElementById('subcategories_' + id)
        subcategoryList.classList.toggle('show')
    }
    else showCategories()
    document.getElementById('show-categories').innerHTML = elem.getAttribute('category')
}

function selectSubcategory(id, elem = null) {
    let subcategoryInput = document.getElementById('subcategory_id')
    subcategoryInput.value = id
    let text = elem.getAttribute('subcategory')
    if (text === null){
        document.getElementById('show-categories').innerHTML = elem.getAttribute('category')
    }
    else document.getElementById('show-categories').innerHTML = text
    showCategories()
}

function hideSubcategory(){
    let blocks = $('.subcategory-list')
    Array.prototype.forEach.call(blocks, function(block){
        block.classList.remove('show')
    })
}

//location click

var location_input = document.getElementById("location");
function checkPosition(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        // x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    console.log(position)
    $.ajax({
        method: 'post',
        url: '/en/getLocation',
        data: {lng: position.coords.longitude, lat: position.coords.latitude},
        success: function (response) {
            location_input.value = response
        }
    })
}
