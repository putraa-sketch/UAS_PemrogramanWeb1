<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - UAS Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card p-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4">🔐 Login System</h3>
                        
                        <?php if(isset($_GET['error'])): ?>
                            <?php if($_GET['error'] == 'invalid'): ?>
                                <div class="alert alert-danger" role="alert">
                                    ❌ Username atau Password salah!
                                </div>
                            <?php elseif($_GET['error'] == 'empty'): ?>
                                <div class="alert alert-warning" role="alert">
                                    ⚠️ Username dan Password tidak boleh kosong!
                                </div>
                            <?php else: ?>
                                <div class="alert alert-danger" role="alert">
                                    ❌ Login gagal! Silakan coba lagi.
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <form action="<?= \Config\Config::BASE_URL ?>/auth/login" method="POST" autocomplete="off">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" 
                                       name="username" 
                                       id="username"
                                       class="form-control" 
                                       placeholder="Masukkan username"
                                       required 
                                       autofocus>
                            </div>
                            
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control" 
                                       placeholder="Masukkan password"
                                       required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                Masuk
                            </button>
                        </form>

                        <hr class="my-4">
                        
                        <div class="text-center">
                            <small class="text-muted">
                                <strong>Demo Account:</strong><br>
                                Admin: admin / password<br>
                                User: user / password
                            </small>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-white">
                        © 2026 UAS Pemrograman Web - Universitas Pelita Bangsa
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>