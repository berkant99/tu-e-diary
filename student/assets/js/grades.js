$('#slct-smstr').on('change', function () {
    $.ajax({
        method: "POST",
        data: { smstrID: this.value },
        url: "serverControllers/gradesController.php",
        success: function (data) {    // success callback function
            if (data != "no-grades") {
                $('#filter-smstr').html(data);
                $('#grades-table').css("display", "inline-table");
                $('#no-grades').css("display", "none");
                sendTchrId();
            } else {
                $('#grades-table').css("display", "none");
                $('#no-grades').css("display", "flex");
                $('#no-grades').html("Все още нямате въведени оценки");
            }
        }
    });
});

sendTchrId();

function sendTchrId() {
    let teacher = document.getElementById('grades-table').getElementsByTagName('a');
    for (var i = 0; i < teacher.length; i++) {
        let teacherId = teacher.item(i).getAttribute('id');
        teacher.item(i).addEventListener('click', () => {
            sessionStorage.setItem('teacher-id', teacherId);
            location.href = "teachers";
        })
    }
}



