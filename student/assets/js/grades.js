
let teacher = document.getElementById('grades-table').getElementsByTagName('a');
for (var i = 0; i < teacher.length; i++) {
    let teacherId = teacher.item(i).getAttribute('id');
    teacher.item(i).addEventListener('click', () => {
        sessionStorage.setItem('teacher-id', teacherId);
        location.href = "teachers.php";
    })
}

