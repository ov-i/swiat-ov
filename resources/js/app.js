import './bootstrap';

Livewire.on('app.theme-change', ([{ theme }]) => {
  if (localStorage.getItem('theme') === theme) return;

  const html = document.querySelector('html');
  html.setAttribute('data-theme', theme);

  localStorage.setItem('theme', theme);

  // Livewire.dispatch('app.alert', 'theme changed');
})
