import './bootstrap';

Livewire.on('app.theme-change', ([{ theme }]) => {
  const htmlTag = document.querySelector('html');

  if (htmlTag.classList.contains('light')) {
    htmlTag.classList.remove('light');
  }
  htmlTag.classList.toggle(theme === 'dark' ? 'light' : 'dark');

  location.reload()
})