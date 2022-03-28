$(document).ready(function () {
    const searchBar = document.querySelector(".search input"),
        searchIcon = document.querySelector(".search button"),
        usersList = document.querySelector(".users-list");

    searchIcon.onclick = () => {
        searchBar.classList.toggle("show");
        searchIcon.classList.toggle("active");
        searchBar.focus();
        if (searchBar.classList.contains("active")) {
            searchBar.value = "";
            searchBar.classList.remove("active");
        }
    }

    searchBar.onkeyup = () => {
        let searchTerm = searchBar.value;
        if (searchTerm != "") {
            searchBar.classList.add("active");
        } else {
            searchBar.classList.remove("active");
        }
        let xml = new XMLHttpRequest();
        xml.open("POST", "/e-diary/controllers/chatControllers/search.php", true);
        xml.onload = () => {
            if (xml.readyState === XMLHttpRequest.DONE) {
                if (xml.status === 200) {
                    let data = xml.response;
                    if (data != 0) {
                        usersList.innerHTML = data;
                        $('#usr-not-found-err').css('display', 'none');
                    }
                    if (data == 0) {
                        usersList.innerHTML = "";
                        $('#usr-not-found-err').css('display', 'flex');
                    }
                }
            }
        }
        xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xml.send("searchTerm=" + searchTerm);
    }

    // setInterval(() => {
    //     let xml = new XMLHttpRequest();
    //     xml.open("GET", "php/users.php", true);
    //     xml.onload = () => {
    //         if (xml.readyState === XMLHttpRequest.DONE) {
    //             if (xml.status === 200) {
    //                 let data = xml.response;
    //                 if (!searchBar.classList.contains("active")) {
    //                     usersList.innerHTML = data;
    //                 }
    //             }
    //         }
    //     }
    //     xml.send();
    // }, 500);

});