<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Identifiants de Connexion – GsbParam</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/cssGeneral.css?v=4" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            overflow: hidden;
        }
        .login-card .card-header {
            padding: 1.2rem 1.5rem;
            border-bottom: none;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.03em;
        }
        .login-card.client .card-header { background: #2563eb; color: #fff; }
        .login-card.admin  .card-header { background: #1e293b; color: #fff; }

        .login-card .card-body { padding: 1.5rem; background: #fff; }

        .field-label {
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #6b7280;
            margin-bottom: 2px;
        }
        .field-value {
            font-family: 'Courier New', monospace;
            font-size: 1.05rem;
            font-weight: 600;
            color: #1a1a2e;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 0.45rem 0.9rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .badge-role {
            font-size: 0.72rem;
            padding: 0.35em 0.8em;
            border-radius: 50px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-client { background: #dbeafe; color: #1d4ed8; }
        .badge-admin  { background: #fef3c7; color: #92400e; }

        .page-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .page-title p { color: #6b7280; }

        .url-chip {
            display: inline-block;
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #15803d;
            border-radius: 50px;
            font-size: 0.8rem;
            padding: 0.2em 0.8em;
            font-weight: 600;
            text-decoration: none;
        }
        .url-chip:hover { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

<div style="max-width: 740px; width: 100%;">

    <div class="page-title">
        <h1>&#128274; Identifiants de Connexion</h1>
        <p>Site GsbParam – Environnement local (localhost)</p>
        <a href="http://localhost/gsbparam/index.php?uc=utilisateur&action=connexion" class="url-chip" target="_blank">
            &#8594; Ouvrir la page de connexion
        </a>
    </div>

    <div class="row g-4">

        <!-- ── CLIENT 1 ─────────────────────────────── -->
        <div class="col-md-6">
            <div class="login-card client card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>&#128100; Compte Client 1</span>
                    <span class="badge-role badge-client">Client</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="field-label">Email (login)</div>
                        <div class="field-value">test1@mail.com</div>
                    </div>
                    <div>
                        <div class="field-label">Mot de passe</div>
                        <div class="field-value">test45?</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── CLIENT 2 ─────────────────────────────── -->
        <div class="col-md-6">
            <div class="login-card client card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>&#128100; Compte Client 2</span>
                    <span class="badge-role badge-client">Client</span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="field-label">Email (login)</div>
                        <div class="field-value">dupont@login.com</div>
                    </div>
                    <div>
                        <div class="field-label">Mot de passe</div>
                        <div class="field-value">azerty45</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── ADMINISTRATEUR ────────────────────────── -->
        <div class="col-12">
            <div class="login-card admin card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>&#9881; Compte Administrateur</span>
                    <span class="badge-role badge-admin">&#9733; Admin</span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="field-label">Email (login)</div>
                            <div class="field-value">admin@gsb.fr</div>
                        </div>
                        <div class="col-md-6">
                            <div class="field-label">Mot de passe</div>
                            <div class="field-value">admin</div>
                        </div>
                    </div>
                    <div class="mt-3 p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <p class="mb-1 small text-muted fw-semibold">&#128737; Accès Back-Office Admin :</p>
                        <ul class="mb-0 small text-muted">
                            <li>Gestion des catégories (ajout, modification, suppression)</li>
                            <li>Gestion des produits (ajout, modification, stock)</li>
                            <li>Gestion des produits associés</li>
                            <li>Gestion des commandes (suivi, modification d'état)</li>
                            <li>Programmation des mises en avant (page d'accueil)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <p class="text-center text-muted small mt-4">
        &#128197; Document interne – GsbParam v3 – <?php echo date('d/m/Y'); ?>
    </p>

</div>

</body>
</html>
