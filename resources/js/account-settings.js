import '../css/account-settings.css';

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
});
