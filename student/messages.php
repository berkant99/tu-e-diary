<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
} else if ($_SESSION['firstLogin'] == FALSE) {
    header('location: first-signin.php');
    exit();
} else if (!isset($_SESSION['verified'])) {
    header('location: email-verification.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/layout/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/topMenu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/sideMenu.php';
?>
<div class="main msg-cntr">
    <div class="box">
        <div class="card">
            <div class="hr-group">
                <div class="user-box">
                    <div class="search">
                        <span class="text">Открийте нови хора...</span>
                        <input type="text" placeholder="Въведете име...">
                        <button><i class="fa-solid fa-search"></i></button>
                    </div>
                    <div class="alert alert-error" id="usr-not-found-err">
                        <div class="icon">
                            <i class="fa fa-frown-o" style="border: none; font-size: 28px;" aria-hidden="true"></i>
                        </div>
                        <div class="text" style="text-align: center;">
                            Няма резултати от търсенето...
                        </div>
                    </div>
                    <div class="users-list" id="users-list">
                        <!-- Users will be listed here -->
                    </div>
                </div>
                <div class="msg-box">
                    <!-- Chat box will be displayed here -->
                    <div class="vr-group" id ="start-conversation">
                        <i class="fa-solid fa-comments"></i>
                        <div class="text">
                            Започнете нов разговор...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // const form = document.querySelector(".typing-area"),
    //     incoming_id = form.querySelector(".incoming_id").value,
    //     inputField = form.querySelector(".input-field"),
    //     sendBtn = form.querySelector("button"),
    //     chatBox = document.querySelector(".chat-box");

    // form.onsubmit = (e) => {
    //     e.preventDefault();
    // }

    // inputField.focus();


    // inputField.onkeyup = () => {
    //     if (inputField.value != "") {
    //         sendBtn.classList.add("active");
    //         console.log(inputField.value);
    //     } else {
    //         sendBtn.classList.remove("active");
    //     }
    // }

    // // sendBtn.onclick = ()=>{
    // //     let xhr = new XMLHttpRequest();
    // //     xhr.open("POST", "php/insert-chat.php", true);
    // //     xhr.onload = ()=>{
    // //       if(xhr.readyState === XMLHttpRequest.DONE){
    // //           if(xhr.status === 200){
    // //               inputField.value = "";
    // //               scrollToBottom();
    // //           }
    // //       }
    // //     }
    // //     let formData = new FormData(form);
    // //     xhr.send(formData);
    // // }
    // chatBox.onmouseenter = () => {
    //     chatBox.classList.add("active");
    // }

    // chatBox.onmouseleave = () => {
    //     chatBox.classList.remove("active");
    // }

    // // setInterval(() =>{
    // //     let xhr = new XMLHttpRequest();
    // //     xhr.open("POST", "php/get-chat.php", true);
    // //     xhr.onload = ()=>{
    // //       if(xhr.readyState === XMLHttpRequest.DONE){
    // //           if(xhr.status === 200){
    // //             let data = xhr.response;
    // //             chatBox.innerHTML = data;
    // //             if(!chatBox.classList.contains("active")){
    // //                 scrollToBottom();
    // //               }
    // //           }
    // //       }
    // //     }
    // //     xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // //     xhr.send("incoming_id="+incoming_id);
    // // }, 500);

    // function scrollToBottom() {
    //     chatBox.scrollTop = chatBox.scrollHeight;
    // }
</script>
<script src="assets/js/chat.js?v=<?php echo time(); ?>" type="text/javascript"></script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/e-diary/student/layout/footer.php'; ?>