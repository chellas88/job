// $(document).ready(function () {
//     $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             }
//         }
//     );
//
//     const searchForm = document.getElementById('search-form')
//     searchForm.addEventListener('submit', event => {
//         event.preventDefault()
//         let location = document.getElementById('location').value
//         let coordinates = getCoordinates(location)
//         console.log(coordinates.latitude)
//         $.ajax({
//             url: '/search',
//             method: 'get',
//             data: {location: location},
//             dataType: 'json',
//             success: (res) => {
//                 console.log(res)
//
//             }
//         })
//     })
//
//
// })


