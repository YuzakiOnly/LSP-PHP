<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Siswa
    </title>
    <link rel="stylesheet" href="/learn-lsp-1/public/css/form.css">
</head>

<body>
    <div class="container">
        <div class="main-content">
            <div class="form-section">
                <form action="index.php" method="POST" class="form-student">
                    <div class="form-header">
                        <h3>
                            <?= isset($editData) ? 'Edit' : 'Tambah' ?> Data Siswa
                            <?= isset($editData) ? '' : 'Baru' ?>
                        </h3>
                        <a href="index.php" class="btn btn-back">← Kembali</a>
                    </div>

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

                    <?php if (isset($editData)): ?>
                        <input type="hidden" name="old_nis" value="<?= htmlspecialchars($editData['nis']) ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nis">NIS <span class="required">*</span></label>
                        <input type="text" id="nis" name="nis"
                            value="<?= isset($editData) ? htmlspecialchars($editData['nis']) : (isset($_SESSION['old_input']['nis']) ? htmlspecialchars($_SESSION['old_input']['nis']) : '') ?>"
                            required placeholder="Masukkan NIS siswa">
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama" name="nama"
                            value="<?= isset($editData) ? htmlspecialchars($editData['nama']) : (isset($_SESSION['old_input']['nama']) ? htmlspecialchars($_SESSION['old_input']['nama']) : '') ?>"
                            required placeholder="Masukkan nama lengkap siswa">
                    </div>

                    <fieldset class="nilai-fieldset">
                        <legend>Nilai Mata Pelajaran</legend>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="mtk">Matematika <span class="required">*</span></label>
                                <input type="number" id="mtk" name="mtk"
                                    value="<?= isset($editData) ? htmlspecialchars($editData['mtk']) : (isset($_SESSION['old_input']['mtk']) ? htmlspecialchars($_SESSION['old_input']['mtk']) : '') ?>"
                                    min="0" max="100" required placeholder="0-100">
                            </div>

                            <div class="form-group">
                                <label for="bin">Bahasa Indonesia <span class="required">*</span></label>
                                <input type="number" id="bin" name="bin"
                                    value="<?= isset($editData) ? htmlspecialchars($editData['bin']) : (isset($_SESSION['old_input']['bin']) ? htmlspecialchars($_SESSION['old_input']['bin']) : '') ?>"
                                    min="0" max="100" required placeholder="0-100">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="big">Bahasa Inggris <span class="required">*</span></label>
                                <input type="number" id="big" name="big"
                                    value="<?= isset($editData) ? htmlspecialchars($editData['big']) : (isset($_SESSION['old_input']['big']) ? htmlspecialchars($_SESSION['old_input']['big']) : '') ?>"
                                    min="0" max="100" required placeholder="0-100">
                            </div>

                            <div class="form-group">
                                <label for="pro">Produktif <span class="required">*</span></label>
                                <input type="number" id="pro" name="pro"
                                    value="<?= isset($editData) ? htmlspecialchars($editData['pro']) : (isset($_SESSION['old_input']['pro']) ? htmlspecialchars($_SESSION['old_input']['pro']) : '') ?>"
                                    min="0" max="100" required placeholder="0-100">
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-actions">
                        <button type="submit" name="<?= isset($editData) ? 'update' : 'simpan' ?>"
                            class="btn btn-primary">
                            <?= isset($editData) ? 'Update' : 'Simpan' ?> Data
                        </button>
                        <?php if (!isset($editData)): ?>
                            <button type="reset" class="btn btn-secondary">
                                Reset Form
                            </button>
                        <?php endif; ?>
                        <a href="index.php" class="btn btn-outline">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<?php if (!isset($editData))
    unset($_SESSION['old_input']); ?>