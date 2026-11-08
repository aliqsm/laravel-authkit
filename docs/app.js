// -------------------------------------
// Load Page
// -------------------------------------
async function loadPage(page, updateHistory = true) {
    const content = document.getElementById('page-content');

    try {
        const response = await fetch(`pages/${page}.html`);

        if (!response.ok) throw new Error('Page not found');

        const html = await response.text();
        content.innerHTML = html;

        const title = content.querySelector('[data-title]')?.dataset.title || 'مستندات';

        document.getElementById('page-title').textContent = title;
        document.title = `${title} | Laravel AuthKit`;

        if (updateHistory) {
            history.pushState({ page }, '', `?page=${page}`);
        }

        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.classList.toggle('active', link.dataset.page === page);
        });

        if (location.hash) {
            requestAnimationFrame(() => {
                const target = document.querySelector(location.hash);
                if (target) {
                    const top = target.getBoundingClientRect().top + window.scrollY - 30;
                    window.scrollTo({
                        top,
                        behavior: 'smooth'
                    });
                }
            });
        } else {
            window.scrollTo(0, 0);
        }

    } catch {
        content.innerHTML = `
            <div class="alert alert-danger">
                صفحه موردنظر پیدا نشد.
            </div>
        `;
    }
}


// -------------------------------------
// Page Navigation
// -------------------------------------
document.addEventListener('click', event => {
    const link = event.target.closest('a[data-page]');

    if (!link) return;

    event.preventDefault();

    loadPage(link.dataset.page);

    closeSidebar();
});


// -------------------------------------
// Browser History
// -------------------------------------
window.addEventListener('popstate', () => {
    const page = new URLSearchParams(location.search).get('page') || 'introduction';

    loadPage(page, false);
});


// -------------------------------------
// Sidebar
// -------------------------------------
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');

function openSidebar() {
    sidebar?.classList.add('show');
    overlay?.classList.add('show');
}

function closeSidebar() {
    sidebar?.classList.remove('show');
    overlay?.classList.remove('show');
}

function initSidebar() {
    document.getElementById('menuToggle')?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
}


// -------------------------------------
// Theme
// -------------------------------------
function initTheme() {
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');

    const savedTheme = localStorage.getItem('authkit-docs-theme') || 'light';

    function setTheme(theme) {
        html.setAttribute('data-bs-theme', theme);

        moonIcon?.classList.toggle('d-none', theme === 'dark');
        sunIcon?.classList.toggle('d-none', theme === 'light');

        localStorage.setItem('authkit-docs-theme', theme);
    }

    themeToggle?.addEventListener('click', () => {
        const currentTheme = html.getAttribute('data-bs-theme');

        setTheme(currentTheme === 'dark' ? 'light' : 'dark');
    });

    setTheme(savedTheme);
}


// -------------------------------------
// Initialize
// -------------------------------------
const initialPage = new URLSearchParams(location.search).get('page') || 'introduction';

loadPage(initialPage, false);

initSidebar();
initTheme();