<div class="container">
    <div class="header">
        <div class="header-title">
            <h1>Promotion</h1>
            <div class="header-subtitle">Gérer les promotions de l'école</div>
        </div>
        <button class="add-button">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Ajouter une promotion
        </button>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div>
                <div class="stat-number">0</div>
                <div class="stat-label">Apprenants</div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="white">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-number">5</div>
                <div class="stat-label">Référentiels</div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="white">
                    <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5-1.95 0-4.05.4-5.5 1.5v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-number">1</div>
                <div class="stat-label">Promotions actives</div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="white">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-number">5</div>
                <div class="stat-label">Total promotions</div>
            </div>
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="white">
                    <path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V8h16v10z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="search-filter">
        <div class="search-bar">
            <span class="search-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </span>
            <form action="?page=promotions" method="GET">
                <input type="hidden" name="page" value="promotions">
                <input type="text" name="search" placeholder="Rechercher une promotion..." value="<?= htmlspecialchars($search ?? '') ?>">
            </form>
        </div>
        <div class="filter-container">
            <select class="filter-dropdown">
                <option>Tous</option>
            </select>
            <div class="view-toggle">
                <button class="view-button active" onclick="switchView('grid')">Grille</button>
                <button class="view-button" onclick="switchView('list')">Liste</button>
            </div>
        </div>
    </div>

    <div class="promotions-grid">
        <div class="promotion-card">
            <div class="status-container">
                <div class="status-badge inactive">Inactive</div>
                <div class="power-icon green">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                        <line x1="12" y1="2" x2="12" y2="12"></line>
                    </svg>
                </div>
            </div>
            <img src="/api/placeholder/60/60" alt="Promotion 2025" class="promotion-avatar">
            <div class="promotion-title">Promotion 2025</div>
            <div class="promotion-date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                04/02/2025 - 04/12/2025
            </div>
            <div class="promotion-students">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                2 apprenants
            </div>
            <a href="#" class="view-details">
                Voir détails
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
        </div>

        <div class="promotion-card">
            <div class="status-container">
                <div class="status-badge active">Active</div>
                <div class="power-icon red">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                        <line x1="12" y1="2" x2="12" y2="12"></line>
                    </svg>
                </div>
            </div>
            <img src="/api/placeholder/60/60" alt="Promotion 2017" class="promotion-avatar">
            <div class="promotion-title">Promotion 2017</div>
            <div class="promotion-date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                04/02/2017 - 04/12/2017
            </div>
            <div class="promotion-students">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                0 apprenants
            </div>
            <a href="#" class="view-details">
                Voir détails
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
        </div>

        <div class="promotion-card">
            <div class="status-container">
                <div class="status-badge inactive">Inactive</div>
                <div class="power-icon green">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                        <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                        <line x1="12" y1="2" x2="12" y2="12"></line>
                    </svg>
                </div>
            </div>
            <img src="/api/placeholder/60/60" alt="Promotion 2018" class="promotion-avatar">
            <div class="promotion-title">Promotion 2018</div>
            <div class="promotion-date">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                04/02/2018 - 04/12/2018
            </div>
            <div class="promotion-students">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                0 apprenants
            </div>
            <a href="#" class="view-details">
                Voir détails
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </a>
        </div>
    </div>

    <div class="promotions-list">
        <div class="promotion-card-list">
            <div class="promotion-list-left">
                <img src="/api/placeholder/60/60" alt="Promotion 2025" class="promotion-avatar">
                <div class="promotion-list-middle">
                    <div class="promotion-title">Promotion 2025</div>
                    <div class="promotion-date">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        04/02/2025 - 04/12/2025
                    </div>
                    <div class="promotion-students">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        2 apprenants
                    </div>
                </div>
            </div>
            <div class="promotion-list-right">
                <div class="status-container">
                    <div class="status-badge inactive">Inactive</div>
                    <div class="power-icon green">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                            <line x1="12" y1="2" x2="12" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <a href="#" class="view-details">
                    Voir détails
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
        </div>

        <div class="promotion-card-list">
            <div class="promotion-list-left">
                <img src="/api/placeholder/60/60" alt="Promotion 2017" class="promotion-avatar">
                <div class="promotion-list-middle">
                    <div class="promotion-title">Promotion 2017</div>
                    <div class="promotion-date">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        04/02/2017 - 04/12/2017
                    </div>
                    <div class="promotion-students">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        0 apprenants
                    </div>
                </div>
            </div>
            <div class="promotion-list-right">
                <div class="status-container">
                    <div class="status-badge active">Active</div>
                    <div class="power-icon red">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2">
                            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                            <line x1="12" y1="2" x2="12" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <a href="#" class="view-details">
                    Voir détails
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
        </div>

        <div class="promotion-card-list">
            <div class="promotion-list-left">
                <img src="/api/placeholder/60/60" alt="Promotion 2018" class="promotion-avatar">
                <div class="promotion-list-middle">
                    <div class="promotion-title">Promotion 2018</div>
                    <div class="promotion-date">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        04/02/2018 - 04/12/2018
                    </div>
                    <div class="promotion-students">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        0 apprenants
                    </div>
                </div>
            </div>
            <div class="promotion-list-right">
                <div class="status-container">
                    <div class="status-badge inactive">Inactive</div>
                    <div class="power-icon green">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                            <path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path>
                            <line x1="12" y1="2" x2="12" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <a href="#" class="view-details">
                    Voir détails
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f97316" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function switchView(view) {
        const container = document.querySelector('.container');
        const buttons = document.querySelectorAll('.view-button');
        
        buttons.forEach(button => button.classList.remove('active'));
        if (view === 'list') {
            container.classList.add('show-list');
            document.querySelector('.view-button[onclick="switchView(\'list\')"]').classList.add('active');
        } else {
            container.classList.remove('show-list');
            document.querySelector('.view-button[onclick="switchView(\'grid\')"]').classList.add('active');
        }
    }
</script>
