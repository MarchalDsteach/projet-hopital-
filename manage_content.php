<?php
require_once 'config.php';
secure_session_start();

// Vérifier que c'est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    safe_redirect('login.php');
}

$conn = get_db_connection();
$error = null;
$success = null;

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update') {
        $id = intval($_POST['id']);
        $titre = trim($_POST['titre'] ?? '');
        $contenu = $_POST['contenu'] ?? '';
        $ordre = intval($_POST['ordre']);
        $actif = isset($_POST['actif']) ? 1 : 0;
        
        if (!$titre || !$contenu) {
            $error = 'Tous les champs sont requis.';
        } else {
            $stmt = $conn->prepare('UPDATE pages SET titre = ?, contenu = ?, ordre = ?, actif = ? WHERE id = ?');
            $stmt->bind_param('ssiii', $titre, $contenu, $ordre, $actif, $id);
            if ($stmt->execute()) {
                $success = 'Page mise à jour avec succès!';
            } else {
                $error = 'Erreur lors de la mise à jour.';
            }
            $stmt->close();
        }
    } elseif ($action === 'add') {
        $titre = trim($_POST['titre'] ?? '');
        $contenu = $_POST['contenu'] ?? '';
        $ordre = intval($_POST['ordre']);
        
        if (!$titre || !$contenu) {
            $error = 'Tous les champs sont requis.';
        } else {
            $stmt = $conn->prepare('INSERT INTO pages (titre, contenu, ordre, actif) VALUES (?, ?, ?, 1)');
            $stmt->bind_param('ssi', $titre, $contenu, $ordre);
            if ($stmt->execute()) {
                $success = 'Page ajoutée avec succès!';
            } else {
                $error = 'Cette page existe déjà.';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare('DELETE FROM pages WHERE id = ?');
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $success = 'Page supprimée avec succès!';
        } else {
            $error = 'Erreur lors de la suppression.';
        }
        $stmt->close();
    }
}

// Récupérer toutes les pages
$pages = [];
$result = $conn->query('SELECT * FROM pages ORDER BY ordre ASC');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pages[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du contenu - Hôpital Medicare</title>
    <link rel="stylesheet" href="global.css">
    <style>
        body { background: #f5f5f5; font-family: Arial, sans-serif; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .page-list { background: white; border-radius: 8px; padding: 20px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .page-item { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .page-info h3 { margin: 0 0 5px 0; color: #333; }
        .page-info p { margin: 5px 0; color: #666; font-size: 0.9em; }
        .btn { padding: 8px 15px; margin: 0 5px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.9em; }
        .btn-edit { background: #007bff; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-add { background: #28a745; color: white; padding: 10px 20px; font-size: 1em; }
        .form-section { background: white; border-radius: 8px; padding: 20px; margin: 20px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: Arial; }
        .form-group textarea { min-height: 150px; resize: vertical; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: white; margin: auto; padding: 30px; border-radius: 8px; width: 90%; max-width: 600px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        .close { float: right; font-size: 28px; font-weight: bold; cursor: pointer; color: #666; }
        .close:hover { color: #000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏥 Gestion du contenu - Hôpital Medicare</h1>
        
        <?php if ($success) echo "<p class='success'>✅ $success</p>"; ?>
        <?php if ($error) echo "<p class='error'>❌ $error</p>"; ?>
        
        <button class="btn btn-add" onclick="openAddModal()">+ Ajouter une page</button>
        
        <!-- Modal Ajouter -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addModal')">&times;</span>
                <h2>Ajouter une nouvelle page</h2>
                <form method="post">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="titre_add">Titre</label>
                        <input type="text" id="titre_add" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="ordre_add">Ordre d'affichage</label>
                        <input type="number" id="ordre_add" name="ordre" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="contenu_add">Contenu</label>
                        <textarea id="contenu_add" name="contenu" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-add">Ajouter</button>
                </form>
            </div>
        </div>
        
        <!-- Liste des pages -->
        <div class="page-list">
            <h2>Pages existantes</h2>
            <?php if (empty($pages)): ?>
                <p>Aucune page trouvée.</p>
            <?php else: ?>
                <?php foreach ($pages as $page): ?>
                    <div class="page-item">
                        <div class="page-info">
                            <h3><?php echo html_escape($page['titre']); ?></h3>
                            <p>
                                <?php echo substr(html_escape($page['contenu']), 0, 100); ?>...
                            </p>
                            <p style="font-size: 0.8em; color: #999;">
                                Ordre: <?php echo $page['ordre']; ?> | 
                                Statut: <?php echo $page['actif'] ? '✅ Actif' : '❌ Inactif'; ?>
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-edit" onclick="openEditModal(<?php echo $page['id']; ?>)">Modifier</button>
                            <button class="btn btn-delete" onclick="confirmDelete(<?php echo $page['id']; ?>)">Supprimer</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Modal Modifier -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('editModal')">&times;</span>
                <h2>Modifier la page</h2>
                <form method="post" id="editForm">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label for="titre_edit">Titre</label>
                        <input type="text" id="titre_edit" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="ordre_edit">Ordre d'affichage</label>
                        <input type="number" id="ordre_edit" name="ordre" required>
                    </div>
                    <div class="form-group">
                        <label for="contenu_edit">Contenu</label>
                        <textarea id="contenu_edit" name="contenu" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="actif_edit" name="actif">
                            Page active
                        </label>
                    </div>
                    <button type="submit" class="btn btn-edit">Mettre à jour</button>
                </form>
            </div>
        </div>
        
        <!-- Modal Supprimer -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h2>Êtes-vous sûr?</h2>
                <p>Voulez-vous vraiment supprimer cette page? Cette action est irréversible.</p>
                <form method="post" id="deleteForm" style="text-align: right;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_id">
                    <button type="button" class="btn" onclick="closeModal('deleteModal')" style="background: #999; color: white;">Annuler</button>
                    <button type="submit" class="btn btn-delete">Supprimer</button>
                </form>
            </div>
        </div>
        
        <p style="margin-top: 30px; text-align: center;">
            <a href="admin.php" style="color: #007bff;">← Retour à l'administration</a>
        </p>
    </div>
    
    <script>
        const pages = <?php echo json_encode($pages); ?>;
        
        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
        }
        
        function openEditModal(id) {
            const page = pages.find(p => p.id == id);
            if (!page) return;
            
            document.getElementById('edit_id').value = page.id;
            document.getElementById('titre_edit').value = page.titre;
            document.getElementById('ordre_edit').value = page.ordre;
            document.getElementById('contenu_edit').value = page.contenu;
            document.getElementById('actif_edit').checked = page.actif == 1;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function confirmDelete(id) {
            document.getElementById('delete_id').value = id;
            document.getElementById('deleteModal').style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>
