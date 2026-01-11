<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <h6 class="mb-0">Menu Utama</h6>
    </div>
    <div class="list-group list-group-flush">
        <!-- Dashboard -->
        <a href="<?= \Config\Config::BASE_URL ?>/barang" 
           class="list-group-item list-group-item-action">
            🏠 Dashboard
        </a>
        
        <!-- Data Barang -->
        <a href="<?= \Config\Config::BASE_URL ?>/barang/list" 
           class="list-group-item list-group-item-action">
            📦 Data Barang
        </a>
        
        <!-- Tambah Barang (Hanya Admin) -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <a href="<?= \Config\Config::BASE_URL ?>/barang/create" 
           class="list-group-item list-group-item-action">
            ➕ Tambah Barang
        </a>
        <?php endif; ?>

        <!-- Logout -->
        <a href="<?= \Config\Config::BASE_URL ?>/auth/logout" 
           class="list-group-item list-group-item-action text-danger">
            🚪 Logout
        </a>
    </div>
</div>

<!-- User Info Card -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="text-center mb-2">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                 style="width: 60px; height: 60px; font-size: 24px;">
                <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
            </div>
        </div>
        <small class="text-muted d-block text-center">
            Login sebagai:<br>
            <strong class="text-dark"><?= $_SESSION['username'] ?? 'Guest' ?></strong><br>
            <span class="badge bg-<?= $_SESSION['role']=='admin' ? 'danger' : 'info' ?> mt-1">
                <?= strtoupper($_SESSION['role'] ?? '-') ?>
            </span>
        </small>
    </div>
</div>