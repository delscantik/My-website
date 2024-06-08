<?php include 'koneksi.php' ?>

<?php
if (isset($_POST['add_post'])) {
    $task_name = mysqli_real_escape_string($connection, $_POST['task_name']);
    $query = mysqli_query($connection, "INSERT INTO todo (task_name, task_status, task_date) VALUES ('$task_name','Pending',now())");
    header("Location: index.php");
}

if (isset($_GET['edit'])) {
    $task_id = $_GET['edit'];
    $query = mysqli_query($connection, "UPDATE todo SET task_status = 'Selesai' WHERE task_id = '$task_id'");
    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $query = mysqli_query($connection, "DELETE FROM todo WHERE task_id = '$task_id'");
    header("Location: index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todolist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">TODOLIST-APP</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-1">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h3>Form Tambah Tugas</h3>
                        <form method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <input type="text" class="form-control" name="task_name" id="task_name" placeholder="Input Nama Tugas">
                            </div>
                            <div class="form-group mt-2 d-grid">
                                <button type="submit" name="add_post" class="btn btn-primary">Tambah Tugas</button>
                            </div>
                        </form>
                        <h3>List Tugas Pending</h3>
                        <ul class="list-group">
                            <?php
                            $query = mysqli_query($connection, "SELECT * FROM todo WHERE task_status = 'Pending'");
                            while ($row = mysqli_fetch_array($query)) {
                                $task_name = $row['task_name'];
                                $task_id = $row['task_id'];


                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $task_name; ?>

                                    <div class="float-right">
                                        <a href="index.php?edit=<?php echo $task_id ?>" class="btn btn-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                            </svg>
                                        </a>
                                        <a href="index.php?delete=<?php echo $task_id ?>" class="btn btn-danger">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                            </svg>
                                        </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-1">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <h3>List Tugas Selesai</h3>
                        <ul class="list-group">
                            <?php
                            $query = mysqli_query($connection, "SELECT * FROM todo WHERE task_status = 'Selesai'");
                            while ($row = mysqli_fetch_array($query)) {
                                $task_name = $row['task_name'];
                                $task_status = $row['task_status'];


                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $task_name ?>

                                    <div class="float-right">
                                        <div class="badge text-bg-primary"><?php echo $task_status?></div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            // Ambil nilai dari input nama tugas
            var taskName = document.getElementById("task_name").value;

            // Periksa apakah nilai taskName kosong atau tidak
            if (taskName.trim() == "") {
                // Jika kosong, tampilkan pesan kesalahan
                alert("Nama tugas tidak boleh kosong");
                // Kembalikan false untuk mencegah pengiriman formulir
                return false;
            }
            // Kembalikan true untuk mengizinkan pengiriman formulir jika validasi berhasil
            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>


