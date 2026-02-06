<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai Siswa</title>
    <link rel="stylesheet" href="/learn-lsp-1/public/css/table.css">
</head>

<body>
    <div class="container">
        <div class="main-content">
            <div>
                <div class="header-with-button">
                    <h3> Data Nilai Siswa</h3>
                    <a href="index.php?action=create" class="btn btn-primary">
                        Tambah Data Siswa
                    </a>
                </div>

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

                    <div class="sort-section">
                        <?php
                        $currentSort = $_GET['sort'] ?? 'nis';
                        $currentOrder = $_GET['order'] ?? 'asc';
                        $searchParam = isset($searchKeyword) ? '&search=' . urlencode($searchKeyword) : '';
                        ?>
                        <form action="index.php" method="GET" class="form-sort">
                            <?php if (isset($searchKeyword)): ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($searchKeyword) ?>">
                            <?php endif; ?>

                            <label for="sort">Urutkan:</label>
                            <select name="sort" id="sort" class="sort-select">
                                <option value="nis" <?= $currentSort == 'nis' ? 'selected' : '' ?>>NIS</option>
                                <option value="mtk" <?= $currentSort == 'mtk' ? 'selected' : '' ?>>Matematika</option>
                                <option value="bin" <?= $currentSort == 'bin' ? 'selected' : '' ?>>B. Indonesia</option>
                                <option value="big" <?= $currentSort == 'big' ? 'selected' : '' ?>>B. Inggris</option>
                                <option value="pro" <?= $currentSort == 'pro' ? 'selected' : '' ?>>Produktif</option>
                                <option value="rerata" <?= $currentSort == 'rerata' ? 'selected' : '' ?>>Rata-rata</option>
                            </select>

                            <select name="order" id="order" class="sort-select">
                                <option value="asc" <?= $currentOrder == 'asc' ? 'selected' : '' ?>>Terkecil</option>
                                <option value="desc" <?= $currentOrder == 'desc' ? 'selected' : '' ?>>Terbesar</option>
                            </select>

                            <button type="submit" class="btn btn-sort">Terapkan</button>
                        </form>
                    </div>
                </div>

                <?php if (empty($student)): ?>
                    <div class="empty-state">
                        <p>Belum ada data siswa. Silakan tambahkan data baru.</p>
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
                                    <th>PRODUKTIF</th>
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
                                            <a href="index.php?action=edit&nis=<?= urlencode($data['nis']) ?><?= $searchParam ?>&sort=<?= $currentSort ?>&order=<?= $currentOrder ?>"
                                                class="btn-action btn-edit" title="Edit">
                                                Edit
                                            </a>
                                            <a href="index.php?action=delete&nis=<?= urlencode($data['nis']) ?>"
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
                                    <td class="rata-average-1" colspan="4"><strong>Rata-rata Keseluruhan</strong></td>
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