<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Nilai Siswa</title>
    <link rel="stylesheet" href="/learn-lsp-1/public/css/style.css">
</head>

<body>
    <div class="container">

        <div class="main-content">
            <div class="form-section">
                <form action="index.php" method="POST" class="form-student">
                    <h3>
                        <?= isset($editData) ? ' Edit Data Siswa' : ' Input Data Siswa' ?>
                    </h3>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error">
                            <?= $_SESSION['error'] ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'] ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" name="nis" value="<?= isset($editData) ? $editData['nis'] : '' ?>"
                            required placeholder="Masukkan NIS">
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama"
                            value="<?= isset($editData) ? $editData['nama'] : '' ?>" required
                            placeholder="Masukkan nama lengkap">
                    </div>

                    <fieldset class="nilai-fieldset">
                        <legend>Nilai Mata Pelajaran</legend>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="mtk">Matematika</label>
                                <input type="number" id="mtk" name="mtk"
                                    value="<?= isset($editData) ? $editData['mtk'] : '' ?>" min="0" max="100" required
                                    placeholder="0-100">
                            </div>

                            <div class="form-group">
                                <label for="bin">Bahasa Indonesia</label>
                                <input type="number" id="bin" name="bin"
                                    value="<?= isset($editData) ? $editData['bin'] : '' ?>" min="0" max="100" required
                                    placeholder="0-100">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="big">Bahasa Inggris</label>
                                <input type="number" id="big" name="big"
                                    value="<?= isset($editData) ? $editData['big'] : '' ?>" min="0" max="100" required
                                    placeholder="0-100">
                            </div>

                            <div class="form-group">
                                <label for="pro">Produktif</label>
                                <input type="number" id="pro" name="pro"
                                    value="<?= isset($editData) ? $editData['pro'] : '' ?>" min="0" max="100" required
                                    placeholder="0-100">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-actions">
                        <?php if (isset($editData)) { ?>
                            <input type="hidden" name="old_nis" value="<?= $editData['nis'] ?>">
                            <button type="submit" name="update" class="btn btn-primary">
                                Update Data
                            </button>
                            <a href="index.php" class="btn btn-secondary">
                                Batal
                            </a>
                        <?php } else { ?>
                            <button type="submit" name="simpan" class="btn btn-primary">
                                Simpan Data
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                Reset Form
                            </button>
                        <?php } ?>
                    </div>
                </form>
            </div>
            <div class="table-section">
                <h3> Data Nilai Siswa</h3>

                <div class="search-sort-group">
                    <div class="search-section">
                        <form action="index.php" method="GET" class="form-search">
                            <div class="form-group-search">
                                <input type="text" name="search" placeholder="Cari berdasarkan NIS..."
                                    value="<?= isset($searchKeyword) ? htmlspecialchars($searchKeyword) : '' ?>"
                                    class="search-input">
                                <button type="submit" class="btn btn-search">Cari</button>
                                <?php if (isset($searchKeyword)): ?>
                                    <a href="index.php" class="btn-secondary a-search">Reset</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- <div class="sort-section">

                    </div> -->
                </div>

                <?php if (empty($student)): ?>
                    <div class="empty-state">
                        <p> Belum ada data student. Silakan tambahkan data baru.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="table-student">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>MTK</th>
                                    <th>B.INDONESIA</th>
                                    <th>B.INGGRIS</th>
                                    <th>PRODUTIF</th>
                                    <th>Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($student as $index => $data):
                                    $rerata = \Models\Student::calculateAverage($data);
                                    $status = $rerata >= 70 ? 'good' : ($rerata >= 50 ? 'medium' : 'low');
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="action-cell">
                                            <a href="index.php?edit=<?= urlencode($data['nis']) ?>" class="btn-action btn-edit"
                                                title="Edit">
                                                Edit
                                            </a>
                                            <a href="index.php?hapus=<?= urlencode($data['nis']) ?>"
                                                class="btn-action btn-delete" title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= htmlspecialchars($data['nama']) ?>?')">
                                                Hapus
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($data['nis']) ?></td>
                                        <td class="nama-cell"><?= htmlspecialchars($data['nama']) ?></td>
                                        <td><?= $data['mtk'] ?></td>
                                        <td><?= $data['bin'] ?></td>
                                        <td><?= $data['big'] ?></td>
                                        <td><?= $data['pro'] ?></td>
                                        <td class="rerata-cell <?= $status ?>">
                                            <?= number_format($rerata, 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="average-row">
                                    <td colspan="4"><strong>Rata-rata</strong></td>
                                    <td><strong><?= $averages['mtk'] ?></strong></td>
                                    <td><strong><?= $averages['bin'] ?></strong></td>
                                    <td><strong><?= $averages['big'] ?></strong></td>
                                    <td><strong><?= $averages['pro'] ?></strong></td>
                                    <td class="rerata-rata-cell"><strong><?= $averages['rerata'] ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>