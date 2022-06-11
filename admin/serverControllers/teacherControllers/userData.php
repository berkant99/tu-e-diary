<?php
while ($row = $query->fetch_assoc()) {
    $output .= '<a id=' . $row['teacher_id'] . '>
<div class="content">
<img src="/e-diary/profile-pictures/'.$row['img'].'" id="tchr-img" alt="profile-pic">
    <div class="details">
        <span>' . $row['teacher'] . '</span>
        <p>' . $row['email'] . '</p>
    </div>
</div>
<div class="department">' . $row['dep'] . '</div>
</a>';
}
