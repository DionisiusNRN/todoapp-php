<?php
$todos = []; // total array yang disiapkan untuk disimpan

//melakukan pengecekan apakah file todo.txt ditemukan
if (file_exists('todo.txt')) {
    $file = file_get_contents('todo.txt'); // membaca file todo.txt
    $todos = unserialize($file); // menguibah format serialize menjadi array
}

// jika ditemukan todo yang dikirim melalui methode POST
if (isset($_POST['todo'])) {
    $data = $_POST['todo']; // data yang dipilih pada form
    $todos[] = [
        'todo'  => $data,
        'status'=> 0
    ];
    $daftar_belanja = serialize($todos); // simpan daftar belanja dalam format serialized

    simpanData($daftar_belanja);
}

// jika ditemukan $_GET['status']
if (isset($_GET['status'])) {
    $todos[$_GET['key']]['status']=$_GET['status']; // ubah status
    $daftar_belanja = serialize($todos); // simpan daftar belanja dalam format serialized

    simpanData($daftar_belanja);
}

// jika ditemukan perintah hapus
if (isset($_GET['hapus'])) {
    unset($todos[$_GET['key']]);
    $daftar_belanja = serialize($todos); // simpan daftar belanja dalam format serialized

    simpanData($daftar_belanja);
}

function simpanData($daftar_belanja) {
    file_put_contents('todo.txt', $daftar_belanja);
    header('location:index.php'); // redirect halaman
}

print_r($todos);
?>

<h1>Todo App</h1>
<form action="" method="POST">
    <label>Daftar Belanja Hari ini</label><br>
    <input type="text" name="todo">
    <button type="submit">Simpan</button>
</form>
<ul>
    <!-- mengambil dan menampilkan data array $todos satu persatu -->
    <?php foreach($todos as $key=>$value): ?> 
    <li>
        <input type="checkbox" name="todo" onclick="window.location.href='index.php?status=<?php echo($value['status'] == 1) ? '0' : '1';?>&key=<?php echo $key;?>'"
        <?php if($value['status'] == 1) echo 'checked'?>>
        <!-- menampilkan nilainya -->
        <label>
            <?php 
                if ($value['status'] == 1) {
                    echo '<del>'.$value['todo'].'</del>'; // memberikan effect dicoret
                } else {
                    echo $value['todo'];
                }
            ?>
        </label>
        <a href="index.php?hapus=1&key=<?php echo $key;?>" onclick="return confirm('Apakah anda yakin akna menghapus data ini?')">hapus</a>
    </li>
    <?php endforeach;?>
</ul>