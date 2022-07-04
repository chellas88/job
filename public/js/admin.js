const showMenuBtn = document.getElementById('menu')
const sidebar = document.getElementsByClassName('sidebar')[0]

showMenuBtn.addEventListener('click', () =>{
    sidebar.classList.toggle('active')
})


function recommended(id){
    let check;
    if (document.getElementById('recommended_' + id).checked){
        check = 1
    }
    else check = 0
    $.ajax({
        type: 'PUT',
        url: '/en/admin/user/' + id,
        data: {'recommended' : check},
        success: function (res){
            console.log(res)
        }
    })

}
