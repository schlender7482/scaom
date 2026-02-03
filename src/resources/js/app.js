/*
|--------------------------------------------------------------------------
| JavaScript Principal
|--------------------------------------------------------------------------
| Aqui importamos o Bootstrap JS e outros scripts necessários.
|
*/

// Importar Bootstrap JS (necessário para componentes interativos)
// Como: dropdowns, modals, tooltips, etc.
import * as bootstrap from 'bootstrap';

// Disponibilizar globalmente (útil para usar em scripts inline)
window.bootstrap = bootstrap;

// ========== CONFIGURAÇÕES GLOBAIS ==========

// Token CSRF para requisições AJAX
// O Laravel requer isso para segurança em formulários
const csrfToken = document.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    window.axios = require('axios');
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}

// ========== FUNÇÕES UTILITÁRIAS ==========

// Função para mostrar toast de notificação
window.showToast = function(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
};