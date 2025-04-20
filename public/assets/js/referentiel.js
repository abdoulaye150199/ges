async function searchReferentiels(query) {
    try {
        const response = await fetch(`?page=search_referentiels&q=${encodeURIComponent(query)}`);
        const referentiels = await response.json();
        updateReferentielsGrid(referentiels);
    } catch (error) {
        console.error('Erreur lors de la recherche:', error);
    }
}

function updateReferentielsGrid(referentiels) {
    const grid = document.getElementById('referentiels-grid');
    grid.innerHTML = referentiels.map(ref => `
        <div class="referentiel-card" data-id="${ref.id}">
            <div class="card-image" style="background-image: url('assets/images/${ref.image || 'default.jpg'}');">
            </div>
            <div class="card-content">
                <h3 class="card-title" style="color: #3498db;">${escapeHtml(ref.name)}</h3>
                <div class="card-subtitle">
                    <span class="modules-count">${(ref.modules || []).length} modules</span>
                </div>
                <p class="card-description">${escapeHtml(ref.description)}</p>
                <div class="card-footer">
                    <div class="student-count">
                        <i class="icon">👤</i>
                        <span>${(ref.apprenants || []).length} apprenants</span>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}