<div class="referentiels-container">
    <div class="header">
        <h1>Référentiels</h1>
        <p class="subtitle">Gérer les référentiels de la promotion</p>
    </div>

    <div class="search-actions">
        <div class="search-bar">
            <i class="search-icon">🔍</i>
            <input type="text" 
                   placeholder="Rechercher un référentiel..." 
                   onkeyup="searchReferentiels(this.value)">
        </div>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="showAllReferentiels()">
                <i class="icon">📋</i>
                Tous les référentiels
            </button>
            <button class="btn btn-success" onclick="addToPromotion()">
                <i class="icon">+</i>
                Ajouter à la promotion
            </button>
        </div>
    </div>

    <div id="referentiels-grid" class="referentiels-grid">
        <?php foreach ($referentiels as $ref): ?>
            <div class="referentiel-card" data-id="<?= $ref['id'] ?>">
                <div class="card-image" style="background-image: url('assets/images/<?= $ref['image'] ?? 'default.jpg' ?>');">
                </div>
                <div class="card-content">
                    <h3 class="card-title" style="color: #3498db;"><?= htmlspecialchars($ref['name']) ?></h3>
                    <div class="card-subtitle">
                        <span class="modules-count"><?= count($ref['modules'] ?? []) ?> modules</span>
                    </div>
                    <p class="card-description"><?= htmlspecialchars($ref['description']) ?></p>
                    <div class="card-footer">
                        <div class="student-count">
                            <i class="icon">👤</i>
                            <span><?= count($ref['apprenants'] ?? []) ?> apprenants</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>