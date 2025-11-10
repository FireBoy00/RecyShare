import '../css/account-settings.css';

// Mobile sidebar toggle (burger menu)
document.addEventListener('DOMContentLoaded', () => {
	const burger = document.querySelector('.burger-toggle');
	const sidebar = document.querySelector('.left-sidebar');
	const overlay = document.createElement('div');
	overlay.className = 'sidebar-overlay';
	document.body.appendChild(overlay);

	function openSidebar() {
		if (sidebar) sidebar.classList.add('open');
		overlay.classList.add('visible');
		document.body.classList.add('no-scroll');
	}

	function closeSidebar() {
		if (sidebar) sidebar.classList.remove('open');
		overlay.classList.remove('visible');
		document.body.classList.remove('no-scroll');
	}

	if (burger && sidebar) {
		burger.addEventListener('click', () => {
			if (sidebar.classList.contains('open')) closeSidebar();
			else openSidebar();
		});
	}

	overlay.addEventListener('click', closeSidebar);

	// Close sidebar when a nav item is clicked (mobile)
	document.addEventListener('click', (e) => {
		const target = e.target;
		if (target && target.closest && target.closest('.sidebar-nav .nav-item')) {
			if (window.innerWidth <= 900) closeSidebar();
		}
	});
});

// Tab behavior for the account settings page
document.addEventListener('DOMContentLoaded', function () {
	const items = document.querySelectorAll('.sidebar-nav .nav-item');
	const panels = document.querySelectorAll('.tab-panel');
	const sectionTitle = document.querySelector('.section-title');

	function activate(targetId) {
		items.forEach(i => i.classList.toggle('active', i.dataset.target === targetId));
		panels.forEach(p => p.classList.toggle('hidden', p.id !== targetId));

		// Adjust main title for profile/account tabs
		if (sectionTitle) {
			if (targetId === 'profile' || targetId === 'account') {
				sectionTitle.textContent = 'Profile Information';
			} else if (targetId === 'shared') {
				sectionTitle.textContent = 'Your Shared Recipes';
			} else if (targetId === 'favorites') {
				sectionTitle.textContent = 'Favorites';
			}
		}
	}

	items.forEach(item => {
		item.addEventListener('click', () => {
			const target = item.dataset.target;
			if (!target) return;
			activate(target);
		});
	});

	// Initialize default active tab (profile)
	activate('profile');

	// Remove card behaviour (client-side)
	document.addEventListener('click', (e) => {
		const btn = e.target.closest && e.target.closest('.remove-btn');
		if (!btn) return;
		const wrapper = btn.closest('.card-wrapper');
		if (!wrapper) return;
		// simple confirm
		if (confirm('Remove this recipe from the list?')) {
			wrapper.remove();
		}
	});
});
