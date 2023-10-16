<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
    $student_id = $_GET['id'];

    // Fetch data from the student table
    $student_query = $conn->query("SELECT * FROM student WHERE id = $student_id");
    $student = $student_query->fetch_assoc();

    // Fetch data from the student_ef_list_list table
    $student_ef_list_query = $conn->query("SELECT * FROM student_ef_list WHERE student_id = $student_id");
    $student_ef_list = $student_ef_list_query->fetch_assoc();
}
?>
<div class="container-fluid">
    <form action="" id="manage-student">
        <input type="hidden" name="id" value="<?php echo isset($student['id']) ? $student['id'] : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">Id No.</label>
            <input type="text" class="form-control" name="id_no" value="<?php echo isset($student['id_no']) ? $student['id_no'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Name</label>
            <input type="text" class="form-control" name="name" value="<?php echo isset($student['name']) ? $student['name'] : '' ?>" required>
        </div> 
        <div class="form-group">
            <label for="" class="control-label">Parent/Guardian Name</label>
            <input type="text" class="form-control" name="email" value="<?php echo isset($student['email']) ? $student['email'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Parent/Guardian Contact Details</label>
            <input type="text" class="form-control" name="contact" value="<?php echo isset($student['contact']) ? $student['contact'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Address</label>
            <textarea name="address" id="" cols="30" rows="3" class="form-control" required><?php echo isset($student['address']) ? $student['address'] : '' ?></textarea>
        </div>
        <div class="form-group">
    <label for="" class="control-label">Class</label>
    <select name="classs_id" id="classs_id" class="custom-select input-sm select2">
        <option value=""></option>
        <?php
            $forms = $conn->query("SELECT *, CONCAT(form, ' - ', class) AS class FROM form ORDER BY form ASC");
            while ($row = $forms->fetch_assoc()):
        ?>
        <option value="<?php echo $row['id'] ?>" data-amount="<?php echo $row['id'] ?>" <?php echo isset($classs_id) && $classs_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
        <?php endwhile; ?>
    </select>
</div>
    </form>
</div>
<script>
    $('#manage-student').on('reset', function () {
        $('#msg').html('');
        $('input:hidden').val('');
    });

    $('#manage-student').submit(function (e) {
        e.preventDefault();
        start_load();
        $('#msg').html('');
        $.ajax({
            url: 'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved.", 'success')
                    setTimeout(function () {
                        location.reload();
                    }, 1000)
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger mx-2">ID # already exist.</div>');
                    end_load();
                }
            }
        });
    });

    $('.select2').select2({
        placeholder: "Please Select here",
        width: '100%'
    });
</script>