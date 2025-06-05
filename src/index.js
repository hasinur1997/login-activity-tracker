import { createRoot } from '@wordpress/element';

import App from './App.jsx';

import menuFix  from './utils/admin-menu.js';

document.addEventListener('DOMContentLoaded', () => {
    const root = document.getElementById('login-activity-tracker');
    if (root) {
        createRoot(root).render(<App />);
    }
});

menuFix('login-activity-tracker');